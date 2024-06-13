<?php

use App\Models\Product;
use App\Models\ProductTransaction;
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
        Schema::create('product_item_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductTransaction::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->bigInteger('price')->default(0);
            $table->bigInteger('margin')->default(0);
            $table->bigInteger('shu')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_item_transactions');
    }
};
