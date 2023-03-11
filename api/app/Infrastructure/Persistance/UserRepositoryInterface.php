<?php

namespace App\Infrastructure\Persistance;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getList(): Collection;

    /**
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginationList(int $page = 1, int $perPage = 10): LengthAwarePaginator;
}
