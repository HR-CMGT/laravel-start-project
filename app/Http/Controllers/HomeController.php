<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index() {
        return view('home.index');
    }

    public function contact() {

        $email = 'name@mail.com';

        return view('home.contact', ['email' => $email]);
    }
}
