<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonalDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '姓名',
            'personalDataValue' => '盧本翔',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '性別',
            'personalDataValue' => '男',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '生日',
            'personalDataValue' => '1992/09/12',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '電話',
            'personalDataValue' => '093333',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '信箱',
            'personalDataValue' => 'aloo31124@gmail.com',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '住址',
            'personalDataValue' => '台南市仁德區',
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
