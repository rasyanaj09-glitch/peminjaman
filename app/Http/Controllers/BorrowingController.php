<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Tool;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Menampilkan daftar riwayat peminjaman user
     */
    public function index()
    {
        $borrowings = Peminjaman::with('tool')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjaman.index', compact('borrowings'));
    }

    /**
     * Menampilkan form peminjaman alat
     */
    public function create(Tool $tool)
    {
        // Cek stok alat sebelum menampilkan form
        if ($tool->stock < 1) {
            return back()->with('error', 'Maaf, stok alat ini sedang habis.');
        }

        return view('peminjaman.create', compact('tool'));
    }

    /**
     * Menyimpan data pengajuan peminjaman
     */
    public function store(Request $request, Tool $tool)
    {
        // Validasi input tanggal
        $request->validate([
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        // Cek kembali ketersediaan stok
        if ($tool->stock < 1) {
            return back()->with('error', 'Maaf, stok alat ini sedang habis.');
        }

        // Simpan data peminjaman ke database
        Peminjaman::create([
            'user_id'     => auth()->id(),
            'tool_id'     => $tool->id,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status'      => 'pending',
            'fine_amount' => 0,
        ]);

        // Redirect ke halaman riwayat peminjaman dengan pesan sukses
        return redirect()->route('peminjaman.index')
            ->with('success', 'Permohonan peminjaman berhasil diajukan! Silakan tunggu konfirmasi admin.');
    }
}