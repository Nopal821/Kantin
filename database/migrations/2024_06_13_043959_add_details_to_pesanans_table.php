<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToPesanansTable extends Migration
{
    public function up()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('student_name')->nullable();
            $table->decimal('amount_given', 10, 2)->nullable();
            $table->decimal('change', 10, 2)->nullable();
            $table->string('status')->default('pending');
        });
    }

    public function down()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('student_name');
            $table->dropColumn('amount_given');
            $table->dropColumn('change');
            $table->dropColumn('status');
        });
    }
}
