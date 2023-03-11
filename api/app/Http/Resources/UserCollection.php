<?php

namespace App\Http\Resources;

class UserCollection extends PaginationCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = UserResource::class;
}
