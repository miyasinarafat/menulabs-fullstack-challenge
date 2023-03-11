<?php

namespace App\Infrastructure\Cache;

enum CacheTag: string
{
    case USER = 'user';
    case WEATHER = 'weather';
}
