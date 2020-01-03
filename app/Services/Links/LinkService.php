<?php

namespace App\Services\Links;

use App\Http\Requests\Links\ClickLinkRequest;
use App\Http\Requests\Links\CreateLinkRequest;
use App\Models\ShortedLinks;
use App\Repositories\Links\ClickRepository;
use App\Repositories\Links\LinksRepository;
use Carbon\Carbon;

class LinkService
{
    private $linkRepository;
    private $clickRepository;

    public function __construct(LinksRepository $linksRepository, ClickRepository $clickRepository)
    {
        $this->linkRepository = $linksRepository;
        $this->clickRepository = $clickRepository;
    }

    public function create(CreateLinkRequest $request)
    {
        $request->code = md5(time());
        $request->params = $this->getRequestParamsAsText($request->link);
        $request->link = strtok($request->link, '?');

        return $this->linkRepository->create($request);
    }

    public function getAllShortLinkFromIpByLastTime(string $ip, $timePeriod)
    {
        return $this->linkRepository->getAllShortLinkFromIpByLastTime($ip, $timePeriod);
    }

    private function getRequestParamsAsText(string $url) : ?string
    {
        if ($url) {
            return parse_url($url, PHP_URL_QUERY);
        }

        return null;
    }

    public function getRedirect(string $code) :?ShortedLinks
    {
        return $this->linkRepository->getOneByCode($code);
    }

    public function noteClick(ClickLinkRequest $request)
    {
        $isCurrentUserAlreadyClick = $this->clickRepository->findOneByIpRefererUrlUserAgent($request);
        $request->datetime =  Carbon::now();
        $request->city = geoip($request->ip())['city'];

        if ($isCurrentUserAlreadyClick) {
            return $this->clickRepository->create($request);
        }

        return $this->clickRepository->create($request, true);
    }

    public function createRedirectLink(ShortedLinks $linkModel, $externalParams)
    {
        $paramsArray = [$linkModel->params, http_build_query($externalParams, '', '&')];
        $params = implode('&', $paramsArray);

        return $params ? $linkModel->link . '?' . $params : $linkModel->link;
    }
}
