<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $datetime string
 * @property $referrer string
 * @property $user_agent string
 * @property $ip string
 */
class Clicks extends Model
{
    protected $fillable = [
        'clicker_ip', 'referrer', 'user_agent', 'datetime', 'clicker_city', 'is_unique'
    ];

    public function getDateFormat() : string
    {
        return 'U';
    }


}