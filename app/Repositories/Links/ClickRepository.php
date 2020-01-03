<?php

namespace App\Repositories\Links;

use App\Http\Requests\Links\ClickLinkRequest;
use App\Models\Clicks;
use App\Repositories\BaseRepository;

class ClickRepository extends BaseRepository
{
    public function __construct(Clicks $click)
    {
        $this->model = $click;
    }

    public function create(ClickLinkRequest $request, $isFirst = false)
    {
        $model = $this->model->create([
            'clicker_ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'referrer' => $request->header('Referer'),
            'datetime' => $request->datetime,
            'is_unique' => $isFirst,
            'clicker_city' => $request->city,
        ]);

        return $model;
    }

    public function findOneByIpRefererUrlUserAgent(ClickLinkRequest $request)
    {
        return $this->model->where(['clicker_ip' => $request->ip()])
            ->where(['user_agent' => $request->header('User-Agent')])
            ->where(['referrer' => $request->header('Referer')])
            ->exists();
    }
}