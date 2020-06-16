<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertWorkingAbilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('working_ability')->insert(array(
            'id' => '1',
            'working_ability_category_id' => '5',
            'name' => '商用英文溝通能力',
            'discription' => '可與外國客戶用基本或進階的英文進行對話。',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('working_ability')->insert(array(
            'id' => '2',
            'working_ability_category_id' => '5',
            'name' => '英文文件閱讀',
            'discription' => '可閱讀英文信件、政府公文、英文報章雜誌等資料，並快速掌握其重點。',
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
