<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Exceptions\IncorrectMailException;
use App\Exceptions\IncorrectPasswordException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('login', [
            'error' => false
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        try{
            $admin = User::where(['email' => $request->email])->first();
            if(!$admin)
            {
                throw new IncorrectMailException();
            }
            else if(!Hash::check($request->password, $admin->makeVisible('password')->password))
            {
                throw new IncorrectPasswordException();
            }
            else
            {
                $request->authenticate();
                $request->session()->regenerate();
                return redirect()->intended(RouteServiceProvider::ADMIN);
            }
        }
        catch(IncorrectMailException $e)
        {
            return response(view('login', ['error' => $e]), 401);
        }
        catch(IncorrectPasswordException $e)
        {
            return response(view('login', ['error' => $e]), 401);
        }


    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
