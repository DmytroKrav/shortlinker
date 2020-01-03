<?php

namespace App\Http\Controllers\Links;

use App\Http\Controllers\Controller;
use App\Http\Requests\Links\ClickLinkRequest;
use App\Http\Requests\Links\CreateLinkRequest;
use App\Services\Links\LinkService;
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
        $newShortLink = $this->linkService->create($request);
        if ($newShortLink) {
            return response()->json([
                'link' => $newShortLink->link,
                'params' => '?' . $newShortLink->params,
                'shortLink' => url('/r', ['code' => $newShortLink->code])
            ]);
        }
    }

    public function performRedirect(ClickLinkRequest $request, string $code) : string
    {
        $linkModel = $this->linkService->getRedirect($code);
        $note = $this->linkService->noteClick($request);

        $redirectUrl = $this->linkService->createRedirectLink($linkModel, $request->all());

        if ($linkModel && $note) {
            return redirect($redirectUrl);
        }

        abort(500);
    }

}