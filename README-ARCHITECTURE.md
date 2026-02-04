Ringkasan arsitektur dan best-practice:

- Gunakan `FormRequest` untuk validasi input ke controller.
- Gunakan `Resource Controllers` untuk CRUD standar.
- Gunakan `Policies` / `Gates` untuk otorisasi (mis. verifikasi pembayaran hanya untuk admin).
- Job/Scheduler untuk generate invoice otomatis (mis: php artisan schedule:run). Create a job `GenerateMonthlyInvoices` and a command.
- Gunakan events (PaymentVerified) untuk handling post-payment (kirim notifikasi, update laporan).
- Simpan file upload di disk `public` dan output url via `Storage::url()`.
- Buat `ActivityLog` setiap aksi penting di listener atau service.
