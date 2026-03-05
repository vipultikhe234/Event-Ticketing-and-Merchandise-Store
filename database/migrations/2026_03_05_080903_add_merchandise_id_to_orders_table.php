<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddMerchandiseIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Make event_id nullable using raw SQL to avoid doctrine/dbal dependency
        Schema::table('orders', function (Blueprint $table) {
            DB::statement('ALTER TABLE orders MODIFY event_id BIGINT UNSIGNED NULL');
            $table->foreignId('merchandise_id')->nullable()->constrained('merchandises')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['merchandise_id']);
            $table->dropColumn('merchandise_id');
            DB::statement('ALTER TABLE orders MODIFY event_id BIGINT UNSIGNED NOT NULL');
        });
    }
}
