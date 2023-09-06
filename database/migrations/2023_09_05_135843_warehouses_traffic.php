<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouses_traffic', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('warehouse_id')->unsigned();
            $table->integer('qty');
            $table->enum('type_id', [1,2])->comment('1 - приход, 2 - расход');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('warehouses_traffic', function (Blueprint $table) {
            $table->dropForeign('warehouses_traffic_product_id_foreign');
            $table->dropForeign('warehouses_traffic_warehouse_id_foreign');
        });
        Schema::dropIfExists('warehouses_traffic');
    }
};
