<!-- Header / Navigasi Auth -->
@auth
    <p>Halo, {{ auth()->user()->name }}</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@else
    <a href="{{ route('login') }}">Login</a>
@endauth

<hr>

<!-- Daftar Alat -->
@foreach($tools as $tool)
    <div>
        <h3>{{ $tool->name }}</h3>
        <p>Stok: {{ $tool->stock }}</p>

        @auth
            <!-- Form Pinjam jika sudah login -->
            <form action="{{ route('borrow.store', $tool->id) }}" method="POST">
                @csrf
                <input type="date" name="borrow_date" required>
                <input type="date" name="return_date" required>
                <button type="submit">Pinjam Sekarang</button>
            </form>
        @else
           
            <a href="{{ route('login') }}">Login untuk Meminjam</a>
        @endauth
    </div>
@endforeach