<?php

namespace App\Http\Controllers;

use App\Models\Car;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::where('Status', 1)->where('IsDeleted', 0);

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by transmission
        if ($request->transmisi) {
            $query->where('transmisi', $request->transmisi);
        }

        // Filter by capacity
        if ($request->kapasitas) {
            $query->where('kapasitas_penumpang', $request->kapasitas);
        }

        // Filter by price range
        if ($request->min_price) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        // Sort
        if ($request->sort == 'price_asc') {
            $query->orderBy('price_per_day', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price_per_day', 'desc');
        } elseif ($request->sort == 'newest') {
            $query->orderBy('year', 'desc');
        }

        $cars = $query->get();
        return view('home', compact('cars'));
    }
}
