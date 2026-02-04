<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['user','room'])->paginate(20);
        return view('complaints.index', compact('complaints'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'judul_aduan' => 'required|string|max:255',
            'deskripsi_aduan' => 'required|string',
            'foto_kerusakan' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_kerusakan')) {
            $data['foto_kerusakan'] = $request->file('foto_kerusakan')->store('complaints', 'public');
        }

        $data['user_id'] = $request->user()->id;
        Complaint::create($data);

        return back();
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate(['status_aduan' => 'required|in:pending,diproses,selesai','tanggapan_admin' => 'nullable|string']);
        $complaint->update($request->only('status_aduan','tanggapan_admin'));
        return back();
    }
}
