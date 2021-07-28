<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookmarkedAtToNutritionDiaryEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nutrition_diary_entries', function (Blueprint $table) {
            $table->timestamp('bookmarked_at')->nullable()->after('dish_name');
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
            $table->dropColumn('bookmarked_at');
        });
    }
}
