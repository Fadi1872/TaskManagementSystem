<?php

namespace App\Service;

use App\Models\Task;
use App\Models\User;

class TaskService
{

    public function listAll(array $credentials, User $user)
    {
        $query = Task::query()
            ->join('priorities', 'tasks.priority_id', "=", 'priorities.id')
            ->select('tasks.*');

        if (!$user->is_admin) $credentials['assigned_user_id'] = $user->id;
        if (!empty($credentials['assigned_user_id']) ?? null)
            $query->whereHas('users', function ($q) use ($credentials) {
                $q->where('users.id', $credentials['assigned_user_id']);
            });

        if (!empty($credentials['status_id']) ?? null)
            $query->where('status_id', $credentials['status_id']);

        if (!empty($credentials['title']) ?? null)
            $query->where('title', 'like', '%' . $credentials['title'] . '%');

        $query->orderByDesc('priorities.level')
            ->orderBy('tasks.start_date', 'asc');

        $tasks = $query
            ->with(['users', 'status', 'priority', 'creator'])
            ->get();

        return $tasks;
    }

    /**
     * create new task
     * 
     * @param array $data
     * @return Task
     */
    public function createTask(array $data)
    {
        $task = Task::create([
            'title' => $data["title"],
            'description' => $data["description"],
            'status_id' => 1,
            'priority_id' => $data["priority_id"],
            'created_by' => $data["created_by"],
            'start_date' => $data["start_date"],
            'due_date' => $data["due_date"]
        ]);

        if (isset($data["assigned_users"]))
            $task->users()->sync($data["assigned_users"]);

        return $task->load(['users', 'status', 'priority', 'creator']);
    }

    /**
     * update the task
     * 
     * @param array $data
     * @param Task $task
     * @return void
     */
    public function updateTask(array $data, Task $task)
    {
        $task->update([
            'title' => $data["title"],
            'description' => $data["description"],
            'status_id' => $data["status_id"],
            'priority_id' => $data["priority_id"],
            'created_by' => $data["created_by"],
            'start_date' => $data["start_date"],
            'due_date' => $data["due_date"]
        ]);

        $task->users()->sync($data['assigned_users'] ?? []);
    }

    /**
     * delete the task
     * 
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task)
    {
        $task->users()->detach();
        $task->delete();
    }

    /**
     * update the status id
     * 
     * @param array $data
     * @param Task $task
     * @return void
     */
    public function updateTaskStatus(array $data, Task $task)
    {
        $task->update([
            'status_id' => $data["status_id"]
        ]);

        if ($task->status()->name == 'completed')
            $task->update([
                'completed_at' => now()->toDateString()
            ]);
    }
}
