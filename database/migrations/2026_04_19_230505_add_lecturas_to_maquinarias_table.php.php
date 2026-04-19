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
        Schema::table('maquinarias', function (Blueprint $table) {
            $table->decimal('horometro_actual', 10, 2)->default(0)->after('descripcion');
            $table->decimal('kilometraje_actual', 10, 2)->default(0)->after('horometro_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maquinarias', function (Blueprint $table) {
            $table->dropColumn(['horometro_actual', 'kilometraje_actual']);
        });
    }
};
