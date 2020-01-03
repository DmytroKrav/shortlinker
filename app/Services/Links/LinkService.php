<?php

namespace App\Services\Links;

use App\Models\ShortedLinks;
use App\Repositories\Links\ClickRepository;
use App\Repositories\Links\LinksRepository;

class LinkService
{
    private $linkRepository;
    private $clickRepository;

    public function __construct(LinksRepository $linksRepository, ClickRepository $clickRepository)
    {
        $this->linkRepository = $linksRepository;
        $this->clickRepository = $clickRepository;
    }

    public function create(array $requestParams)
    {
        return $this->linkRepository->create($requestParams);
    }

    public function getAllShortLinkFromIpByLastTime(string $ip, $timePeriod)
    {
        return $this->linkRepository->getAllShortLinkFromIpByLastTime($ip, $timePeriod);
    }

    public function getRedirect(string $code) :?ShortedLinks
    {
        return $this->linkRepository->getOneByCodeOrFail($code);
    }

    public function noteClick(array $requestParams, ShortedLinks $model)
    {
        $isCurrentUserAlreadyClick = $this->clickRepository->findOneByIpRefererUrlUserAgent($requestParams, $model);

        if ($isCurrentUserAlreadyClick) {
            return $this->clickRepository->create($requestParams, $model);
        }

        return $this->clickRepository->create($requestParams, $model, true);
    }

    public function createRedirectLink(ShortedLinks $linkModel, $externalParams) : string
    {
        $paramsArray = [$linkModel->params, http_build_query($externalParams, '', '&')];
        $params = implode('&', $paramsArray);

        return $params ? $linkModel->link . '?' . $params : $linkModel->link;
    }
}
