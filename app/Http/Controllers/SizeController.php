<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::latest()->paginate(10);
        return view('sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sizes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price_adjustment'=>'required|numeric'
        ]);

        Size::create($request->all());

        return redirect()->route('sizes.index')
            ->with('success','Size created');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view('sizes.form', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
       $request->validate([
            'name'=>'required',
            'price_adjustment'=>'required|numeric'
        ]);

        $size->update($request->all());

        return redirect()->route('sizes.index')
            ->with('success','Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
          $size->delete();
        return back()->with('success','Deleted');
    }
}
