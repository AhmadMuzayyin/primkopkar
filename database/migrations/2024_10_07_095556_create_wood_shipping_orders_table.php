<?php

use App\JenisPengiriman;
use App\Models\Customer;
use App\Models\Provider;
use App\Models\Wood;
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
        Schema::create('wood_shipping_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Wood::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Provider::class)->constrained()->cascadeOnDelete();
            $table->date('tgl_pesanan');
            $table->date('tgl_kirim');
            $table->text('lokasi_pengambilan');
            $table->text('lokasi_pengantaran');
            $table->enum('jenis_pengiriman', [JenisPengiriman::m3->value, JenisPengiriman::angkutan->value]);
            $table->decimal('harga_per_m3', 10, 2)->nullable();
            $table->decimal('harga_per_angkutan', 10, 2)->nullable();
            $table->integer('kapasitas_angkutan_m3')->nullable();
            $table->decimal('total_biaya', 15, 2)->nullable();
            $table->enum('status', ['pending', 'success', 'cancel'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wood_shipping_orders');
    }
};
