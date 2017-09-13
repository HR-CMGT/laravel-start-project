<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return ('A list of all users');
    }
    public function create() {
        return view('user.create');
    }

    public function store(Request $request) {

        $request->validate([
            'firstname' => 'required|min:2'
        ]);

        return redirect('/users');
    }
}
