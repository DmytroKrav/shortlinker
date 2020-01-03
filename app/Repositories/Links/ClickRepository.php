<?php

namespace App\Repositories\Links;

use App\Http\Requests\Links\ClickLinkRequest;
use App\Models\Clicks;
use App\Models\ShortedLinks;
use App\Repositories\BaseRepository;

class ClickRepository extends BaseRepository
{
    public function __construct(Clicks $click)
    {
        $this->model = $click;
    }

    public function create(array $requestParams, ShortedLinks $model, $isFirst = false) : Clicks
    {
        $model = $this->model->create([
            'clicker_ip' => $requestParams['clicker_ip'],
            'shorted_links_id' => $model->id,
            'user_agent' => $requestParams['user_agent'],
            'referrer' => $requestParams['referrer'],
            'datetime' => $requestParams['datetime'],
            'is_unique' => $isFirst,
            'clicker_city' => $requestParams['city'],
        ]);

        return $model;
    }

    public function findOneByIpRefererUrlUserAgent(array $requestParams, ShortedLinks $model) : bool
    {
        return $this->model->where(['clicker_ip' => $requestParams['clicker_ip']])
            ->where(['user_agent' => $requestParams['user_agent']])
            ->where(['referrer' => $requestParams['referrer']])
            ->where(['shorted_links_id' => $model->id])
            ->exists();
    }
}