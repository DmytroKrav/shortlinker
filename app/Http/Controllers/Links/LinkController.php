<?php

namespace App\Http\Controllers\Links;

use App\Http\Controllers\Controller;
use App\Http\Requests\Links\CreateLinkRequest;
use App\Services\Links\LinkService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function createLink(CreateLinkRequest $request)
    {
        $requestParams = [
            'code' => md5(time()),
            'params' => parse_url($request->link, PHP_URL_QUERY),
            'link' => strtok($request->link, '?'),
            'creator_ip' => $request->ip()
        ];

        $newShortLink = $this->linkService->create($requestParams);

        if ($newShortLink) {
            return response()->json([
                'link' => $newShortLink->link,
                'params' => $newShortLink->params ? '?' . $newShortLink->params : '',
                'shortLink' => url('/r', ['code' => $newShortLink->code])
            ]);
        }
    }

    public function performRedirect(Request $request, string $code) : string
    {
        $linkModel = $this->linkService->getRedirect($code);

        $requestParams = [
            'clicker_ip' => $request->ip(),
            'datetime' => Carbon::now(),
            'city' => geoip($request->ip())['city'],
            'referrer' => $request->header('Referer'),
            'user_agent' => $request->header('User-Agent')
        ];

        $note = $this->linkService->noteClick($requestParams, $linkModel);

        $redirectUrl = $this->linkService->createRedirectLink($linkModel, $request->all());

        if ($linkModel && $note) {
            return redirect($redirectUrl);
        }

        abort(500);
    }

}