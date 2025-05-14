<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title'        => 'Design login page',
                'description'  => 'Create responsive login page with form validation.',
                'status_id'    => 1,
                'priority_id'  => 3,
                'created_by'   => 6,
                'start_date'   => '2025-05-10',
                'due_date'     => '2025-05-12',
                'assigned_users' => [2, 3],
            ],
            [
                'title'        => 'Implement authentication',
                'description'  => 'Set up Sanctum for API token authentication.',
                'status_id'    => 2,
                'priority_id'  => 3,
                'created_by'   => 6,
                'start_date'   => '2025-05-11',
                'due_date'     => '2025-05-14',
                'assigned_users' => [1],
            ],
            [
                'title'        => 'Build task CRUD endpoints',
                'description'  => 'Create API routes and controllers for task management.',
                'status_id'    => 1,
                'priority_id'  => 2,
                'created_by'   => 6,
                'start_date'   => '2025-05-12',
                'due_date'     => '2025-05-16',
                'assigned_users' => [2, 4],
            ],
            [
                'title'        => 'Write unit tests for TaskPolicy',
                'description'  => 'Ensure authorization logic works as expected.',
                'status_id'    => 1,
                'priority_id'  => 2,
                'created_by'   => 6,
                'start_date'   => '2025-05-13',
                'due_date'     => '2025-05-15',
                'assigned_users' => [3],
            ],
            [
                'title'        => 'Seed database with initial statuses',
                'description'  => 'Add default statuses: Pending, In Progress, Done.',
                'status_id'    => 3,
                'priority_id'  => 1,
                'created_by'   => 6,
                'start_date'   => '2025-05-09',
                'due_date'     => '2025-05-10',
                'assigned_users' => [],
            ],
            [
                'title'        => 'Add priority level column',
                'description'  => 'Create migration and update model for priority.level.',
                'status_id'    => 2,
                'priority_id'  => 2,
                'created_by'   => 6,
                'start_date'   => '2025-05-08',
                'due_date'     => '2025-05-11',
                'assigned_users' => [4, 5],
            ],
            [
                'title'        => 'Normalize date inputs',
                'description'  => 'Implement prepareForValidation logic to standardize dates.',
                'status_id'    => 2,
                'priority_id'  => 1,
                'created_by'   => 6,
                'start_date'   => '2025-05-14',
                'due_date'     => '2025-05-18',
                'assigned_users' => [1, 2],
            ],
            [
                'title'        => 'Refactor TaskController',
                'description'  => 'Move business logic into a service class.',
                'status_id'    => 1,
                'priority_id'  => 2,
                'created_by'   => 6,
                'start_date'   => '2025-05-15',
                'due_date'     => '2025-05-20',
                'assigned_users' => [2, 3, 5],
            ],
            [
                'title'        => 'Implement filtering endpoint',
                'description'  => 'Add TaskFilterRequest and filter logic for index.',
                'status_id'    => 1,
                'priority_id'  => 3,
                'created_by'   => 6,
                'start_date'   => '2025-05-16',
                'due_date'     => '2025-05-22',
                'assigned_users' => [1],
            ],
            [
                'title'        => 'Write API documentation',
                'description'  => 'Document all Task endpoints with examples.',
                'status_id'    => 3,
                'priority_id'  => 1,
                'created_by'   => 6,
                'start_date'   => '2025-05-17',
                'due_date'     => '2025-05-23',
                'assigned_users' => [],
            ],
        ];

        foreach ($tasks as $data) {
            $assigned = $data['assigned_users'];
            unset($data['assigned_users']);

            $task = Task::create($data);

            if (!empty($assigned)) {
                $task->users()->sync($assigned);
            }
        }
    }
}
