<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstateObject extends Model
{
    protected $table = 'objects';

    protected $guarded = [];

    protected $casts = [
        'characteristics' => 'array',
        'only_auth' => 'boolean',
        'price_admins_only' => 'boolean',
        'object_admins_only' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany('App\File', 'object_id')->where('type', 'images')->whereNotNull('object_id');
    }

    public function docs()
    {
        return $this->hasMany('App\File', 'object_id')->where('type', 'docs')->whereNotNull('object_id');
    }

    public function favourites()
    {
        return $this->hasMany('App\Favourite', 'object_id');
    }

}
