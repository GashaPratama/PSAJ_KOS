<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kamar',
        'tipe_kamar',
        'harga_per_bulan',
        'fasilitas',
        'status_kamar',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'harga_per_bulan' => 'decimal:2',
    ];

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
