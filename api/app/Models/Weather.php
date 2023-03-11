<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
      'status',
      'description',
      'temperature',
      'temperature_min',
      'temperature_max',
      'humidity',
      'visibility',
      'wind_speed',
      'city',
      'country',
      'icon',
      'datetime',
    ];
}
