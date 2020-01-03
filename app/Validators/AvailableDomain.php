<?php
namespace App\Validators;

use App\Services\Blacklists\DomainsBlacklistService;
use Illuminate\Contracts\Validation\Rule;

class AvailableDomain implements Rule
{
    private $service;

    protected $value;

    public function __construct(DomainsBlacklistService $service)
    {
        $this->service = $service;
    }


    public function passes($attribute, $value)
    {
        $linkDomain = parse_url($value, PHP_URL_HOST);
        $blacklistedDomains = $this->service->getAllDomainsAsArray();
        if ($blacklistedDomains) {
            foreach ($blacklistedDomains as $blacklistedDomain) {
                if (strpos($linkDomain, $blacklistedDomain) !== false) {
                    $this->value = $blacklistedDomain;
                    return false;
                }
            }
        }

        return true;
    }

    public function message(): string
    {
        return ':attribute has a deprecated host "' . $this->value . '"';
    }
}