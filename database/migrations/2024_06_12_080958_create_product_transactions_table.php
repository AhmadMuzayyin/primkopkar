<?php

use App\Models\Member;
use App\Models\User;
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
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Member::class)->nullable()->cascadeOnDelete();
            $table->string('code')->unique();
            $table->date('transaction_date');
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('amount_price')->default(0);
            $table->enum('type', ['Cash', 'Credit']);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
