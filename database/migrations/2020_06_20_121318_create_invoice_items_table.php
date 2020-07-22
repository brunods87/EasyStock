<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('invoice_id')->index();
            $table->unsignedInteger('material_id')->index();
            $table->decimal('quantity', 8, 3);
            $table->decimal('discount_1', 5, 2)->nullable()->default(0);
            $table->decimal('discount_2', 5, 2)->nullable()->default(0);
            $table->decimal('discount_3', 5, 2)->nullable()->default(0);
            $table->unsignedInteger('job_id')->index()->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('invoice_items');
    }
}
