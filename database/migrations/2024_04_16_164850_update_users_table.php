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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->unsignedBigInteger('created_user_id')->after('remember_token');
            $table->unsignedBigInteger('role_id')->after('id');
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnUpdate()->restrictOnDelete();

            $table->string('fathername', 50)->nullable()->after('remember_token');
            $table->string('mothername', 50)->nullable()->after('fathername');
            $table->string('dni', 15)->nullable()->unique()->after('mothername');
            $table->tinyInteger('type')->default(0)->after('dni')->comment = '0: System; 1 = Client;';
            $table->tinyInteger('state')->default(1)->after('type')->comment = '0: Inactivo; 1 = Activo;';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('fathername');
            $table->dropColumn('mothername');
            $table->dropColumn('dni');
            $table->dropColumn('type');
            $table->dropColumn('state');
            $table->dropColumn('deleted_at');
        });
    }
};
