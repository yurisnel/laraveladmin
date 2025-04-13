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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description', 255)->nullable();
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
        Schema::dropIfExists('roles');
    }
};
