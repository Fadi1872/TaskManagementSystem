<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ModelHasTasksException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePriorityRequest;
use App\Http\Requests\UpdatePriorityRequest;
use App\Models\Priority;
use App\Service\PrioritiesService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PrioritiesController extends Controller
{
    use AuthorizesRequests;

    protected PrioritiesService $prioritiesService;

    public function __construct(PrioritiesService $prioritiesService)
    {
        $this->prioritiesService = $prioritiesService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorities = $this->prioritiesService->listAll();
        return $this->successResponse(
            empty($priorities) ? "no priorities to be listed." : "all priorities are listed",
            $priorities
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePriorityRequest $request)
    {
        try {
            $priority = $this->prioritiesService->createPriority($request->validated());
            return $this->successResponse("priority " . $priority->name . " created successfully!");
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong when creating " . $request->name . " priority", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Priority $priority)
    {
        try {
            return $this->successResponse($priority->name . " details", $priority->toArray());
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Status not Found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePriorityRequest $request, Priority $priority)
    {
        try {
            $this->prioritiesService->updatePriority($request->validated(), $priority);
            return $this->successResponse("Priority updated to " . $priority->name . " successfully!");
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong when updating " . $priority->name . " priority", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Priority $priority)
    {
        try {
            $this->authorize('delete', Priority::class);

            $this->prioritiesService->deletePriority($priority);
            return $this->successResponse($priority->name . " Priority deleted succesfully");
        } catch (AuthorizationException $e) {
            return $this->errorResponse("You don't have permission!", 403);
        } catch (ModelHasTasksException $e) {
            return $this->errorResponse($e->getMessage(), 403);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
