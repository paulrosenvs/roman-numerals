<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRomanNumeralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roman_numerals', function (Blueprint $table) {
            $table->smallInteger('int_val');
            $table->string('roman_numeral');
            $table->integer('num_conversions');
            $table->timestamps();

            $table->primary('int_val');
            $table->index('num_conversions');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     ;
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roman_numerals');
    }
}
