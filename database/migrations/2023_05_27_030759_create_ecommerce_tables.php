<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // User table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address');
            $table->string('sex');
            $table->string('job');
            $table->date('birth_date');
            $table->string('phone_number');
            $table->timestamps();
        });

        // Category table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Color table
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Item table
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->string('image_url');
            $table->string('condition');
            $table->string('size');
            $table->string('region_of_origin');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('color_id')->constrained('colors');
            $table->boolean('is_sold')->default(false);
            $table->timestamps();
        });

        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(false);
        });

        // Status table
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        // Transaction table
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('buyer_id')->constrained('users');
            $table->foreignId('discount_id')->nullable()->constrained('discounts');
            $table->dateTime('transaction_date');
            $table->decimal('amount', 8, 2);
            $table->foreignId('status_id')->constrained('status');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('message_text');
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions');
            $table->text('message_text');
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
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('status');
        Schema::dropIfExists('items');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
}
