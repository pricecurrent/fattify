<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class MakeMealTimeFieldNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE nutrition_diary_entries MODIFY meal_time VARCHAR(30);");
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
