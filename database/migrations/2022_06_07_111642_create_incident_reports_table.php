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
            $table->id();
            $table->string('name');
            $table->string('department');
            $table->string('phone');
            $table->text('incident_details');
            $table->text('incident_causes');
            $table->text('recommendations');
            $table->text('additional_notes');
            $table->string('date');
            $table->string('location');
            $table->string('time');
            $table->boolean('police_notified')->default(false);
            $table->string('recieved_by')->nullable();
            $table->string('recieved_date')->nullable();
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
