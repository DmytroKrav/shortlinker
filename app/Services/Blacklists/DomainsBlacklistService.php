<?php

namespace App\Services\Blacklists;

use App\Repositories\BaseRepository;
use App\Repositories\Blacklists\DomainsBlacklistRepository;

class DomainsBlacklistService extends BaseRepository
{
    private $repository;

    public function __construct(DomainsBlacklistRepository $blacklistRepository)
    {
        $this->repository = $blacklistRepository;
    }

    public function getAllDomainsAsArray()
    {
        return $this->repository->getAllDomainsAsArray();
    }
}