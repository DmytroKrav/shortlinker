<?php
namespace App\Validators;

use App\Helpers\TimeHelper;
use App\Services\Links\LinkService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class OperationTimeLimit implements Rule
{
    private $service;
    private $request;

    public function __construct(LinkService $linkService, Request $request)
    {
        $this->service = $linkService;
        $this->request = $request;
    }


    public function passes($attribute, $value)
    {
        $blacklistedDomains = $this->service->getAllShortLinkFromIpByLastTime(
            request()->ip(),
            time() - env('SHORT_LINK_CREATION_TIME_LIMIT')
        );

        if (count($blacklistedDomains) < env('SHORT_LINK_CREATION_AMOUNT_PER_TIME_LIMIT')) {
            return true;
        }

        return false;
    }

    public function message(): string
    {
        return "Only " . env('SHORT_LINK_CREATION_AMOUNT_PER_TIME_LIMIT')
            . ' links allowed per ' . TimeHelper::fromSecondsToHumanTime(env('SHORT_LINK_CREATION_TIME_LIMIT'));
    }
}