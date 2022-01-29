<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scraps', function (Blueprint $table) {
            $table->id();
            $table->string('job_title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('job_site_url')->nullable();
            $table->string('job_reference')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->string('job_state')->nullable(); // state or city
            $table->string('job_location')->nullable();
            $table->string('job_salary')->nullable();
            $table->string('job_industry')->nullable(); // job category
            $table->string('job_company')->nullable(); // job company
            $table->longText('job_short_description')->nullable();
            $table->longText('job_description')->nullable();
            $table->string('job_type')->nullable();
            $table->string('job_salary_range')->nullable();
            $table->string('job_experience')->nullable();
            $table->string('job_duration')->nullable();
            $table->string('job_skills')->nullable();
            $table->string('job_tags')->nullable();
            $table->date('job_posted')->nullable();
            $table->string('site_name')->nullable();
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
        Schema::dropIfExists('scraps');
    }
}
