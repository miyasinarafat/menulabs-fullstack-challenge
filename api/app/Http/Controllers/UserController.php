<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\ResponseHelper;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $users = User::query()->paginate(10);

        return ResponseHelper::success(
            UserCollection::make($users)->toArray($request)
        );
    }
}
