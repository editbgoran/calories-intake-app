<?php

namespace Database\Seeders;

use App\Models\Entry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entryData = [];
        for ($i=0; $i < 100; $i++) {
            $entryData[] = [
                'user_id' => rand(348,447),
                'text' => Str::random(10),
                'numberOfCalories' => rand(0,100),
                'date' => date('Y-m-d')
            ];
        }

        foreach ($entryData as $entry) {
            Entry::create($entry);
        }
    }
}
