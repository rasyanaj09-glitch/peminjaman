@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman Saya</h2>
        <a href="/" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
            + Pinjam Alat Baru
        </a>
    </div>

    <!-- Tabel Data Riwayat -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold border-b">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Nama Alat</th>
                    <th class="p-4">Tgl Pinjam</th>
                    <th class="p-4">Tgl Kembali</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm text-gray-700">
                @forelse($borrowings as $index => $b)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium text-gray-500">{{ $index + 1 }}</td>
                    <td class="p-4 font-bold text-gray-800">{{ $b->tool->name ?? 'Alat Dihapus' }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}</td>
                    <td class="p-4">
                        @if($b->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 font-medium px-2.5 py-1 rounded-full text-xs">
                                Menunggu Persetujuan
                            </span>
                        @elseif($b->status == 'approved')
                            <span class="bg-green-100 text-green-800 font-medium px-2.5 py-1 rounded-full text-xs">
                                Disetujui / Dipinjam
                            </span>
                        @elseif($b->status == 'rejected')
                            <span class="bg-red-100 text-red-800 font-medium px-2.5 py-1 rounded-full text-xs">
                                Ditolak
                            </span>
                        @else
                            <span class="bg-blue-100 text-blue-800 font-medium px-2.5 py-1 rounded-full text-xs">
                                Sudah Dikembalikan
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($b->fine_amount > 0)
                            <span class="text-red-600 font-bold">
                                Rp {{ number_format($b->fine_amount, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">
                        Belum ada riwayat peminjaman alat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection