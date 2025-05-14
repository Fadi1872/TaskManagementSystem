<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogInRequest;
use App\Service\AuthService;
use Exception;
use Illuminate\Http\Request;

//there will be no register method
class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * log the user in
     * 
     * @param LogInRequset $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LogInRequest $request)
    {
        try {
            $data = $this->authService->login($request->email, $request->password);
            return $this->successResponse("You are logged in successfully!", $data);
        } catch(Exception $e) {
            return $this->errorResponse($e->getMessage() , 403);
        }
    }

    /**
     * log the user out
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request){
        try{
            $this->authService->logout($request->user());
            return $this->successResponse("you are logged out successfully");
        } catch (Exception $e) {
            return $this->errorResponse("failed to delete the token!", 500);
        }
    }
}
