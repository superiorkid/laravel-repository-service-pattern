<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use \App\Enums\TaskStatus;
use \App\Enums\TaskPriority;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table
                ->enum('status', array_column(TaskStatus::cases(), 'value'))
                ->default(TaskStatus::TODO->value);
            $table
                ->enum('priority', array_column(TaskPriority::cases(), "value"))
                ->default(TaskPriority::LOW);
            $table->unsignedBigInteger('category_id')->index();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
