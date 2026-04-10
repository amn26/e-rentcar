<?php

namespace App\Http\Controllers;

use App\Models\Car;

class CarController extends Controller
{
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }
}
