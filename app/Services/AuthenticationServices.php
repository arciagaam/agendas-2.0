<?php

namespace App\Services;

use App\Actions\AuthenticationActions;

class AuthenticationServices {
    private $authAction;

    public function __construct(AuthenticationActions $action) {
        $this->authAction = $action;
    }

}