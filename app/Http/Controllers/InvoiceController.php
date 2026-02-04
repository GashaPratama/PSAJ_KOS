<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Lease;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('lease.user')->paginate(20);
        return view('invoices.index', compact('invoices'));
    }

    public function uploadProof(Request $request, Invoice $invoice)
    {
        $request->validate(['bukti_transfer' => 'required|image|max:2048']);
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        $invoice->update([
            'bukti_transfer' => $path,
            'status_pembayaran' => 'pending',
        ]);

        return back();
    }

    public function verify(Request $request, Invoice $invoice)
    {
        // only admin
        $request->validate(['action' => 'required|in:verified,rejected']);
        $invoice->update(['status_pembayaran' => $request->action, 'tanggal_bayar' => $request->action === 'verified' ? now() : null]);
        return back();
    }

    public function print(Invoice $invoice)
    {
        // Use a PDF library (e.g. barryvdh/laravel-dompdf) to generate kwitansi
        // return PDF::loadView('invoices.print', compact('invoice'))->stream();
    }
}
