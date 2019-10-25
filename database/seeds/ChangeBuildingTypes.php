<?php

use App\EstateObject;
use Illuminate\Database\Seeder;

class ChangeBuildingTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objects = EstateObject::where('characteristics->type', 'Invest')->get();
        foreach ($objects as $object) {
            $characteristics = $object->characteristics;
            switch ($characteristics['buildingType']['short']) {
                case 'ТЦ':
                    $characteristics['buildingType'] = 'tc';
                    break;
                case 'МФК':
                    $characteristics['buildingType'] = 'mfk';
                    break;
                case 'БЦ':
                    $characteristics['buildingType'] = 'bc';
                    break;
                case 'ИПН':
                    $characteristics['buildingType'] = 'ipn';
                    break;
                case 'ГО':
                    $characteristics['buildingType'] = 'go';
                    break;
                default:
                    break;
            }
            $object->characteristics = $characteristics;
            $object->save();
        }
    }
}
