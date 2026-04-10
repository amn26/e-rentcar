<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::where('IsDeleted', 0)->get();
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'brand' => 'required|max:50',
            'year' => 'required|integer',
            'plate_number' => 'required|unique:cars',
            'price_per_day' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'stnk_number' => 'required',
            'stnk_expired_date' => 'required|date',
            'pajak_expired_date' => 'required|date',
            'warna' => 'required',
            'bahan_bakar' => 'required',
            'transmisi' => 'required',
            'kapasitas_penumpang' => 'required|integer',
            'kondisi' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        $validated['id'] = 'CAR' . strtoupper(Str::random(7));

        Car::create($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Car added successfully');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->update(['IsDeleted' => 1]);
        return back()->with('success', 'Car deleted successfully');
    }
}
