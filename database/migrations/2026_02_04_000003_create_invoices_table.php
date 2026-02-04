<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->constrained('leases')->onDelete('cascade');
            $table->string('kode_invoice')->unique();
            $table->decimal('total_tagihan', 12, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->string('bukti_transfer')->nullable();
            $table->string('nama_rekening_pengirim')->nullable();
            $table->decimal('jumlah_transfer', 12, 2)->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->enum('status_pembayaran', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};