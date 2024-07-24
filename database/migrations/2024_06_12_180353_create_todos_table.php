<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->boolean('is_long_term')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('grace_period_extends_till')->nullable();
            $table->integer('completed_by')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('todo_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('todo_id');
            $table->bigInteger('user_id');
            $table->dateTime('due_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
