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
        Schema::create('tbl_faculty', function (Blueprint $table) {
            $table->integer('faculty_id')->unique()->primary(true)->autoIncrement();
            $table->string('f_name');
            $table->string('m_name')->nullable(true);
            $table->string('l_name');
            $table->boolean('sex')->comment('1=male|0=female');
            $table->tinyInteger('availability')->comment('1 = available | 2 = busy | 3 = away')->default(1);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); //foreignkey
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_faculty');
    }
};
