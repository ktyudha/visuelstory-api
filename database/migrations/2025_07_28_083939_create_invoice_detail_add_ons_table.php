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
        Schema::create('invoice_detail_add_ons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_detail_id')->constrained('invoice_details')->onDelete('cascade');
            $table->foreignUuid('package_addon_id')->constrained('package_addons')->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(0);
            $table->string('amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_detail_add_ons');
    }
};
