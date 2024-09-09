<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    /**
     * Admin dashboard homepage
     * @return Response
     */
    public function dashboard(): Response
    {
        return Inertia::render('Admin/Index');
    }
}
