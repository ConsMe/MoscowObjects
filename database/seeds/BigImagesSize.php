<?php

use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class BigImagesSize extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = \App\File::where('type', 'images')->whereNotNull('object_id')->get();
        foreach ($files as $file) {
            $image = Image::make(storage_path(env('BIG_IMAGES_PATH') . $file->filename));
            $file->big_image_size = $image->width() . ',' . $image->height();
            $file->save();
        }
    }
}
