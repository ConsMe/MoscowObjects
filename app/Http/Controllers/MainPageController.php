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
        $zu = EstateObject::where(['object_admins_only' => false, 'characteristics->type' => 'ZU']);
        $invest = EstateObject::where(['object_admins_only' => false, 'characteristics->type' => 'Invest']);
        $retail = EstateObject::where(['object_admins_only' => false, 'characteristics->type' => 'Retail']);
        return view('main', [
            'zuCount' => $zu->count(),
            'zuGroundS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($zu->sum('characteristics->groundS'))),
            'investCount' => $invest->count(),
            'investAreaS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($invest->sum('characteristics->areaS'))),
            'retailCount' => $retail->count(),
            'retailAreaS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($retail->sum('characteristics->areaS'))),
        ]);
    }

    public function showPrivacyPolicy()
    {
        return view('privacy_policy');
    }

    public function unsubscribed()
    {
        $email = request()->session()->get('unsubscribed_email');
        if ($email) {
            request()->session()->forget('unsubscribed_email');
            return view('unsubscribed', ['email' => $email]);
        }
        return redirect()->route('main_page');
    }
}
