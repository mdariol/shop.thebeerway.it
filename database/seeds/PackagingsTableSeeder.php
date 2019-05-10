<?php

use App\Packaging;
use Illuminate\Database\Seeder;

class PackagingsTableSeeder extends Seeder
{
    const PACKAGINGS = [
      ['name' => 'Bottiglia', 'quantity' => 12, 'capacity' => 33],
      ['name' => 'Bottiglia', 'quantity' => 24, 'capacity' => 33],
      ['name' => 'Bottiglia', 'quantity' => 12, 'capacity' => 75],
      ['name' => 'Bottiglia', 'quantity' => 24, 'capacity' => 75],
      ['name' => 'Fusto', 'quantity' => 1, 'capacity' => 2000],
      ['name' => 'Fusto', 'quantity' => 1, 'capacity' => 2400],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::PACKAGINGS as $packaging) {
            Packaging::create($packaging);
        }
    }
}
