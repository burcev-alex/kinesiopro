<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Domains\User\Http\Requests\RequestDeliveryProfileCreate;
use App\Domains\User\Http\Requests\RequestUserUpdate;
use App\Domains\User\Http\Resources\ResourceUser;
use App\Domains\User\Http\Resources\ResourceUserProfileDelivery;
use App\Domains\User\Models\User;
use App\Domains\User\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get user data page
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('pages.personal.user_info', ['user' => new ResourceUser($request->user())]);
    }

    /**
     * @param RequestUserUpdate $requestUserUpdate
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(RequestUserUpdate $requestUserUpdate)
    {
        $this->userService->update($requestUserUpdate->user(), $requestUserUpdate->validated());

        return response()->json(['status' => 'ok']);
    }
}
