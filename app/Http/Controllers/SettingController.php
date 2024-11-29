<?php

namespace App\Http\Controllers;

use App\Models\Bedroom;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use function PHPUnit\Framework\fileExists;

class SettingController extends Controller
{
    //--------------------- CreateProfile ---------------------//
    function index()
    {
        if (empty(Auth::user()->phone)) {
            return redirect()->route('profile.form');
        } else {
            return redirect()->route('profile.show');
        }
    }

    function show()
    {
        return view('settings.users_profile');
    }

    function form()
    {
        return view('settings.form_profile');
    }

    function add(Request $request)
    {
        $validation = $request->validate([
            "profile" => "sometimes|image|mimes:jpeg,png,jpg",
            "name"    => "required",
            "email"   => "required",
            "phone"   => "required",
            "address" => "required",
            "city"    => "required",
            "state"   => "required",
        ]);

        if ($request->hasFile('profile')) {

            $file = $request->file("profile");
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("uploads/profile/"), $file_name);

            $validation['profile'] = $file_name;
        }

        User::find(Auth::user()->id)->update($validation);

        $message = [
            "message"      => "You successfully added a profile!",
            "type-message" => "info",
        ];

        return redirect()->route('profile.show')->with($message);
    }
    //--------------------- EndProfile ---------------------//


    //--------------------- ImageProfile ---------------------//
    public function uploadImage(Request $request)
    {
        $validation = $request->validate([
            "profile" => "sometimes|image|mimes:jpeg,png,jpg",
            'name'    => 'sometimes|required',
            'phone'   => 'sometimes',
            'address' => 'sometimes',
            'city'    => 'sometimes',
            'state'   => 'sometimes',
            'email'   => 'sometimes|required',
        ]);

        $user = User::find(Auth::user()->id);

        if ($request->has('deleteImage')) {
            if (!empty($user->profile)) {
                $file_path = public_path('uploads/profile/' . $user->profile);

                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $user->profile = NULL;
            $user->save();

            $message = [
                "message"      => "Your profile picture you successfully deleted!",
                "type-message" => "success",
            ];

            return redirect()->route('profile.show')->with($message);
        }

        if ($request->hasFile('profile')) {

            $file_path = public_path("uploads/profile/" . $user->profile);

            if (!empty($user->profile)) {
                if (!empty(file_exists($file_path))) {
                    unlink($file_path);
                }
            }

            $file = $request->file("profile");
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("uploads/profile/"), $file_name);

            $validation['profile'] = $file_name;
        }

        User::find(Auth::user()->id)->update($validation);

        $message = [
            "message"      => "Your profile has been changed successfully!",
            "type-message" => "success",
        ];

        return redirect()->route('profile.show')->with($message);
    }
    //--------------------- EndImage ---------------------//


    //--------------------- NewPassword ---------------------//
    function newPassword(Request $request)
    {
        $validation = $request->validate([
            "password" => "required|confirmed|min:8"
        ]);

        User::find(Auth::user()->id)->update([
            'password' => Hash::make($validation['password']),
        ]);

        $message = [
            "message"      => "You managed to change the password, make sure you remember it!",
            "type-message" => "info",
        ];

        return redirect()->route('profile.show')->with($message);
    }
    //--------------------- EndPassword ---------------------//


    //--------------------- Dashboard Admin ---------------------//
    public function chartRevenue(Request $request)
    {
        $month = $request->input('month') ?: Carbon::now()->month;

        // Mengambil total pendapatan berdasarkan jumlah pemesanan dan harga kamar
        $revenueData = Bedroom::with('booking')
            ->select('id', 'name', 'price')  // Memilih kolom `price` dari `Bedroom`
            ->withCount(['booking as total_customers' => function ($query) use ($month) {
                $query->whereMonth('created_at', $month);
            }])
            ->get()
            ->map(function ($bedroom) use ($month) {
                // Menambahkan perhitungan `total_revenue` dengan harga kamar * jumlah pemesanan
                $bedroom->total_revenue = $bedroom->price * $bedroom->total_customers;
                return $bedroom;
            });

        $total_customer = User::where('role', 'customer')->where('user_status', 'active')->count();

        $data = [
            'label' => $revenueData->pluck('name'),
            'revenue' => $revenueData->pluck('total_revenue'),
            'customer' => $total_customer
        ];

        return response()->json($data);
    }
}
