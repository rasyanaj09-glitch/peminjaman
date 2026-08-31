<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Peminjaman Alat</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f9f9f9; }
        .nav { display: flex; justify-content: space-between; align-items: center; background: #ffffff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .grid { display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap; }
        .card { background: white; border: 1px solid #ddd; padding: 15px; border-radius: 8px; width: 260px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .btn { padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; text-decoration: none; cursor: pointer; display: inline-block; text-align: center; }
        .btn:disabled { background: #6c757d; cursor: not-allowed; }
        .btn-danger { background: #dc3545; }
        .btn-warning { background: #ffc107; color: black; }
        .alert { padding: 10px 15px; border-radius: 4px; margin-top: 15px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <!-- Bar Navigasi Login / Logout -->
    <div class="nav">
        <h2>Daftar Alat Lab</h2>
        <div>
            @auth
                <!-- Jika Sudah Login -->
                <span style="margin-right: 10px;">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                <a href="{{ route('borrowings.index') }}" class="btn" style="background: #17a2b8; margin-right: 5px;">Riwayat Saya</a>
                
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            @else
                <!-- Jika Belum Login -->
                <a href="{{ route('login') }}" class="btn">Login Peminjam</a>
            @endauth
        </div>
    </div>

    <!-- Flash Message Notification -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- Daftar Katalog Alat -->
    <div class="grid">
        @foreach($tools as $tool)
            <div class="card">
                <h3 style="margin-top: 0;">{{ $tool->name }}</h3>
                <p><strong>Kategori:</strong> {{ $tool->category->name ?? '-' }}</p>
                <p><strong>Stok:</strong> {{ $tool->stock }} unit</p>

                @auth
                    <!-- FORM PINJAM (Hanya tampil jika sudah Login) -->
                    <form action="{{ route('borrowings.store', $tool->id) }}" method="POST">
                        @csrf
                        <label style="font-size: 12px;">Tgl Pinjam:</label>
                        <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" required style="width: 90%; margin-bottom: 8px; padding: 4px;">
                        
                        <label style="font-size: 12px;">Tgl Kembali:</label>
                        <input type="date" name="return_date" required style="width: 90%; margin-bottom: 12px; padding: 4px;">

                        <button type="submit" class="btn" style="width: 100%;" {{ $tool->stock < 1 ? 'disabled' : '' }}>
                            {{ $tool->stock < 1 ? 'Stok Habis' : 'Pinjam Alat' }}
                        </button>
                    </form>
                @else
                    <!-- Tombol Arahkan ke Login (Jika Belum Login) -->
                    <a href="{{ route('login') }}" class="btn btn-warning" style="width: 90%;">Login untuk Meminjam</a>
                @endauth
            </div>
        @endforeach
    </div>

</body>
</html>