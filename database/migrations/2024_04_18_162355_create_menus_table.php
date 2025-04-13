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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id')->nullable();
            $table->foreign('route_id')->references('id')->on('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('url', 50)->nullable();
            $table->string('name', 50);
            $table->string('icon', 50)->nullable();
            $table->tinyInteger('position')->default(0);
            $table->tinyInteger('state')->default(1)->comment = '0: Inactivo; 1 = Activo;';
            $table->unsignedBigInteger('created_user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
