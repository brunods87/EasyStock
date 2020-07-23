<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id')->index();
            $table->unsignedInteger('expense_id')->nullable();
            $table->string('expense_type')->nullable();
            $table->decimal('quantity', 8, 3);
            $table->decimal('quantity_extra', 8, 3)->nullable();
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
        Schema::dropIfExists('job_expenses');
    }
}
