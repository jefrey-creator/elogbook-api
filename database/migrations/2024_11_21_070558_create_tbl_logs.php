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
        Schema::create('tbl_logs', function (Blueprint $table) {
            $table->integer('logs_id')->primary(true)->unique()->autoIncrement();
            $table->string('full_name');
            $table->string('date_visited');
            $table->string('time_in');
            $table->string('time_out')->nullable(true);
            // $table->foreignId('person_to_visit')->constrained('users')->onDelete('cascade');
            $table->integer('person_to_visit');
            $table->longText('purpose');
            $table->longText('action_taken')->nullable(true);
            $table->boolean('is_accepted')->comment('1=accepted | 0 = waiting')->default(0);
            $table->boolean('is_completed')->comment('1=completed | 0 = not completed')->default(0);
            $table->boolean('req_category')->comment('1 = consultation | 0 = visitor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_logs');
    }
};
