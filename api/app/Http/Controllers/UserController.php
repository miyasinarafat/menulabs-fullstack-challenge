<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\ResponseHelper;
use App\Infrastructure\Cache\Cache;
use App\Infrastructure\Cache\CacheTag;
use App\Infrastructure\Persistance\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
//        Cache::flushTagCache(CacheTag::USER);
//        Cache::flushTagCache(CacheTag::WEATHER);

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = resolve(UserRepositoryInterface::class);
        $users = $userRepository->getPaginationList(
            page: $request->input('page', 1),
            perPage: $request->input('perPage', 10)
        );

        return ResponseHelper::success(
            UserCollection::make($users)->toArray($request)
        );
    }
}
