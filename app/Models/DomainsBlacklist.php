<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $domain string
 */
class DomainsBlacklist extends Model
{
    protected $fillable = [
        'domain'
    ];

    protected $table = 'domains_blacklist';

}