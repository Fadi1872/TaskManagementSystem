<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending'],
            ['name' => 'in_progress'],
            ['name' => 'completed'],
            ['name' => 'on_hold'],
            ['name' => 'cancelled'],
            ['name' => 'failed'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
