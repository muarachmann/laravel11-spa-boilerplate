<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;


class PagesController extends Controller
{
    /**
     * Returns index page
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Index');
    }

    /**
     * Returns about us page
     * @return Response
     */
    public function about(): Response
    {
        return Inertia::render('About');
    }

    public function licensePage(): Response
    {
        return Inertia::render('License');
    }
}
