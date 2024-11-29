<?php

namespace App\Http\Controllers;

use App\Models\Bedroom;
use Illuminate\Http\Request;

class BedroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bedroom.data', [
            "bedroom" => Bedroom::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bedroom.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "name"    => "required",
            "price"   => "required",
            "picture" => "required|image|mimes:jpeg,png,jpg",
        ]);

        if ($request->hasFile("picture")) {

            $file = $request->file("picture");

            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bedroom/'), $file_name);

            $validation["picture"] = $file_name;
        }

        Bedroom::create($validation);

        $message = [
            "message"      => "Data added successfully",
            "type-message" => "success",
        ];

        return redirect()->route("bedroom.index")->with($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('bedroom.form-edit', [
            "see" => Bedroom::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            "name"    => "required",
            "price"   => "required",
            "picture" => "sometimes|image|mimes:jpeg,png,jpg",
        ]);

        $bedroom = Bedroom::find($id);

        if ($request->hasFile('picture')) {

            $file_path = public_path("uploads/bedroom/" . $bedroom->picture);
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $file = $request->file("picture");
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("uploads/bedroom/"), $file_name);

            $validation['picture'] = $file_name;
        }

        $bedroom->update($validation);

        $message = [
            "message"      => "Data Berhasil Ditambahkan",
            "type-message" => "success",
        ];

        return redirect()->route("bedroom.index")->with($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bedroom = Bedroom::find($id);

        $file_path = public_path("uploads/bedroom/" . $bedroom->picture);

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $bedroom->delete();

        return redirect()->route("bedroom.index");
    }
}
