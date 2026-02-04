Contoh alur dan tips implementasi:

1) Otomatisasi invoice
- Buat `Job` yang mencari `leases` aktif dan membuat `invoices` setiap billing cycle.
- Daftarkan ke scheduler `app/Console/Kernel.php`.

2) Verifikasi pembayaran
- Admin menandai invoice `verified`.
- Broadcast event `PaymentVerified` untuk update laporan dan notifikasi.

3) Cetak kwitansi
- Gunakan `barryvdh/laravel-dompdf` untuk generate PDF.

4) Keamanan
- Gunakan `password` hashing built-in, `spatie/laravel-permission` optional untuk role-permission.

5) Testing
- Buat Feature tests: register/login, upload bukti, verify payment, create complaint.
