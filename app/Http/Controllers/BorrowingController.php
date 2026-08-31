<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // Halaman Riwayat Saya
    public function index()
    {
        $borrowings = Peminjaman::with('tool')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('peminjaman.index', compact('borrowings'));
    }

    // Proses Simpan Pengajuan Pinjaman Baru
    public function store(Request $request, Tool $tool)
    {
        $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        if ($tool->stock < 1) {
            return back()->with('error', 'Stok alat sedang tidak tersedia.');
        }

        Peminjaman::create([
            'user_id'     => Auth::id(),
            'tool_id'     => $tool->id,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status'      => 'pending',
            'fine_amount' => 0,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
    }
}