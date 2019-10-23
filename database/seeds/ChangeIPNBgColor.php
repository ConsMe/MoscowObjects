<?php

use Illuminate\Database\Seeder;

class ChangeIPNBgColor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objects = \App\EstateObject::get();
        foreach ($objects as $object) {
            if ($object->characteristics['type'] === 'Invest' && $object->characteristics['buildingType']['bg'] === 'danger') {
                $object->update([
                    'characteristics->buildingType->bg' => 'ipn',
                    'characteristics->buildingType->icon' => 'nightDotIcon',
                ]);
            }
        }
    }
}
