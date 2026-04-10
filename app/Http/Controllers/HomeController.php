<?php

namespace App\Http\Controllers;

use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Car::where('Status', 1)->where('IsDeleted', 0)->get();
        return view('home', compact('cars'));
    }
}
