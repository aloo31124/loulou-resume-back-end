<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPortfolioCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        DB::table('portfolio_category')->insert(array(
            'id' => '1',
            'parent_id' => '0',//父節點為 [總目錄]
            'name' => '大學作品',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('portfolio_category')->insert(array(
            'id' => '2',
            'parent_id' => '0',//父節點為 [總目錄]
            'name' => '自行開發系統',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('portfolio_category')->insert(array(
            'id' => '3',
            'parent_id' => '1',
            'name' => '專題作品',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('portfolio_category')->insert(array(
            'id' => '4',
            'parent_id' => '1',
            'name' => '研究所開發系統/論文',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('portfolio_category')->insert(array(
            'id' => '5',
            'parent_id' => '2',
            'name' => '網頁',
            'sort' => '0',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
        DB::table('portfolio_category')->insert(array(
            'id' => '6',
            'parent_id' => '2',
            'name' => '手機app',
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
