<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Nanti disini load data kendaraan
        return view('home');
    }
}