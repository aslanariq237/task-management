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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');
            $table->foreignId('assigned_at')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('cascade');
            $table->string('code');
            $table->string('name');                    
            $table->string('description');
            $table->string('to_do')->nullable();
            $table->string('notes')->nullable();
            $table->enum('status', [                
                'completed',
                'overdue',
                'on_progress'
            ])->default('on_progress');
            $table->date('started_at');
            $table->date('ended_at');
            $table->timestamps();
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
