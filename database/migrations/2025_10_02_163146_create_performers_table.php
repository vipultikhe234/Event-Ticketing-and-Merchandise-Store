<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performers', function (Blueprint $table) {
            $table->id()->comment('Primary key: Unique ID for each performer');
            $table->string('name')->comment('Name of the performer');
            $table->text('bio')->nullable()->comment('Short biography/description of the performer');
            $table->string('image')->nullable()->comment('Profile image URL or path for the performer');
            $table->string('spotify_id')->nullable()->comment('Spotify Artist ID for API integration');
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
        Schema::dropIfExists('performers');
    }
}
