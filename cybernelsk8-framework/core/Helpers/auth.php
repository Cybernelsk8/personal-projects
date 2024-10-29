<?php

use Core\Auth\Auth;
use Core\Auth\Authenticatable;

function auth() :?Authenticatable {
    return Auth::user();
}

function isGuest() : bool {
    return Auth::isGuest();
}