<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangays = [
            ['name' => 'Bunakan Madridejos Cebu', 'role' => 'Bunakan'],
            ['name' => 'Kangwayan Madridejos Cebu', 'role' => 'Kangwayan'],
            ['name' => 'Kaongkod Madridejos Cebu', 'role' => 'Kaongkod'],
            ['name' => 'Kodia Madridejos Cebu', 'role' => 'Kodia'],
            ['name' => 'Maalat Madridejos Cebu', 'role' => 'Maalat'],
            ['name' => 'Malbago Madridejos Cebu', 'role' => 'Malbago'],
            ['name' => 'Mancilang Madridejos Cebu', 'role' => 'Mancilang'],
            ['name' => 'Tarong Madridejos Cebu', 'role' => 'Tarong'],
            ['name' => 'Pili Madridejos Cebu', 'role' => 'Pili'],
            ['name' => 'Poblacion Madridejos Cebu', 'role' => 'Poblacion'],
            ['name' => 'San-Agustin Madridejos Cebu', 'role' => 'San-Agustin'],
            ['name' => 'Tabagak Madridejos Cebu', 'role' => 'Tabagak'],
            ['name' => 'TalangnanMadridejos Cebu', 'role' => 'Talangnan'],
            ['name' => 'Tugas Madridejos Cebu', 'role' => 'Tugas'],
        ];

        Barangay::insert($barangays);
    }
}
