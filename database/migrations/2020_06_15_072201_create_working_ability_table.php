<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingAbilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_ability', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('working_ability_category_id');
            $table->string('name');
            $table->string('discription');
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
        Schema::dropIfExists('working_ability');
    }
}
