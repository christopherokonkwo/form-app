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
            $table->removeColumn('machine_type');
            $table->removeColumn('machine_number');
            $table->removeColumn('machine_number');
            $table->removeColumn('incident_detail_option');
            $table->removeColumn('incident_details');
        });
    }
};
