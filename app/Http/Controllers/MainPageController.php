<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstateObject;

class MainPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showMainPage(Request $request)
    {
        $objects = EstateObject::where('object_admins_only', false);
        $zu = EstateObject::where(['object_admins_only' => false, 'characteristics->type' => 'ZU']);
        $invest = EstateObject::where(['object_admins_only' => false, 'characteristics->type' => 'Invest']);
        // $zuCount = $zu->count();
        // dd($zu->count());
        return view('main', [
            'zuCount' => $zu->count(),
            'zuGroundS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($zu->sum('characteristics->groundS'))),
            'investCount' => $invest->count(),
            'investAreaS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($invest->sum('characteristics->areaS'))),
        ]);
    }

    public function showPrivacyPolicy()
    {
        return view('privacy_policy');
    }
}
