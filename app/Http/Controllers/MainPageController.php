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
        $response = [
            'zuCount' => $zu->count(),
            'zuGroundS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($zu->sum('characteristics->groundS'))),
            'investCount' => $invest->count(),
            'investAreaS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($invest->sum('characteristics->areaS'))),
            'retailCount' => $retail->count(),
            'retailAreaS' => preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', round($retail->sum('characteristics->areaS'))),
        ];
        foreach (['zuCount', 'investCount', 'retailCount'] as $key) {
            $count = \strval($response[$key]);
            $text = 'Предложений';
            if ($response[$key] > 20 || $response[$key] < 10) {
                if ($count === '1') {
                    $text = 'Предложение';
                } elseif (strlen($count) > 1 && \substr($count, -1) === '1' && \substr($count, -2, 1) !== '1') {
                    $text = 'Предложение';
                } elseif (in_array(\substr($count, -1), ['2', '3', '4'])) {
                    $text = 'Предложения';
                }
            }
            $response[$key] = $count.' '.$text;
        }
        return view('main', $response);
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
