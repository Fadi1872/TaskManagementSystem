<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ModelHasTasksException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use App\Service\StatusService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StatusController extends Controller
{
    use AuthorizesRequests;

    protected StatusService $statusService;
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = $this->statusService->listAll();
        return $this->successResponse(
            empty($statuses) ? "no statuses to be listed." : "all statuses are listed",
            $statuses
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        try {
            $status = $this->statusService->createStatus($request->name);
            return $this->successResponse("Status " . $status->name . " created successfully!");
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong when creating " . $request->name . " Status", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        try {
            return $this->successResponse($status->name . " details", $status->toArray());
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Status not Found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        try {
            $this->statusService->updateStatus($request->name, $status);
            return $this->successResponse("Status updated to " . $status->name . " successfully!");
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong when updating " . $status->name . " Status", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        try {
            $this->authorize('delete', Status::class);

            $this->statusService->deleteStatus($status);
            return $this->successResponse($status->name . " status deleted succesfully");
        } catch (AuthorizationException $e) {
            return $this->errorResponse("You don't have permission!", 403);
        } catch (ModelHasTasksException $e) {
            return $this->errorResponse($e->getMessage(), 403);
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong!", 500);
        }
    }
}
