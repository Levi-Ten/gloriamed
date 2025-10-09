<header class="header">
    <div class="container">
        <nav class="nav-header">
            <a href="{{ route('auth.logout') }}" class="btn-logout">Logout</a>
            <a href="{{ route('laborator.create') }}" class="btn-nav">Laborator</a>
            <a href="{{ route('proceduri.index') }}" class="btn-nav">Sala de proceduri</a>
            <a href="{{ route('cnam.index') }}" class="btn-nav">Lista pacienți</a>

        </nav>
    </div>
</header>
<script>
    const currentURL = window.location.href;
    const navLinks = document.querySelectorAll('.nav-header .btn-nav');

    navLinks.forEach(link => {
        if (currentURL.includes(link.href)) {
            link.classList.add('active');
        }
    });
</script>