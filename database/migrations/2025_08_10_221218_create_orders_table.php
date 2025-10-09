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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'ready', 'delivered', 'cancelled'])
            ->default('pending');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('stand_id')->constrained()->onDelete('cascade');
            
            // Statut Commandes
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            // Generation de code
            $table->string('pickup_code', 4)->nullable()->unique();
            $table->timestamp('code_generated_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->boolean('code_used')->default(false);
            $table->timestamps();
        });

        Schema::EnableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(["user_id", "stand_id"]);
        });
        Schema::dropIfExists('orders');
    }
};
