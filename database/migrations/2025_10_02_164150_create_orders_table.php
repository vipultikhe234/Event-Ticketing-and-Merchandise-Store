<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->comment('Primary key: Unique ID for each order');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->comment('Reference to users.id; nullable for guest orders');
            $table->decimal('total_amount', 10, 2)->comment('Total amount to be paid for this order');
            $table->string('status')->default('pending')->comment('Order status: pending, paid, failed');
            $table->integer('quantity')->default(1)->comment('Number of items purchased in this order item');
            $table->string('stripe_session_id')->nullable()->comment('Stripe Checkout session ID for payment tracking');
            $table->string('discount_code')->nullable()->comment('Applied discount code for this order, if any');
            $table->unsignedBigInteger('event_id')->comment('Foreign key referencing the event for which the order is placed');

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
        Schema::dropIfExists('orders');
    }
}
