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
        $request->validate([
            'name' => 'required|max:50',
            'brand' => 'required|max:50',
            'year' => 'required|integer',
            'plate_number' => 'required|unique:cars',
            'price_per_day' => 'required|numeric',
            'stnk_number' => 'required',
            'stnk_expired_date' => 'required|date',
            'pajak_expired_date' => 'required|date',
            'warna' => 'required',
            'bahan_bakar' => 'required',
            'transmisi' => 'required',
            'kapasitas_penumpang' => 'required|integer',
            'kondisi' => 'required',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $errors = \App\Services\ImageValidator::validate($request->file('image'));
            if (!empty($errors)) {
                return back()->withErrors(['image' => implode(' ', $errors)])->withInput();
            }
            $data['image'] = \App\Services\ImageValidator::store($request->file('image'));
        }

        $data['id'] = 'CAR' . strtoupper(Str::random(7));

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Car added successfully');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->update(['IsDeleted' => 1]);
        return back()->with('success', 'Car deleted successfully');
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        
        $request->validate([
            'name' => 'required|max:50',
            'brand' => 'required|max:50',
            'year' => 'required|integer',
            'plate_number' => 'required|unique:cars,plate_number,' . $id . ',id',
            'price_per_day' => 'required|numeric',
            'stnk_number' => 'required',
            'stnk_expired_date' => 'required|date',
            'pajak_expired_date' => 'required|date',
            'warna' => 'required',
            'bahan_bakar' => 'required',
            'transmisi' => 'required',
            'kapasitas_penumpang' => 'required|integer',
            'kondisi' => 'required',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $errors = \App\Services\ImageValidator::validate($request->file('image'));
            if (!empty($errors)) {
                return back()->withErrors(['image' => implode(' ', $errors)])->withInput();
            }
            
            if ($car->image && file_exists(storage_path('app/public/' . $car->image))) {
                unlink(storage_path('app/public/' . $car->image));
            }
            $data['image'] = \App\Services\ImageValidator::store($request->file('image'));
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully');
    }
}
