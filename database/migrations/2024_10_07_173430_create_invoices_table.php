<?php

use App\Models\WoodShippingOrder;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WoodShippingOrder::class)->constrained()->cascadeOnDelete();
            $table->string('no_faktur');
            $table->date('tgl_faktur');
            $table->integer('total_harga');
            $table->date('tgl_jatuh_tempo');
            $table->enum('status', ['Lunas', 'Belum Lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
