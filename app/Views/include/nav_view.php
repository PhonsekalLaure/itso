<!-- Mobile toggle button -->
<button class="sidebar-toggle-btn" onclick="document.querySelector('.sidebar').classList.toggle('open')">
    <span class="material-symbols-outlined">menu</span>
</button>

<div class="sidebar d-flex flex-column p-3">

    <!-- Logo + System Name -->
    <div class="text-center">
        <img src="<?= base_url('public/assets/images/logo.png') ?>" width="80" class="mb-2" alt="Logo">
        <div class="sidebar-title">ITSO Equipment<br>Management System</div>
    </div>

    <div class="sidebar-divider"></div>

    <!-- NAV LINKS -->
    <nav class="nav flex-column">
        <a href="<?= base_url('dashboard') ?>" class="nav-link">
            <span class="material-symbols-outlined">dashboard</span>Dashboard
        </a>

        <a href="<?= base_url('users') ?>" class="nav-link">
            <span class="material-symbols-outlined">group</span>Users
        </a>

        <a href="<?= base_url('equipments') ?>" class="nav-link">
            <span class="material-symbols-outlined">inventory_2</span>Equipment
        </a>

        <a href="<?= base_url('borrowing') ?>" class="nav-link">
            <span class="material-symbols-outlined">assignment_return</span>Borrowing
        </a>

        <a href="<?= base_url('returning') ?>" class="nav-link">
            <span class="material-symbols-outlined">assignment_turned_in</span>Returning
        </a>

        <a href="<?= base_url('reserving') ?>" class="nav-link">
            <span class="material-symbols-outlined">event_available</span>Reserving
        </a>

        <a href="<?= base_url('reports') ?>" class="nav-link">
            <span class="material-symbols-outlined">bar_chart</span>Reports
        </a>
    </nav>

    <!-- LOGOUT BUTTON (bottom aligned) -->
    <div class="mt-auto">
        <a href="<?= base_url('auth/logout') ?>"
            class="btn logout-btn w-100 mt-3 d-flex align-items-center justify-content-center">
            <span class="material-symbols-outlined me-1">logout</span>
            Logout
        </a>
    </div>

</div>