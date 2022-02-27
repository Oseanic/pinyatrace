<?php

use App\Models\CovidCase;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BarangaySeeder::class);
        $this->call(ResidentSeeder::class);
        

    }
}
