<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:planner,vendor'],
            'vendor_type' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'city' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'price' => ['required_if:role,vendor', 'nullable', 'numeric', 'min:0'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'vendor') {
            Vendor::create([
                'user_id' => $user->_id,
                'name' => $request->name,
                'vendor_type' => $request->vendor_type,
                'city' => $request->city,
                'price' => (int) $request->price,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        $home = $user->role === 'vendor'
            ? route('vendor.bookings', absolute: false)
            : route('dashboard', absolute: false);

        return redirect($home);
    }
}
