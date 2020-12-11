<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPersonalDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ////////////////////////////////////////////////////////////////////
        //標頭
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '姓名',
            'personalDataValue' => '盧本翔',
            'dataType' => 'webHeader',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '主標',
            'personalDataValue' => '(曾任)職哈瑪星科技 | (現任)旭聯科技網頁工程師',
            'dataType' => 'webHeader',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '副標',
            'personalDataValue' => '台南市仁德區 | 2~3年工作經驗 | 希望職稱：網頁開發工程師',
            'dataType' => 'webHeader',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        ////////////////////////////////////////////////////////////////////
        //基本資料
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '',
            'personalDataValue' => '男性、未婚',
            'dataType' => 'BaseInfo',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '生日',
            'personalDataValue' => '1996/09/12',
            'dataType' => 'BaseInfo',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '專業',
            'personalDataValue' => '網頁開發與維護 (php、angular)',
            'dataType' => 'BaseInfo',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        ////////////////////////////////////////////////////////////////////
        //聯絡方式
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '聯絡地址',
            'personalDataValue' => '台南市仁德區文心路',
            'dataType' => 'ContactInfo',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '信箱',
            'personalDataValue' => 'aloo31124@gmail.com',
            'dataType' => 'ContactInfo',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('personal_datas')->insert(array(
            'personalDataName' => '手機',
            'personalDataValue' => '0933600342',
            'dataType' => 'ContactInfo',
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
