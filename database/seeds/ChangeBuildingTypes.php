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
        $objects = EstateObject::where('characteristics->type', 'Retail')->get();
        foreach ($objects as $object) {
            $characteristics = $object->characteristics;
            $characteristics['purposeRetail'] = $characteristics['purposeRetail']['slug'];
            $object->characteristics = $characteristics;
            $object->save();
        }
    }
}
