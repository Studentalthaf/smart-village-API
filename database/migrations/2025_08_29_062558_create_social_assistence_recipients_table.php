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
        Schema::create('social_assistence_recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('social_assistence_id');
            $table->foreign('social_assistence_id')->references('id')->on('social_assistences');

            $table->uuid('head_of_family_id');
            $table->foreign('head_of_family_id')->references('id')->on('head_of_families');


            $table->decimal('amount', 10, 2);
            $table->longText('reason');
            $table->enum('bank', ['bri', 'bni', 'mandiri', 'bca']);
            $table->integer('account_number');
            $table->string('proof');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_assistence_recipients');
    }
};
