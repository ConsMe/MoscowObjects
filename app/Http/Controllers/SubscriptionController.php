<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function changeSubscriptionStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
        $request->user()->update(['subscribed' => $request->status]);
        return response(200);
    }
}
