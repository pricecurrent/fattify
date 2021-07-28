<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMadeFromBookmarkIdToNutritionDiaryEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nutrition_diary_entries', function (Blueprint $table) {
            $table->foreignId('made_from_bookmark_id')->nullable()->after('dish_name');
            $table->foreign('made_from_bookmark_id', 'made_from_bookmark_id_foreign')
                ->references('id')
                ->on('bookmarks')
                ->onDelete('set null');
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
            $table->dropForeign('made_from_bookmark_id_foreign');
            $table->dropColumn('made_from_bookmark_id');
        });
    }
}
