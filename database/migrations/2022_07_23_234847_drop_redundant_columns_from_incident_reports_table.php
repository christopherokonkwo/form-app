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
            $table->dropColumn('machine_type');
            $table->dropColumn('machine_number');
            $table->dropColumn('incident_detail_option');
            $table->dropColumn('incident_details');
        });
    }
};
