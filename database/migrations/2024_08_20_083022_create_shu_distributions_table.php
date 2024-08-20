<?php

use App\Models\Member;
use App\Models\SavingCategory;
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
        Schema::create('shu_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Member::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SavingCategory::class)->constrained()->cascadeOnDelete();
            $table->bigInteger('amount_saving_member');
            $table->bigInteger('total_saving_all_member');
            $table->bigInteger('total_distribution_shu');
            $table->bigInteger('shu_accepted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shu_distributions');
    }
};
