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
        Schema::table('tipos_maquinaria', function (Blueprint $table) {
            $table->enum('tipo_medicion', ['horometro', 'kilometraje', 'ambos', 'ninguno'])
                ->default('ninguno')
                ->after('prefijo_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipos_maquinaria', function (Blueprint $table) {
            $table->dropColumn('tipo_medicion');
        });
    }
};
