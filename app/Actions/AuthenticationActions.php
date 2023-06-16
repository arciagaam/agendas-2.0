<?php
namespace App\Actions;

class AuthenticationActions {

    public function checkValidLogin() : bool {
        return !((str_contains(url()->previous(), 'admin') && auth()->user()->user_type_id != 1) || (!str_contains(url()->previous(), 'admin') && auth()->user()->user_type_id == 1));
    }
}