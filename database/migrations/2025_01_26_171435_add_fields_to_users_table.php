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
            $table->string('phone_number')->nullable(); 
            $table->date('birth_date')->nullable(); 
            $table->enum('role', ['admin', 'guru', 'murid'])->default('murid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('phone_number');
            Schema::dropIfExists('birth_date');
            Schema::dropIfExists('role');
        });
    }
};
