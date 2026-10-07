<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Amenity;
use App\Models\Photo;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Room owners manage their own accommodations and photos.
 */
class ListingController extends Controller
{
    /** Statuses an owner may set by hand; reserved/booked are managed by the system. */
    private const OWNER_STATUSES = ['active', 'available', 'inactive'];

    private const PHOTO_DIR = 'accommodations';

    public function index()
    {
        Reservation::expireOverdue();

        $listings = Accommodation::with('photos')
            ->where('OwnerID', Auth::id())
            ->orderByDesc('date_created')
            ->get();

        return view('listings.listindex', compact('listings'));
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $accommodation = Accommodation::create([
            'OwnerID' => Auth::id(),
            'status' => $data['status'],
        ] + collect($data)->except(['status', 'photos', 'captions', 'amenities'])->all());

        $this->savePhotos($request, $accommodation);

        foreach (preg_split('/\s*,\s*/', (string) $request->input('amenities'), -1, PREG_SPLIT_NO_EMPTY) as $name) {
            Amenity::create(['AccommodationID' => $accommodation->AccommodationID, 'AmenityName' => mb_substr($name, 0, 100)]);
        }

        return redirect()->route('listings.index')->with('success', 'Listing created.');
    }

    public function edit(Accommodation $accommodation)
    {
        $this->authorizeOwner($accommodation);
        Reservation::expireOverdue();

        return view('listings.edit', ['accommodation' => $accommodation->refresh()->load(['photos', 'amenities'])]);
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        $this->authorizeOwner($accommodation);
        Reservation::expireOverdue();
        $accommodation->refresh();

        $data = $request->validate($this->rules($accommodation));

        // While a room is reserved or booked the system owns its status.
        if (!in_array($accommodation->status, self::OWNER_STATUSES, true)) {
            unset($data['status']);
        }

        $accommodation->update(collect($data)->except(['photos', 'captions', 'amenities'])->all());

        $this->savePhotos($request, $accommodation);

        return redirect()->route('listings.index')->with('success', 'Listing updated.');
    }

    public function destroy(Accommodation $accommodation)
    {
        $this->authorizeOwner($accommodation);
        Reservation::expireOverdue();

        $hasOpenRequests = $accommodation->reservations()->whereIn('Status', ['Pending', 'Confirmed'])->exists()
            || $accommodation->bookings()->whereIn('Status', ['Pending', 'Confirmed'])->exists();

        if ($hasOpenRequests) {
            return back()->with('error', 'This listing has open reservations or bookings. Resolve them before deleting it.');
        }

        foreach ($accommodation->photos as $photo) {
            $photo->deleteStoredFile();
        }

        $accommodation->delete();

        return redirect()->route('listings.index')->with('success', 'Listing deleted.');
    }

    public function destroyPhoto(Accommodation $accommodation, Photo $photo)
    {
        $this->authorizeOwner($accommodation);
        abort_unless($photo->AccommodationID === $accommodation->AccommodationID, 404);

        $photo->deleteStoredFile();
        $photo->delete();

        return back()->with('success', 'Photo removed.');
    }

    private function rules(?Accommodation $accommodation = null): array
    {
        $statusRules = ['required', Rule::in(self::OWNER_STATUSES)];

        // A reserved/booked room keeps its system-managed status.
        if ($accommodation && !in_array($accommodation->status, self::OWNER_STATUSES, true)) {
            $statusRules = ['nullable'];
        }

        return [
            'Name' => 'required|string|max:100',
            'Type' => ['required', Rule::in(Accommodation::TYPES)],
            'Description' => 'required|string|max:5000',
            'Location' => 'required|string|max:255',
            'PricePerNight' => 'required|numeric|min:0|max:99999999',
            'PricePerMonth' => 'required|numeric|min:0|max:99999999',
            'status' => $statusRules,
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'amenities' => 'nullable|string|max:1000',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ];
    }

    private function savePhotos(Request $request, Accommodation $accommodation): void
    {
        foreach ($request->file('photos', []) as $i => $file) {
            $path = $file->store(self::PHOTO_DIR, 'public');

            Photo::create([
                'AccommodationID' => $accommodation->AccommodationID,
                'FilePathURL' => '/storage/' . $path,
                'Caption' => $request->input("captions.$i"),
            ]);
        }
    }

    private function authorizeOwner(Accommodation $accommodation): void
    {
        abort_unless($accommodation->OwnerID === Auth::id(), 403);
    }
}
