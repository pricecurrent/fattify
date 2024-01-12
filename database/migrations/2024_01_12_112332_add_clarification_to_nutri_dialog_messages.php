<?php

use App\Diary\AI\NutriDialogMessageType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('nutri_dialog_messages', function (Blueprint $table) {
            $table->text('clarification')->after('suggestions')->nullable();
            $table->string('type')->after('nutri_dialog_id')->default(NutriDialogMessageType::SUGGESTION);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nutri_dialog_messages', function (Blueprint $table) {
            $table->dropColumn('clarification');
            $table->dropColumn('type');
        });
    }
};
