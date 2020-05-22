<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertWorkingAbilityCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('working_ability_category')->insert(array(
            'id' => '1',
            'parent_id' => '0',
            'name' => '程式能力',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('working_ability_category')->insert(array(
            'id' => '2',
            'parent_id' => '1',
            'name' => 'java能力',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('working_ability_category')->insert(array(
            'id' => '3',
            'parent_id' => '1',
            'name' => 'php 能力',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));

        
        DB::table('working_ability_category')->insert(array(
            'id' => '4',
            'parent_id' => '0',
            'name' => '外語能力',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('working_ability_category')->insert(array(
            'id' => '5',
            'parent_id' => '4',
            'name' => '英語能力',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('working_ability_category')->insert(array(
            'id' => '6',
            'parent_id' => '4',
            'name' => '日語能力',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
