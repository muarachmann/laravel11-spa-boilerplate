<?php

namespace Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_home_page_loads_ok(): void
    {
        $this->get(route('guest.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Index'));
    }

    public function test_about_page_loads_ok(): void
    {
        $this->get(route('guest.about'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('About'));
    }

}
