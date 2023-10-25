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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('details');
            $table->enum('type', array('residential','commercial'));
            $table->text('size')->nullable()->comment('if residential then 2 BHK, 3 BHK otherwise null');
            $table->string('address');
            $table->string('brochure')->nullable()->comment('PDF File');
            $table->string('brochure_path')->nullable()->comment('PDF File path');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
