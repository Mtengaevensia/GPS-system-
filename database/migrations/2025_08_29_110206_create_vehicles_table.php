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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();       // Unique license plate
            $table->string('make');                         // Manufacturer (e.g., Toyota)
            $table->string('model');                        // Model (e.g., Hilux)
            $table->year('year');                           // Year of manufacture
            $table->enum('status', ['active', 'inactive', 'maintainance'])->default('active'); // Vehicle status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
