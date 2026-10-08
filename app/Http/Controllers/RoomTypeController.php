<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Admins manage the list of accommodation types.
 */
class RoomTypeController extends Controller
{
    public function index()
    {
        $usage = Accommodation::select('Type', DB::raw('COUNT(*) as total'))->groupBy('Type')->pluck('total', 'Type');

        return view('admin.room-types', [
            'types' => RoomType::orderBy('sort_order')->orderBy('name')->get(),
            'usage' => $usage,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('room_types', 'name')],
        ]);

        RoomType::create($data + ['sort_order' => (int) RoomType::max('sort_order') + 1]);

        return back()->with('success', "Added the type \"{$data['name']}\".");
    }

    /** Renaming a type also renames it on every listing that uses it. */
    public function update(Request $request, RoomType $roomType)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('room_types', 'name')->ignore($roomType->RoomTypeID, 'RoomTypeID')],
        ]);

        $old = $roomType->name;

        DB::transaction(function () use ($roomType, $data, $old) {
            $roomType->update($data);
            Accommodation::where('Type', $old)->update(['Type' => $data['name']]);
        });

        return back()->with('success', "Renamed \"{$old}\" to \"{$data['name']}\".");
    }

    public function destroy(RoomType $roomType)
    {
        if (Accommodation::where('Type', $roomType->name)->exists()) {
            return back()->with('error', "\"{$roomType->name}\" is used by existing listings. Rename it, or change those listings first.");
        }

        if (RoomType::count() <= 1) {
            return back()->with('error', 'At least one accommodation type must remain, or no listing could be created.');
        }

        $roomType->delete();

        return back()->with('success', 'Type deleted.');
    }
}
