<?php

namespace App\Repositories\Blacklists;

use App\Models\DomainsBlacklist;
use App\Repositories\BaseRepository;

class DomainsBlacklistRepository extends BaseRepository
{
    public function __construct(DomainsBlacklist $domainsBlacklist)
    {
        $this->model = $domainsBlacklist;
    }

    public function getAllDomainsAsArray()
    {
        return $this->model->pluck('domain')->toArray();
    }
}