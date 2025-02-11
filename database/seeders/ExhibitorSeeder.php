<?php

namespace Database\Seeders;

use App\Models\Exhibitor;
use Illuminate\Database\Seeder;

class ExhibitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exhibitor::insert([
            ['name' => 'ABC Corp', 'country' => 'USA', 'category' => 'Tech', 'website' => 'https://abc.com'],
            ['name' => 'XYZ Ltd', 'country' => 'Canada', 'category' => 'Health', 'website' => 'https://xyz.com'],
            ['name' => 'LMN Inc', 'country' => 'Germany', 'category' => 'Manufacturing', 'website' => 'https://lmn.com'],
            ['name' => 'PQR Tech', 'country' => 'India', 'category' => 'IT', 'website' => 'https://pqr.com'],
            ['name' => 'EFG Group', 'country' => 'UK', 'category' => 'Finance', 'website' => 'https://efg.com'],
        ]);
    }
}
