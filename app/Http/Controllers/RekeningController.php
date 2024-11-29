<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index()
    {
        return view('booking.transaction', [
            "rekening" => Rekening::get()
        ]);
    }

    public function edit()
    {
        return view('rekening.form-edit', [
            "rekening" => Rekening::first()
        ]);
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            "rekening" => "required"
        ]);

        Rekening::updateOrCreate(['id' => 1], $validation);

        return redirect()->route('rekening.edit');
    }
}
