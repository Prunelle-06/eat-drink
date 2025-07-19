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
        Schema::create('stands', function (Blueprint $table) {
            $table->id();
            $table->string('nom_stand');
            $table->string('description_stand')->nullable();
            $table->foreignId('user_id')->unique()->constrained();
            $table->timestamps();
        });

        Schema::EnableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stands', function (Blueprint $table) {
            $table->dropForeign(["user_id"]);
        });
        Schema::dropIfExists('stands');
    }
};
