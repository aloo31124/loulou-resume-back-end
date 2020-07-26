<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id');
            $table->string('name');
            $table->bigInteger('sort');
            $table->boolean('is_show')->default(1);
            $table->boolean('is_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolio_category');
    }
}
