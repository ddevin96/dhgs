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
        Schema::create('hgraphs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->integer('nodes')->unsigned()->nullable();
            $table->integer('edges')->unsigned()->nullable();
            $table->integer('dnodemax')->unsigned()->nullable();
            $table->integer('dedgemax')->unsigned()->nullable();
            $table->float('dnodeavg')->unsigned()->nullable();
            $table->float('dedgeavg')->unsigned()->nullable();
            $table->longText('dnodes')->nullable();
            $table->longText('dedges')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
