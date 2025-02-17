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
        Schema::table('invoices', function (Blueprint $table) {
            // Drop foreign key constraint and column
            $table->dropForeign(['wood_shipping_order_id']); // Adjust column name if necessary
            $table->dropColumn('wood_shipping_order_id');

            // Add a new unique 'code' column
            $table->string('code')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Add back the foreign key relation
            $table->foreignId('wood_shipping_order_id')
                ->constrained()
                ->cascadeOnDelete();

            // Drop the 'code' column
            $table->dropColumn('code');
        });
    }
};
