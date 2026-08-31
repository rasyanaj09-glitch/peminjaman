<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-blue-600">Riwayat Peminjaman Saya</h2>
            <div class="flex items-center space-x-3">
                <a href="{{ url('/') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">
                    &larr; Kembali ke Katalog
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <!-- Notification -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Tabel Riwayat -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Alat</th>
                            <th class="py-3 px-4">Tgl Pinjam</th>
                            <th class="py-3 px-4">Tgl Rencana Kembali</th>
                            <th class="py-3 px-4">Tgl Dikembalikan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($borrowings as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-4 font-semibold text-gray-900">{{ $item->tool->name ?? '-' }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($item->return_date)->format('d M Y') }}</td>
                                <td class="py-3 px-4">
                                    {{ $item->actual_return_date ? \Carbon\Carbon::parse($item->actual_return_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($item->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Pending</span>
                                    @elseif($item->status === 'approved')
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Disetujui</span>
                                    @elseif($item->status === 'rejected')
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Ditolak</span>
                                    @elseif($item->status === 'returned')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-semibold {{ $item->fine_amount > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                    Rp {{ number_format($item->fine_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-500">
                                    Belum ada riwayat peminjaman alat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>