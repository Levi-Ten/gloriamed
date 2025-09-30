<header class="header">
    <div class="container">
        <nav class="nav-header">
            <a href="{{ route('auth.logout') }}" class="btn-logout">Logout</a>
            <a href="{{ route('laborator.create') }}" class="btn-nav">Laborator | Forma</a>
            <a href="{{ route('proceduri.create') }}" class="btn-nav">Sala de proceduri | Forma</a>
            <a href="{{ route('cnam.create') }}" class="btn-nav">Adaugă pacient nou | Forma</a>
            <a href="{{ route('cnam.index') }}" class="btn-nav">Lista pacienți | Tabel</a>
            <a href="{{ route('proceduri.index') }}" class="btn-nav">Sala de proceduri | Tabel</a>
            <a href="{{ route('laborator.show') }}" class="btn-nav">Laborator | Tabel</a>
            
        </nav>
    </div>
</header>
