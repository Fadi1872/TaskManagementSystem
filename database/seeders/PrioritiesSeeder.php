<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['High', 2],
            ['Meduim', 1],
            ['Low', 0],
            ['Urgent', 3],
            ['Critical', 4]
        ];

        foreach ($priorities as $priority)
            Priority::create([
                'name' => $priority[0],
                'level'=> $priority[1]
            ]);
    }
}
