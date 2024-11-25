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
        Schema::create('tbl_mailer', function (Blueprint $table) {
            $table->integer('mail_id')->primary(true)->unique()->autoIncrement();
            $table->longText('mail_body')->nullable(true);
            $table->string('mail_subject')->nullable(true);
            $table->string('mail_tag')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_mailer');
    }
};
