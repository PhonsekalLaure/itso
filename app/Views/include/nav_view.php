<nav class="navbar navbar-expand-lg navbar-sisig shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
            <img src="<?= base_url('public/assets/images/logo.png'); ?>" alt="Logo" width="40" height="40"
                class="sisig-logo me-2">
            <span class="sisig-title">Aling Basyang Sisigan</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active d-flex align-items-center" aria-current="page"
                        href="<?= base_url('users') ?>">
                        <i class="bi bi-people-fill me-1"></i> Users List
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="<?= base_url('products') ?>">
                        <i class="bi bi-basket2-fill me-1"></i> Products
                    </a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <a class="nav-link d-flex align-items-center" href="<?= base_url('auth/logout') ?>">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    Logout
                </a>
            </form>
        </div>
    </div>
</nav>
<!-- Add Bootstrap Icons CDN and Google Fonts in your main layout if not yet included -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet"> -->