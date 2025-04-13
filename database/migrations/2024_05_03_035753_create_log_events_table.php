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
        Schema::create('log_events', function (Blueprint $table) {
            $table->id();
            $table->integer('loggable_id');
            $table->string('loggable_type');
            $table->string('event_name');
            $table->string('description');
            $table->text('data')->nullable();
            $table->text('original')->nullable();
            $table->string('ip', 50);
            $table->string('browser', 50);
            $table->string('so', 50);
            $table->integer('created_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_events');
    }
};
