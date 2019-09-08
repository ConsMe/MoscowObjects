<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::withTrashed()->where('id', '!=', $request->user()->id)
            ->whereNotNull('email_verified_at')
            ->get(['id', 'name', 'email', 'role', 'deleted_at']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:admin,manager,partner',
        ]);
        if ($user->id === $request->user()->id || !$user->email_verified_at) abort(403);
        $user->update(['role' => $request->role, 'accepted' => true]);
        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) abort(403);
        $user->delete();
        return response(200);
    }

    public function restore(Request $request, $userId)
    {
        if ($userId === $request->user()->id) abort(403);
        $user = User::withTrashed()
            ->where('id', $userId)
            ->restore();
        return response(200);
    }
}
