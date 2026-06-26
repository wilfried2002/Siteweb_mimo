<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('employee.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Identifiants invalides.'])->onlyInput('email');
        }

        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return $this->redirectByRole($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('employee.login');
    }

    private function redirectByRole($user)
    {
        return match ($user->role?->name) {
            'commercial'  => redirect()->route('employee.commercial.orders.index'),
            'magasinier'  => redirect()->route('employee.magasinier.orders.index'),
            'rh'          => redirect()->route('employee.rh.applications.index'),
            default       => redirect()->route('employee.login')->withErrors(['email' => 'Rôle non configuré.']),
        };
    }
}
