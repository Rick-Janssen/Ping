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
        Schema::create('past_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id');
            $table->string('host_name');
            $table->string('error');
            $table->string('type');
            $table->string('ms');
            $table->timestamps();
            $table->dropColumn('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_errors');
    }
};
