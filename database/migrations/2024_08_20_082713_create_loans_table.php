<?php

use App\Models\LoanCategory;
use App\Models\Member;
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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Member::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(LoanCategory::class)->constrained()->cascadeOnDelete();
            $table->date('loan_date');
            $table->bigInteger('loan_nominal');
            $table->bigInteger('interest_rate');
            $table->bigInteger('nominal_return');
            $table->enum('status', ['Lunas', 'Belum']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
