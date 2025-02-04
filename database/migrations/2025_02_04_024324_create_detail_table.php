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
        Schema::create('detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')
                ->constrained('barangs', 'id')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('faktur_id')
                ->constrained('faktur', 'id')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('subtotal');
            $table->string('qty');
            $table->string('hasil_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail');
    }
};
