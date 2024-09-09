<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Users/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function create(Request $request): \Inertia\Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $username
     * @return Response
     */
    public function edit($username)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Returns all users data
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function loadData(Request $request): LengthAwarePaginator
    {
        $length = $request->input('length');
        $role = $request->input('role');

        $query = User::with(['roles:id,name'])
            ->when($role, function ($query) use ($role) {
                $query->whereRoleIs($role);
            });

        return $query->paginate($length)->through(function (User $user) {
            return UserResource::make($user)->resolve();
        });
    }
}
