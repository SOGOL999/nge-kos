<?php

namespace App\Http\Controllers;

use App\Models\Bedroom;
use App\Models\Booking;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    //Payment POV admin
    function index_admin()
    {
        $booking = Booking::with(['user', 'bedroom'])->orderby('status', 'DESC')->get();

        return view('payment.data', [
            "booking" => $booking
        ]);
    }

    //View bedroom at booking
    function index()
    {
        return view('booking.data', [
            "bedroom" => Bedroom::orderby('status', 'ASC')->get(),
        ]);
    }

    //Send id bedroom at transaction
    function transaction($id)
    {
        Bedroom::find($id);

        return view('booking.transaction', [
            'bedroom_id' => $id,
            'rekening' => Rekening::first(),
        ]);
    }

    //transaction
    function store(Request $request)
    {
        $validation = $request->validate([
            "bedroom_id"     => "required",
            "payment_proof"  => "required|image|mimes:jpeg,jpg,png",
        ]);

        $validation['user_id'] = Auth::user()->id;
        $validation['payment_date'] = date('Y-m-d');
        $validation['payment_period'] = date('Y-m');
        $validation['status'] = "pending";

        if ($request->hasFile('payment_proof')) {

            $file = $request->file('payment_proof');

            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/booking/'), $file_name);

            $validation['payment_proof'] = $file_name;
        }

        Booking::create($validation);

        $message = [
            "message"      => "You have successfully paid, please wait for a response from the admin.",
            "type-message" => "success",
        ];

        return redirect()->route('booking.index')->with($message);
    }

    //Switch Status POV Admin
    function payment_status(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $user = $booking->user;
        $bedroom = $booking->bedroom;
        $booking->status = $request->input('status');
        $booking->save();

        if ($booking->status == "paid") {
            $user->bedroom_user_id = $booking->bedroom_id;
            $user->check_in = now();
            $user->user_status = 'active';
            $user->save();

            $bedroom->status = 'unavailable';
            $bedroom->save();

            //message received payment from customer
            $message = [
                "message"      => "You Successfully Received Payment",
                "type-message" => "success",
            ];
        }

        if ($booking->status == "rejected") {
            $message = [
                "message"      => "You Successfully Declined Payment",
                "type-message" => "warning",
            ];
        }

        return redirect()->route('index_admin')->with($message);
    }
    //------------================================------------//

    //bedroom_detail
    public function bedroom_detail()
    {
        $booking = Booking::where('user_id', Auth::user()->id)->get();

        $message = [
            "message"      => "You don't have a room yet, please book in advance!",
            "type-message" => "info",
        ];

        if (empty(Auth::user()->bedroom_user_id)) {
            return redirect()->back()->with($message);
        }

        return view('page.bedroom_detail', [
            "bedroom"      => Bedroom::find(Auth::user()->bedroom_user_id),
            "booking"      => $booking,
            "rekening"     => Rekening::first(),
        ]);
    }
}
