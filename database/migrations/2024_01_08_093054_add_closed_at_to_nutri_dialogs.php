<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClosedAtToNutriDialogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nutri_dialogs', function (Blueprint $table) {
            $table->dateTime('closed_at')->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nutri_dialogs', function (Blueprint $table) {
            $table->dropColumn('closed_at');
        });
    }
}
