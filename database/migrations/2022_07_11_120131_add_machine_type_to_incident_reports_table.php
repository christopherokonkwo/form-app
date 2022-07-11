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
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->dropColumn(['incident_causes', 'incident_status', 'date', 'time', 'police_notified']);
            $table->string('machine_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->text('incident_causes');
            $table->text('incident_status');
            $table->string('date');
            $table->string('time');
            $table->boolean('police_notified')->default(false);

            $table->dropColumn(['machine_type']);
        });
    }
};
