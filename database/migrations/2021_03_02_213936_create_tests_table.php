<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tests');
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->integer('verification_code')->nullable();
            $table->integer('complete')->default(0);
            $table->string('vehicle_type')->nullable();
            $table->string('age')->nullable();
            $table->string('nationality')->nullable();
            $table->string('nationalityId')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('supplier_id')->nullable();
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
        Schema::dropIfExists('tests');
    }
}
