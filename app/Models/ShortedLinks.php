<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $link string
 * @property $code string
 * @property $ip string
 * @property $params string
 */
class ShortedLinks extends Model
{
    protected $fillable = [
        'creator_ip', 'link', 'code', 'params'
    ];

    public function getDateFormat() : string
    {
        return 'U';
    }


}