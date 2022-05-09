<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Api\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiUserController extends Controller
{
    private function getApiService()
    {
        return app(ApiService::class);
    }

    public function register(Request $request): JsonResponse
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required',
        ]);

        $user = $this->getApiService()->createUser($request->all());

        return response()->json($user, 201);
    }

    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = $this->getApiService()->login($request->all());

        if (!$user) {
            return response()->json(['user' => [], 'msg' => 'User not found!'], 404);
        }

        return response()->json(['user' => $user, 'msg' => 'User successfully logged in!']);
    }

    public function recoverPassword(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $newPassword = $this->getApiService()->recoverPassword($request->all());

        if (!$newPassword) {
            return response()->json(['msg' => 'User not found!'], 404);
        }

        return response()->json(['msg' => 'Successfull! Your new password:' . $newPassword]);
    }

    public function showUserCompanies(int $user_id): JsonResponse
    {
        $companies = $this->getApiService()->getUserCompanies($user_id);

        return response()->json($companies);
    }

    public function addUserCompany(Request $request): JsonResponse
    {
        $this->validate($request, [
            'user_id' => 'required',
            'title' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ]);

        $company = $this->getApiService()->createUserCompany($request->all());

        return response()->json($company, 201);
    }
}
