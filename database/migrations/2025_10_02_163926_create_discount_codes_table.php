<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id()->comment('Primary key: Unique ID for each discount code');
            $table->string('code')->unique()->comment('Unique discount code that users can apply at checkout');
            $table->tinyInteger('percentage')->unsigned()->comment('Discount percentage (0-100) to reduce the order total');
            $table->date('expires_at')->nullable()->comment('Expiry date of the discount code; null = no expiry');
            $table->boolean('single_use')->default(false)->comment('If true, code can only be used once per user/order');
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
        Schema::dropIfExists('discount_codes');
    }
}
