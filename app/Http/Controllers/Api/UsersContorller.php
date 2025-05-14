<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Service\UserService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UsersContorller extends Controller
{
    use AuthorizesRequests;

    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', User::class);

            $users = $this->userService->listAll();
            return $this->successResponse("users listed.", $users->toArray());
        } catch (AuthorizationException $e) {
            return $this->errorResponse("you don't have permission!", 403);
        } catch (Exception $e) {
            return $this->errorResponse("somthing went wrong!", 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
            return $this->successResponse("user created successfully!");
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong!", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->userService->updateUser($request->validated(), $user);
            return $this->successResponse("user updated successfully");
        } catch (Exception $e) {
            $this->errorResponse("something went wrong", 500);
        }
    }

    /**
     * deactivate the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', User::class);
            $user = User::withoutGlobalScopes()->find($id);
            
            $this->userService->deleteUser($user);
            return $this->successResponse("user deleted successfully!");
        } catch (AuthorizationException $e) {
            return $this->errorResponse("You don't have permission!", 403);
        } catch (Exception $e) {
            return $this->errorResponse("something went wrong!", 500);
        }
    }

    /**
     * toggle activation for account
     */
    public function toggleActivation(int $id)
    {
        try {
            $this->authorize('toggleActivation', User::class);
            $user = User::withoutGlobalScopes()->find($id);

            $this->userService->deactivateUser($user);
            $message =  "User " . ($user->is_activated ? "activated" : "deactivated") . " successfully";
            return $this->successResponse($message);
        } catch (AuthorizationException $e) {
            return $this->errorResponse("You don't have permission!", 403);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
