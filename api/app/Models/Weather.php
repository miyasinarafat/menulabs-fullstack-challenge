<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/***
 * @property-read int id
 * @property int user_id
 * @property string status
 * @property string description
 * @property float temperature
 * @property float temperature_min
 * @property float temperature_max
 * @property int humidity
 * @property int visibility
 * @property float wind_speed
 * @property string city
 * @property string country
 * @property string icon
 * @property Carbon datetime
 */
class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
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

    protected $casts = ['datetime' => 'datetime'];
}
