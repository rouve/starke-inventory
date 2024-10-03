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
        Schema::create('batch_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('batches')->cascadeOnDelete();
            $table->string('item_no')->nullable(false);
            $table->string('name')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->string('end_1')->nullable();
            $table->string('end_2')->nullable();
            $table->string('end_3')->nullable();
            $table->string('end_4')->nullable();
            $table->string('item_length_angle')->nullable();
            $table->float('area')->nullable();
            $table->string('insulation')->nullable();
            $table->string('connector_1')->nullable();
            $table->string('connector_2')->nullable();
            $table->string('notes')->nullable();
            $table->integer('long_side')->nullable();
            $table->string('material')->nullable();
            $table->integer('count_1')->nullable();
            $table->integer('count_2')->nullable();
            $table->integer('variance')->nullable();
            $table->unsignedBigInteger('count_1_user_id')->nullable();
            $table->foreign('count_1_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('count_2_user_id')->nullable();
            $table->foreign('count_2_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_items');
    }
};
