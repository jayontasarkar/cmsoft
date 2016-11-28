<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show Login Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Post Login form Data
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = (bool) $request->input('remember');

        if(Auth::attempt(['username' => $username, 'password' => $password, 'active' => 1], $remember))
        {
            alert()->success('You have Successfully logged in.', 'Welcome!');
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['message' => 'invalid username/password to login!'])->withInput($request->except('password'));
    }

    /**
     * Logout Link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        alert()->success('You have been logged out.', 'Good bye!');
        return redirect('/');
    }
}
