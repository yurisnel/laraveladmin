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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->unique();
            $table->string('dni', 15)->unique();
            $table->string('email')->unique();
            $table->string('telephone');
            $table->text('address');
            $table->string('giro');
            $table->string('contact_name');
            $table->string('contact_telephone');
            $table->tinyInteger('type')->default(2)->comment = '1: Interna; 2 = Client';
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_user_id');
            $table->tinyInteger('state')->default(1)->comment = '0: Inactivo; 1 = Activo;';
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
