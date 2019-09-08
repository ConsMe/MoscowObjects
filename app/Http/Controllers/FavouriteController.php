<?php

namespace App\Http\Controllers;

use App\EstateObject;
use Illuminate\Http\Request;
use App\Favourite;

class FavouriteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get()
    {
        return auth()->user()->favourites()->get('object_id')->pluck('object_id');
    }

    public function add(EstateObject $object)
    {
        Favourite::firstOrCreate([
            'object_id' => $object->id,
            'user_id' => auth()->user()->id,
        ]);
        return response(200);
    }

    public function remove($objectId)
    {
        Favourite::where([
            'object_id' => $objectId,
            'user_id' => auth()->user()->id,
        ])->delete();
        return response(200);
    }

}
