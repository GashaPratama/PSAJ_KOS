<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user() ? $request->user()->role : 'pengunjung';
        $announcements = Announcement::forRole($role)->latest()->paginate(20);
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'target_role' => 'required|string',
        ]);

        Announcement::create($data);
        return back();
    }
}
