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
        Schema::table('trackers', function (Blueprint $table) {
            $table->integer('calories');
            $table->integer('carbohydrates');
            $table->integer('fats');
            $table->integer('protein');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropColumn('calories');
        $table->dropColumn('carbohydrates');
        $table->dropColumn('fats');
        $table->dropColumn('protein');
    }
};
