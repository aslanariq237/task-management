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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('cascade');
            $table->foreignId('vendor_id')
                  ->nullable()
                  ->references('id')
                  ->on('vendors')
                  ->onDelete('cascade');
            $table->string('code');
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('description');
            $table->enum('status', [
                'planned',
                'ongoing',
                'complete',
                'failed'
            ])->default('planned');
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->timestamps();
        });
    }

    protected $casts = [
        'started_at' => 'date',
        'ended_at'   => 'date'
    ];

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
