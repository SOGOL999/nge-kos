<?php

namespace App\Http\Controllers;

use App\Models\Bedroom;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //REGISTER
    function register()
    {
        return view('auth.register');
    }

    function store(Request $request)
    {
        $validation = $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|unique:users', //make unique user
            'password' => ['required', 'confirmed', 'min:8'] //min 8 character and confirm password
        ]);

        $validation['password'] = password_hash($validation['password'], PASSWORD_BCRYPT);

        User::create($validation);

        $message = [
            "message"      => "You have successfully created an account, please login to enter the page.",
            "type-message" => "success",
        ];

        return redirect()->route('auth.login')->with($message);
    }

    //LOGIN
    function login()
    {
        return view(('auth.login'));
    }

    function authentication(Request $request)
    {
        $validation = $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($validation)) {
            //mencoba masuk menggunakan email dan password dari form login dan sudah ada pengecekan dari tabel user

            $request->session()->regenerate();
            //session untuk sesi log out dan log in agar lebih hidup

            $message = [
                "message"      => "You are logged in successfully.",
                "type-message" => "success",
            ];

            return redirect()->intended('dashboard')->with($message);
            //redirect jika user berhasil login maka akan masuk ke dashboard yang dimasukkan
        }

        return redirect()->route('auth.login');
    }

    //SESI LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }

    //Inactive Account
    function inactive_account()
    {
        $user = User::find(Auth::user()->id);

        $user->room->update(['status' => 'available']);
        $user->update([
            'bedroom_user_id' => NULL,
            'check_in'        => NULL,
            'user_status'     => NULL,
        ]);

        Auth::logout();

        $message = [
            "message"      => "Your account was successfully Deactived, see you soon!",
            "type-message" => "success",
        ];

        return redirect('/')->with($message);
    }


    //Dashboard
    function dashboard()
    {
        $month = now()->month;

        $bedroom_total = User::whereNotNull('bedroom_user_id')->whereMonth('created_at', $month)->count();
        
        $bedroom_count = Bedroom::whereHas('booking', function ($query) use ($month) {
            $query->where('status', 'paid')->whereMonth('created_at', $month);
        })->sum('price');

        $customer_total = User::where('user_status', 'active')->whereMonth('created_at', $month)->count();

        $booking_data = Booking::with('user', 'bedroom')->whereMonth('created_at', $month)->get();

        $bedroom_available = Bedroom::where('status', 'available')->count();

        return view('page.dashboard', compact('bedroom_count', 'bedroom_total', 'customer_total', 'booking_data', 'bedroom_available'));
    }
}
