<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stand_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('stand_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::EnableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stand_favorites', function (Blueprint $table) {
            $table->dropForeign(["user_id", "stand_id"]);
        });
        Schema::dropIfExists('stand_favorites');
    }
};
