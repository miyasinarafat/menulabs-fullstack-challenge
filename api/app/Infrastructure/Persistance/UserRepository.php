<?php

namespace App\Infrastructure\Persistance;

use App\Infrastructure\Cache\Cache;
use App\Infrastructure\Cache\CacheTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final class UserRepository implements UserRepositoryInterface
{
    public const CACHE_TAGS = [CacheTag::USER];

    /**
     * @inheritDoc
     */
    public function getList(): Collection
    {
        $cacheKey = Cache::generateCacheKey(__CLASS__, __METHOD__);

        if (! $result = Cache::readCache($cacheKey, self::CACHE_TAGS)) {
            $result = User::query()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('id')
                ->get();

            Cache::writePermanently($cacheKey, $result, self::CACHE_TAGS);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getPaginationList(int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $cacheKey = Cache::generateCacheKey(__CLASS__, __METHOD__, $page, $perPage);

        if (!$result = Cache::readCache($cacheKey, self::CACHE_TAGS)) {
            $result = User::query()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('id')
                ->paginate(perPage: $perPage, page: $page);

            Cache::writePermanently($cacheKey, $result, self::CACHE_TAGS);
        }

        return $result;
    }
}
