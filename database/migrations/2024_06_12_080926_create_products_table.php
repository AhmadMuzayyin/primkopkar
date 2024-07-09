<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->bigInteger('price')->default(0);
            $table->text('description')->nullable();
            $table->bigInteger('purchase_price')->default(0);
            $table->bigInteger('margin')->default(0);
            $table->bigInteger('stock')->default(0);
            $table->bigInteger('shu')->default(0);
            $table->bigInteger('price_credit')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
