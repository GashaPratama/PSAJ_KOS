<?php

namespace App\Console\Commands;

use App\Models\Lease;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate invoices for due leases based on billing cycle';

    public function handle()
    {
        $leases = Lease::where('status_sewa','active')->get();
        foreach ($leases as $lease) {
            // Pseudocode: decide if an invoice is due based on last invoice and billing_cycle
            $kode = 'INV-'.Str::upper(Str::random(8));
            $lease->invoices()->create([
                'kode_invoice' => $kode,
                'total_tagihan' => $lease->room->harga_per_bulan,
                'tanggal_jatuh_tempo' => now()->addDays(7),
            ]);
        }

        $this->info('Invoices generated');
        return 0;
    }
}