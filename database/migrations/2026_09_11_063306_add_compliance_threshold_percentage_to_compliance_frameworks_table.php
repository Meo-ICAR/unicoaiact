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
        Schema::table('compliance_frameworks', function (Blueprint $table) {
            $table->decimal('compliance_threshold_percentage', 5, 2)->default(80.00)->after('version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compliance_frameworks', function (Blueprint $table) {
            $table->dropColumn('compliance_threshold_percentage');
        });
    }
};
