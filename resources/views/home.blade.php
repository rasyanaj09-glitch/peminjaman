<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Peminjaman Alat</title>
    
    <!-- Script Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-blue-600">Daftar Alat Lab</h2>
            <div class="flex items-center space-x-3">
                @auth
                    <span class="text-sm text-gray-600">
                        Halo, <strong class="text-gray-900">{{ auth()->user()->name }}</strong> 
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded capitalize">
                            {{ auth()->user()->role }}
                        </span>
                    </span>
                    
                    @if(auth()->user()->role === 'peminjam')
                        <a href="{{ route('peminjaman.index') }}" class="bg-cyan-600 hover:bg-cyan-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">
                            Riwayat Saya
                        </a>
                    @else
                        <a href="/admin" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">
                            Dashboard Admin
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Login Peminjam
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Notification -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Grid Katalog -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 pb-12">
            @foreach($tools as $tool)
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between border border-gray-100">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $tool->name }}</h3>
                        
                        <div class="space-y-1 mb-4 text-sm text-gray-600">
                            <p><span class="font-semibold">Kategori:</span> {{ $tool->category->name ?? '-' }}</p>
                            <p>
                                <span class="font-semibold">Stok:</span> 
                                <span class="{{ $tool->stock > 0 ? 'text-green-600 font-bold' : 'text-red-500 font-bold' }}">
                                    {{ $tool->stock }} unit
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        @auth
                            @if(auth()->user()->role === 'peminjam')
                                <form action="{{ route('peminjaman.store', $tool->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Pinjam</label>
                                        <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Kembali</label>
                                        <input type="date" name="return_date" required class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm">
                                    </div>

                                    <button type="submit" 
                                        class="w-full py-2 px-4 rounded-lg font-medium text-sm {{ $tool->stock < 1 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 text-white' }}" 
                                        {{ $tool->stock < 1 ? 'disabled' : '' }}>
                                        {{ $tool->stock < 1 ? 'Stok Habis' : 'Pinjam Alat' }}
                                    </button>
                                </form>
                            @else
                                <div class="bg-gray-100 p-3 rounded-lg text-center text-xs text-gray-600">
                                    Akun <span class="font-semibold capitalize">{{ auth()->user()->role }}</span> tidak dapat meminjam alat.
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block text-center w-full bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition shadow">
                                Login untuk Meminjam
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>