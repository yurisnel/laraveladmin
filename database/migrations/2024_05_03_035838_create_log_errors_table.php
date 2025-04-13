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
        Schema::create('log_errors', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->text('request')->nullable();
            $table->text('params')->nullable();
            $table->text('body')->nullable();
            $table->string('status')->nullable();
            $table->string('trace')->nullable();
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
        Schema::dropIfExists('log_errors');
    }
};
