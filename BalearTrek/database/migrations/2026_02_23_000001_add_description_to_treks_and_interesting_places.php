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
        // Añadir columna description a treks
        Schema::table('treks', function (Blueprint $table) {
            if (!Schema::hasColumn('treks', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });

        // Añadir columna description a interesting_places
        Schema::table('interesting_places', function (Blueprint $table) {
            if (!Schema::hasColumn('interesting_places', 'description')) {
                $table->text('description')->nullable()->after('gps');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treks', function (Blueprint $table) {
            if (Schema::hasColumn('treks', 'description')) {
                $table->dropColumn('description');
            }
        });

        Schema::table('interesting_places', function (Blueprint $table) {
            if (Schema::hasColumn('interesting_places', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
