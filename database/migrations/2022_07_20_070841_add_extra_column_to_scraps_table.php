<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnToScrapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scraps', function (Blueprint $table) {
            $table->string('annual_wage')->nullable();
            $table->text('working_week')->nullable();
            $table->string('expected_duration')->nullable();
            $table->date('possible_start_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->string('apprenticeship_level')->nullable();
            $table->string('reference_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scraps', function (Blueprint $table) {
            $table->dropColumn(['annual_wage', 'working_week', 'expected_duration', 'possible_start_date', 'closing_date', 'apprenticeship_level', 'reference_number']);
        });
    }
}
