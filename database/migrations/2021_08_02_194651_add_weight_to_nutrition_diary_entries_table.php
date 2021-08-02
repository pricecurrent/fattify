<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeightToNutritionDiaryEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nutrition_diary_entries', function (Blueprint $table) {
            $table->after('meal_time', fn ($table) => $table->integer('weight')->nullable());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nutrition_diary_entries', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
}
