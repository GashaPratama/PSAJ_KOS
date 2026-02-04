# ERD & Contoh Query Eloquent 🔧

## Relasi Utama
- User hasMany Leases, Complaints, ActivityLogs
- Room hasMany Leases, Complaints
- Lease hasMany Invoices
- Invoice belongsTo Lease
- Announcement target_role

## Contoh Eloquent Queries

- Cek ketersediaan kamar:
```
Room::where('status_kamar','available')->get();
```

- Ambil semua sewa aktif pengguna:
```
$leases = $user->leases()->where('status_sewa','active')->with('room','invoices')->get();
```

- Generate invoice monthly (pseudocode):
```
$lease->invoices()->create([
    'kode_invoice' => 'INV-'.Str::upper(Str::random(8)),
    'total_tagihan' => $lease->room->harga_per_bulan,
    'tanggal_jatuh_tempo' => now()->addDays(7),
]);
```

- Admin verifikasi pembayaran:
```
$invoice->update(['status_pembayaran' => 'verified', 'tanggal_bayar' => now()]);
```

- Ambil pengumuman untuk user:
```
$announcements = Announcement::forRole($user->role)->latest()->get();
```

- Catat activity log:
```
ActivityLog::create([ 'user_id' => $user->id, 'aksi' => 'verifikasi_pembayaran', 'keterangan' => '...']);
```
