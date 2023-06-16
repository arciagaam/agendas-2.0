<?php

namespace App\Http\Controllers;

use App\Actions\AuthenticationActions;
use App\Http\Requests\AuthenticateRequest;
use App\Services\AuthenticationService;
use App\Services\AuthenticationServices;

class AuthenticationController extends Controller
{

    public function userLogin() {
        return view('pages.authentication.user-login');
    }

    public function adminLogin() {
        return view('pages.authentication.admin-login');
    }

    public function authenticate(AuthenticateRequest $request, AuthenticationActions $action) {
        if(auth()->attempt($request->validated())) {
            session()->regenerate();

            if(!$action->checkValidLogin()) {
                return $this->logout('Invalid Credentials');
            }

            return redirect()->intended(auth()->user()->user_type_id == 1 ? '/admin/dashboard' : '/dashboard');
        }
    }

    public function logout($errorMessage = null) {
        $route = str_contains(url()->previous(), 'admin') ? '/admin' : '/';

        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        if($errorMessage) {
            return redirect($route)->with('error', $errorMessage);
        } else {
            return redirect($route);
        }
    }
}
