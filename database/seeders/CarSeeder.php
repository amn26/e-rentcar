<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            ['id' => 'CAR0000001', 'name' => 'Toyota Avanza', 'brand' => 'Toyota', 'year' => 2023, 'plate_number' => 'B 1234 ABC', 'price_per_day' => 300000, 'stnk_number' => 'STNK001', 'stnk_expired_date' => '2027-12-31', 'pajak_expired_date' => '2027-12-31', 'warna' => 'Silver', 'bahan_bakar' => 'Bensin', 'transmisi' => 'Automatic', 'kapasitas_penumpang' => 7, 'kondisi' => 'Baik'],
            ['id' => 'CAR0000002', 'name' => 'Honda Civic', 'brand' => 'Honda', 'year' => 2024, 'plate_number' => 'B 5678 DEF', 'price_per_day' => 450000, 'stnk_number' => 'STNK002', 'stnk_expired_date' => '2028-12-31', 'pajak_expired_date' => '2028-12-31', 'warna' => 'Hitam', 'bahan_bakar' => 'Bensin', 'transmisi' => 'Manual', 'kapasitas_penumpang' => 5, 'kondisi' => 'Baik'],
            ['id' => 'CAR0000003', 'name' => 'Suzuki Ertiga', 'brand' => 'Suzuki', 'year' => 2023, 'plate_number' => 'B 9012 GHI', 'price_per_day' => 350000, 'stnk_number' => 'STNK003', 'stnk_expired_date' => '2027-12-31', 'pajak_expired_date' => '2027-12-31', 'warna' => 'Putih', 'bahan_bakar' => 'Bensin', 'transmisi' => 'Automatic', 'kapasitas_penumpang' => 7, 'kondisi' => 'Baik'],
            ['id' => 'CAR0000004', 'name' => 'BMW M3', 'brand' => 'BMW', 'year' => 2024, 'plate_number' => 'B 3456 JKL', 'price_per_day' => 800000, 'stnk_number' => 'STNK004', 'stnk_expired_date' => '2028-12-31', 'pajak_expired_date' => '2028-12-31', 'warna' => 'Biru', 'bahan_bakar' => 'Bensin', 'transmisi' => 'Automatic', 'kapasitas_penumpang' => 5, 'kondisi' => 'Baik'],
            ['id' => 'CAR0000005', 'name' => 'Honda CRV', 'brand' => 'Honda', 'year' => 2023, 'plate_number' => 'B 7890 MNO', 'price_per_day' => 500000, 'stnk_number' => 'STNK005', 'stnk_expired_date' => '2027-12-31', 'pajak_expired_date' => '2027-12-31', 'warna' => 'Merah', 'bahan_bakar' => 'Bensin', 'transmisi' => 'Automatic', 'kapasitas_penumpang' => 5, 'kondisi' => 'Baik'],
            ['id' => 'CAR0000006', 'name' => 'Toyota Fortuner', 'brand' => 'Toyota', 'year' => 2024, 'plate_number' => 'B 2345 PQR', 'price_per_day' => 600000, 'stnk_number' => 'STNK006', 'stnk_expired_date' => '2028-12-31', 'pajak_expired_date' => '2028-12-31', 'warna' => 'Hitam', 'bahan_bakar' => 'Diesel', 'transmisi' => 'Automatic', 'kapasitas_penumpang' => 7, 'kondisi' => 'Baik'],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
