<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id()->comment('Primary key: Unique ID for each event');
            $table->string('title')->comment('Title of the event');
            $table->text('description')->nullable()->comment('Detailed description of the event');
            $table->date('date')->comment('Date when the event will take place');
            $table->time('time')->comment('Start time of the event');
            $table->string('venue')->comment('Venue or location where the event is held');
            $table->decimal('ticket_price', 8, 2)->comment('Price per ticket for the event');
            $table->foreignId('performer_id')->constrained()->cascadeOnDelete()->comment('Foreign key referencing performers.id, performer linked to event');
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
        Schema::dropIfExists('events');
    }
}
