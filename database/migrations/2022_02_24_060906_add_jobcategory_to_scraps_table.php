<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobcategoryToScrapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scraps', function (Blueprint $table) {
            $table->string('seniority_level')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('job_function')->nullable();
            $table->string('industries')->nullable()->comment('job category');
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
            $table->dropColumn(['seniority_level', 'employment_type', 'job_function', 'industries']);
        });
    }
}
