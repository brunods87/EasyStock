<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reference');
            $table->unsignedInteger('supplier_id')->index();
            $table->unsignedInteger('unity_id')->index();
            $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('type_id')->index();
            $table->decimal('price', 8, 3)->default(0.000);
            $table->decimal('discount', 5, 2)->nullable();
            $table->boolean('taxable')->default(1);
            $table->unsignedInteger('tax');
            $table->decimal('stock', 8, 3)->default(0);
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
        Schema::dropIfExists('materials');
    }
}
