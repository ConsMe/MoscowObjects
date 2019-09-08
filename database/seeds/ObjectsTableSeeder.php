<?php

use App\EstateObject;
use App\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ObjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $jsonString = file_get_contents(base_path('database/seeds/seed.json'));
        // $objects = json_decode($jsonString, true);
        // foreach ($objects as $object) {
        //     $newObject = $object;
        //     unset($newObject['id']);
        //     unset($newObject['image']);
        //     unset($newObject['lot']);
        //     unset($newObject['responsible']);
        //     unset($newObject['updated_at']);
        //     $newObject['costCurrency'] = 'rouble';
        //     if ($object['type'] === 'ZU') {
        //         $newObject['kadastrNumberZU'] = $object['kadastrNumber'];
        //         $newObject['kadastrNumberOKS'] = $object['kadastrNumber'];
        //         unset($newObject['kadastrNumber']);
        //         $newObject['purposeZU'] = $object['purpose'];
        //         $newObject['purposeOKS'] = $object['purpose'];
        //         unset($newObject['purpose']);
        //         unset($newObject['imageType']);
        //     }
        //     if ($object['type'] === 'Invest') {
        //         $newObject['GAPCurrency'] = 'rouble';
        //     }
        //     $newObject['areaS'] = intval($newObject['areaS']);
        //     $newObject['groundS'] = floatval($newObject['groundS']);
        //     $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        //     Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

        //     EstateObject::create(['characteristics' => $newObject, 'responsible' => 'Иванов И.И.', 'description' => $description]);
        // }

        $objects = EstateObject::get(['id', 'characteristics'])->toArray();
        foreach ($objects as $object) {
            $zuImage = Image::make(storage_path(env('TMP_FILES_PATH').'ZU.jpg'));
            $investImage = Image::make(storage_path(env('TMP_FILES_PATH').'building.jpeg'));
            $originalImage = ($object['characteristics']['type'] === 'ZU') ? $zuImage : $investImage;
            $big = $originalImage->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $newFilename = Str::random(40).'.jpg';
            $big->save(storage_path(env('BIG_IMAGES_PATH').$newFilename));
            $small = $originalImage->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $small->save(storage_path(env('SMALL_IMAGES_PATH').$newFilename));
            $caption = NULL;
            if ($object['characteristics']['type'] === 'ZU') {
                $caption = rand(0, 1) ? 'Проект' : 'Фото';
            }
            File::create([
                'object_id' => $object['id'],
                'original_filename' => ($object['characteristics']['type'] === 'ZU') ? 'ZU.jpg' : 'building.jpeg',
                'filename' => $newFilename,
                'type' => 'images',
                'caption' => $caption,
                'isMain' => 1,
            ]);
        }
    }
}
