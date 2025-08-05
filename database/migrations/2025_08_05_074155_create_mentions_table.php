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
        Schema::create('mentions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('mentionable_id');
    $table->string('mentionable_type');
    $table->foreignId('mentioned_user_id')->constrained('users')->onDelete('cascade');
    $table->timestamps();
    $table->index(['mentionable_id', 'mentionable_type']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentions');
    }
};
