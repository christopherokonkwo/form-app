<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('location');
            $table->string('machine_number');
            $table->string('machine_type');
            $table->text('incident_detail_option');
            $table->text('incident_details')->nullable();
            $table->text('additional_notes')->nullable();
            $table->foreignUuid('recieved_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('reported_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('assigned_to')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incident_reports');
    }
};
