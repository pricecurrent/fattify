<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutriDialogMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutri_dialog_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('nutri_dialog_id')->constrained()->cascadeOnDelete();
            $table->text('prompt');
            $table->text('suggestions');
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
        Schema::dropIfExists('nutri_dialog_messages');
    }
}
