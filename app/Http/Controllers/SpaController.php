<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $isAuthorized = auth()->check() ? 1 : 0;
        $isAccepted = ($isAuthorized && auth()->user()->isAccepted()) ? 1 : 0;
        return view('index', compact(['isAuthorized', 'isAccepted']));
    }
}
