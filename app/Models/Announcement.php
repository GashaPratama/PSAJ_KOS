<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'isi_pengumuman',
        'target_role',
    ];

    public static function forRole(string $role)
    {
        return static::where('target_role', $role)
            ->orWhere('target_role', 'all');
    }
}
