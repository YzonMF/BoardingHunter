<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Photo;

class AccommodationController extends Controller
{
    /**
     * Display a listing of the resource.
     * (READ - show all accommodations)
     */
    public function index()
    {
        $Accommodations = Accommodation::with('photo')->get();
        return view('Accommodations.index', compact('Accommodations'));
    }

    public function show($id)
    {
        $Accommodation = Accommodation::with('photo')->findOrFail($id);
        return view('Accommodations.index', compact('Accommodation'));
    }

public function create(){
    return view('Accommodation.create');
}

public function store(){
   $Accommodation  = new Accommodation;
   $Accommodation ->accommodationID = request()->accommodationID;
   $Accommodation ->name = request()->name;
   $Accommodation ->description = request()->description;
   $Accommodation ->location = request()->location;
   $Accommodation ->pricepernight = request()->pricepernight;
   $Accommodation ->pricepermonth = request()->pricepermonth;
   $Accommodation ->photoID = request()->photoID;
   $Accommodation->save();

    return redirect('/Accommodation');
}

// edit
public function edit(Accommodation $Accommodation)
{
        return view('Accommodation.edit', compact('Accommodation'));
}
public function update(Accommodation $Accommodation){
   $Accommodation ->accommodationID = request()->accommodationID;
   $Accommodation ->name = request()->name;
   $Accommodation ->description = request()->description;
   $Accommodation ->location = request()->location;
   $Accommodation ->pricepernight = request()->pricepernight;
   $Accommodation ->pricepermonth = request()->pricepermonth;
   $Accommodation ->photoID = request()->photoID;
   $Accommodation->save();

    return redirect('/Accommodation');
}

// delete
public function destroy(Accommodation $Accommodation){
    $Accommodation->delete();
    return redirect('/Accommodation');
}

}



