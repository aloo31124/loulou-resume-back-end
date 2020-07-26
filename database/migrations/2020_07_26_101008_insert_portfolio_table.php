<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('portfolio')->insert(array(
            'id' => '1',
            'portfolio_category_id' => '4',
            'name' => 'AQI視覺化介面',
            'discription' => '從web端顯示全台各空氣汙染數值。',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));  
        DB::table('portfolio')->insert(array(
            'id' => '2',
            'portfolio_category_id' => '4',
            'name' => 'IDW動態網頁',
            'discription' => '應用IDW視覺化PM2.5趨勢走向，並用IDW修補ARIMA時序資料破損。',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
         
        DB::table('portfolio')->insert(array(
            'id' => '3',
            'portfolio_category_id' => '5',
            'name' => '個人履歷網系統',
            'discription' => '該個人履歷往有後台可調整前台資訊給使用者觀看。',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));  
        DB::table('portfolio')->insert(array(
            'id' => '4',
            'portfolio_category_id' => '6',
            'name' => '叫車app',
            'discription' => '',
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
