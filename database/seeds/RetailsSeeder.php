<?php

use App\EstateObject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\File;

class RetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    public function run()
    {
        // $addresses = [
        //     [
        //         'улица Дыбенко, 30к2',
        //         '55.874672, 37.486215',
        //         'Ховрино'
        //     ],
        //     [
        //         'Клязьминская улица, 15',
        //         '55.888962, 37.525902',
        //         'Отрадное'
        //     ],
        //     [
        //         'Полярная улица, 9к2',
        //         '55.874417, 37.633678',
        //         ''
        //     ],
        //     [
        //         'Ивантеевская улица, 5с8',
        //         '55.820283, 37.719261',
        //         'Бульвар Рокоссовского'
        //     ],
        //     [
        //         '15-я Парковая улица, 46к9',
        //         '55.807925, 37.825704',
        //         'Щёлковская'
        //     ],
        //     [
        //         'Вольная улица, 28к3',
        //         '55.776297, 37.736247',
        //         'Соколиная Гора'
        //     ],
        //     [
        //         'Гороховский переулок, 18/20с1',
        //         '55.765154, 37.668832',
        //         'Курская'
        //     ],
        //     [
        //         'Садовническая улица, 47с1',
        //         '55.743099, 37.639393',
        //         'Таганская'
        //     ],
        //     [
        //         '2-й Саратовский проезд, 8',
        //         '55.712120, 37.739448',
        //         'Текстильщики'
        //     ],
        //     [
        //         '2-й Котляковский переулок, 18',
        //         '55.643617, 37.635564',
        //         'Каширская'
        //     ],
        //     [
        //         'Мичуринский проспект, 7',
        //         '55.702851, 37.509889',
        //         'Ломоносовский проспект'
        //     ],
        // ];
        // foreach ($addresses as $address) {
        //     $object = [
        //         'characteristics' => [
        //             'type' => 'Retail',
        //             'cost' => rand(10000000, 100000000),
        //             'address' => $address[0],
        //             'district' => 'Москва, ВАО',
        //             'location' => 'Moscow',
        //             'coordinates' => explode(',', str_replace(' ', '', $address[1])),
        //             'costCurrency' => 'rouble',
        //             'areaS' => rand(300, 5000),
        //             'underground' => $address[2]
        //         ],
        //         'description' => $this->description,
        //         'responsible' => 'Иванов И.И.',
        //         'only_auth' => false,
        //         'price_admins_only' => false,
        //         'object_admins_only' => false,
        //     ];
        //     EstateObject::create($object);
        // }

        $objects = EstateObject::where('characteristics->type', 'Retail')->get(['id', 'characteristics'])->toArray();
        foreach ($objects as $object) {
            $originalImage = Image::make(storage_path(env('TMP_FILES_PATH') . 'Retail.jpg'));
            $big = $originalImage->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $newFilename = Str::random(40) . '.jpg';
            $big->save(storage_path(env('BIG_IMAGES_PATH') . $newFilename));
            $big_image_size = $big->width() . ',' . $big->height();
            $small = $originalImage->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $small->save(storage_path(env('SMALL_IMAGES_PATH') . $newFilename));
            $caption = rand(0, 1) ? 'Проект' : 'Фото';
            File::create([
                'object_id' => $object['id'],
                'original_filename' => 'Retail.jpg',
                'filename' => $newFilename,
                'type' => 'images',
                'caption' => $caption,
                'isMain' => 1,
                'big_image_size' => $big_image_size
            ]);
        }
    }
}
