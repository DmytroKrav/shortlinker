<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    /** @test */
    public function userCanVisitShortenerRoute()
    {
        $this->withExceptionHandling();
        $this->get(route('url-shortener'))->assertOk();
    }

    /** @test */
   /* public function userCanVisitShortenerRoute()
    {
        $this->get(route('url-shortener'))->assertOk();
    }*/
}
