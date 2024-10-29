<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        try {
            $users = User::all();
            return response($users);
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}
