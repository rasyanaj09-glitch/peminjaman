<nav class="bg-indigo-600 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="/" class="text-xl font-bold tracking-wider">SIPEMINJAM ALAT</a>
        
        <div class="flex items-center space-x-6">
            <a href="/" class="hover:text-indigo-200">Katalog</a>
            
            @auth
                <a href="{{ route('borrowings.index') }}" class="hover:text-indigo-200">Riwayat Saya</a>
                <span class="text-sm bg-indigo-700 px-3 py-1 rounded-full">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-xs font-semibold">
                        Logout
                    </button>
                </form>
            @else
                <a href="/admin/login" class="bg-white text-indigo-600 px-4 py-1.5 rounded font-semibold text-sm hover:bg-gray-100">
                    Login / Panel
                </a>
            @endauth
        </div>
    </div>
</nav>