<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskFilterRequest;
use App\Http\Requests\UpdateTaaskStatusRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Service\TaskService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AuthorizesRequests;

    protected TaskService $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskFilterRequest $request)
    {
        $tasks = $this->taskService->listAll($request->validated(), auth()->user());
        return $this->successResponse("tasks listed", $tasks->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $task = $this->taskService->createTask($request->validated());

            return $this->successResponse("task created successfully", $task->toArray());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            $this->authorize("view", $task);

            return $this->successResponse(
                $task->title . " task details",
                $task->load(['users', 'status', 'priority', 'creator'])->toArray()
            );
        } catch (AuthorizationException $e) {
            return $this->errorResponse("you don't have permission!", 403);
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong", 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $this->taskService->updateTask($request->validated(), $task);
            return $this->successResponse("Task " . $task->title . " updated successfully!");
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong!", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $this->authorize('delete', Task::class);

            $this->taskService->deleteTask($task);
            return $this->successResponse($task->title . " Task deleted succesfully");
        } catch (AuthorizationException $e) {
            return $this->errorResponse("You don't have permission!", 403);
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong!", 500);
        }
    }

    /**
     * update the status of the task
     */
    public function updateStatus(UpdateTaaskStatusRequest $request, int $id) {
        try{
            $task = Task::find($id);
            $this->taskService->updateTaskStatus($request->validated(), $task);

            $this->successResponse("task status updated succesfully!");
        } catch(Exception $e) {
            $this->errorResponse("something went wrong!", 500);
        }
    }
}
