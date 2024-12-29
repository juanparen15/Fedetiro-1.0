<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Facades\Voyager;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('vendor.voyager.login');
    }

    public function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if ($user->password_temporal && Hash::check($request->password, $user->password_temporal)) {
            return redirect()->route('password.change');
        }

        return redirect()->route('voyager.users.edit', $user->id);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('username', $request->username)->first();

        if ($user) {
            if ($user->password_temporal && $request->password === $user->password_temporal) {
                Auth::login($user);
                return redirect()->route('password.change');
            } elseif (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
                return redirect()->route('voyager.users.edit', $user->id);
            } else {
                return back()->withErrors([
                    'password' => 'La contraseña proporcionada es incorrecta.',
                ]);
            }
        }
        return back()->withErrors([
            'username' => 'Estas credenciales no coinciden con nuestros registros o tu cuenta está inactiva.',
        ]);
    }

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->password_temporal = null;
        $user->save();

        return redirect()->route('voyager.users.edit', $user->id)->with([
            'message'    => '¡Contraseña actualizada con éxito!',
            'alert-type' => 'success',
        ]);
    }
}
