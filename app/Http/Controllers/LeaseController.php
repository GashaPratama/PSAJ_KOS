<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Room;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index()
    {
        $leases = Lease::with(['user','room'])->paginate(20);
        return view('leases.index', compact('leases'));
    }

    public function store(Request $request)
    {
        // Use FormRequest to validate (StoreLeaseRequest)
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'tanggal_masuk' => 'required|date',
            'billing_cycle' => 'required|in:monthly,quarterly,yearly',
        ]);

        $lease = Lease::create($data);

        // Optionally set room status
        $lease->room->update(['status_kamar' => 'occupied']);

        return redirect()->route('leases.index');
    }

    public function show(Lease $lease)
    {
        return view('leases.show', compact('lease'));
    }

    // Example helper that would be used by scheduler to generate invoices
    public function generateInvoicesForLease(Lease $lease)
    {
        // Pseudocode: calculate amount, create invoice with kode_invoice unique
    }
}
