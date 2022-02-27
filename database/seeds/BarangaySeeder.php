<?php

use App\Models\Barangay;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Barangay::create([
            'barangay' => 'Balayhangin',
        ]);

        Barangay::create([
            'barangay' => 'Bangyas',
        ]);

        Barangay::create([
            'barangay' => 'Dayap',
        ]);

        Barangay::create([
            'barangay' => 'Dayap II - NHA',
        ]);

        Barangay::create([
            'barangay' => 'Hanggan',
        ]);

        Barangay::create([
            'barangay' => 'Imok',
        ]);

        Barangay::create([
            'barangay' => 'Lamot 1',
        ]);

        Barangay::create([
            'barangay' => 'Lamot 2',
        ]);

        Barangay::create([
            'barangay' => 'Limao',
        ]);

        Barangay::create([
            'barangay' => 'Mabacan',
        ]);

        Barangay::create([
            'barangay' => 'Masiit',
        ]);

        Barangay::create([
            'barangay' => 'Paliparan',
        ]);

        Barangay::create([
            'barangay' => 'Perez',
        ]);

        Barangay::create([
            'barangay' => 'Prinza',
        ]);

        Barangay::create([
            'barangay' => 'Kanluran',
        ]);

        Barangay::create([
            'barangay' => 'Silangan',
        ]);

        Barangay::create([
            'barangay' => 'San Isidro',
        ]);

        Barangay::create([
            'barangay' => 'Santo Tomas',
        ]);
    }
}
