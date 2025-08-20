<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Redirection après login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        // Si username contient '@dmin' ou si le rôle = admin → redirection admin
        if (str_contains($user->username, '@dmin') || $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Sinon → redirection utilisateur
        return redirect()->route('dashboard');
    }
}
