<?php

namespace App\Repositories\Links;

use App\Http\Requests\Links\CreateLinkRequest;
use App\Models\ShortedLinks;
use App\Repositories\BaseRepository;

class LinksRepository extends BaseRepository
{
    public function __construct(ShortedLinks $links)
    {
        $this->model = $links;
    }

    public function create(array $request) : ShortedLinks
    {
        $model = $this->model->create([
            'creator_ip' => $request['creator_ip'],
            'code' => $request['code'],
            'link' => $request['link'],
            'params' => $request['params']
        ]);

        return $model;
    }

    public function getAllShortLinkFromIpByLastTime(string $ip, $timeLimit) : array
    {
        return $this->model
            ->where('creator_ip', '=', $ip)
            ->where('created_at', '>', $timeLimit)
            ->get()
            ->toArray();
    }

    public function getOneByCodeOrFail(string $code): ShortedLinks
    {
        return $this->model->where('code', '=', $code)->firstOrFail();
    }

}