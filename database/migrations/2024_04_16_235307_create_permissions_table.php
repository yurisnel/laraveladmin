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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('name', 50)->unique();
            $table->string('description', 255);
            $table->text('include')->nullable()->comment = 'Nombre de permisos incluidos separados por comas';
            $table->tinyInteger('is_system')->default(0)->comment = '0: No es del sitema, se puede modificar; 1 = Es del sistema, no se puede modificar;';
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
        Schema::dropIfExists('permissions');
    }
};
