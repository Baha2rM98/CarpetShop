<?php

use App\AttributeGroup;
use Illuminate\Database\Seeder;

class AttributeGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AttributeGroup::class, 20)->create();
    }
}
