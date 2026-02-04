<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_id',
        'kode_invoice',
        'total_tagihan',
        'tanggal_jatuh_tempo',
        'bukti_transfer',
        'nama_rekening_pengirim',
        'jumlah_transfer',
        'tanggal_bayar',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
        'total_tagihan' => 'decimal:2',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
