<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Room owners add and remove amenities on their own listings.
 */
class AmenityController extends Controller
{
    public function store(Request $request, Accommodation $accommodation)
    {
        $this->authorizeOwner($accommodation);

        $data = $request->validate([
            'AmenityName' => 'required|string|max:100',
            'Description' => 'nullable|string|max:500',
        ]);

        $exists = $accommodation->amenities()->whereRaw('LOWER(AmenityName) = ?', [mb_strtolower($data['AmenityName'])])->exists();

        if ($exists) {
            return back()->withErrors(['AmenityName' => 'This amenity is already listed.'])->withInput();
        }

        $accommodation->amenities()->create($data);

        return back()->with('success', 'Amenity added.');
    }

    public function destroy(Accommodation $accommodation, Amenity $amenity)
    {
        $this->authorizeOwner($accommodation);
        abort_unless($amenity->AccommodationID === $accommodation->AccommodationID, 404);

        $amenity->delete();

        return back()->with('success', 'Amenity removed.');
    }

    private function authorizeOwner(Accommodation $accommodation): void
    {
        abort_unless($accommodation->OwnerID === Auth::id(), 403);
    }
}
