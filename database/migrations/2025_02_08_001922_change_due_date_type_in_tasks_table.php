<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDueDateTypeInTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dateTime('due_date')->change(); // Ubah tipe menjadi dateTime
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->date('due_date')->change(); // Kembalikan ke date jika rollback
        });
    }
}
