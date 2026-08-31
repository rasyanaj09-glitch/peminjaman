@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Form Pengajuan Peminjaman</h2>
    
    <form action="{{ route('borrowings.store', $tool->id) }}" method="POST">
        @csrf
        
        <!-- Info Barang -->
        <div class="mb-4 bg-gray-50 p-3 rounded border">
            <p class="text-xs text-gray-500">Barang yang dipinjam:</p>
            <p class="font-bold text-gray-800">{{ $tool->name }}</p>
        </div>

        <!-- Tanggal Pinjam -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
            <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" required
                   class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Tanggal Kembali -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Tanggal Kembali</label>
            <input type="date" name="return_date" required
                   class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg">
            Kirim Permohonan
        </button>
    </form>
</div>
@endsection