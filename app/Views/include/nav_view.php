    <style>
        /* Sidebar gradient */
        .sidebar {
            background: linear-gradient(to bottom, #0b824a, #fabc15);
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;

            }

        .sidebar a {
    display: block;
    padding: 12px 20px;
    color: white; /* default */
    text-decoration: none;
    font-size: 16px;
}

.sidebar a:hover {
    background: rgba(255, 255, 255, 0.2);
}

.sidebar a.active {
    background: white;  
    color: #1b3a4b; /* text turns dark when active */
    font-weight: bold;
}


        /* Sidebar title */
        .sidebar-title {
            font-family: 'Cinzel', serif;
            font-size: 1.2rem;
            color: white;
        }

        /* Divider */
        .sidebar-divider {
            height: 1px;
            width: 100%;
            background-color: white;
            margin: 10px 0;
            opacity: 0.6;
        }

        /* Nav buttons */
        .sidebar .nav-link {
            border-radius: 8px;
            margin-bottom: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
        }

        /* Active */
        .nav-active {
            background-color: #fabc15 !important;
            color: white !important;
        }

        /* Inactive */
        .nav-inactive {
            background-color: white !important;
            color: black !important;
        }

        /* Logout button */
        .logout-btn {
            background-color: rgba(255,255,255,0.85);
            color: black;
            border-radius: 8px;
            font-weight: 600;
        }
        .logout-btn:hover {
            background-color: white;
        }

        /* Responsive: Sidebar collapses */
        @media(max-width: 992px) {
            .sidebar {
                position: fixed;
                z-index: 2000;
                transform: translateX(-260px);
                transition: 0.3s ease;
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }

        /* Toggle button */
        .sidebar-toggle-btn {
            display: none;
        }

        @media(max-width: 992px) {
            .sidebar-toggle-btn {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 2100;
                background-color: #0b824a;
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 6px;
            }
        }
    </style>

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
        <a href="<?= base_url('dashboard') ?>" 
           class="nav-link">
           <span class="material-symbols-outlined">dashboard</span>Dashboard
        </a>

        <a href="<?= base_url('users') ?>" 
           class="nav-link">
           <span class="material-symbols-outlined">group</span>Users
        </a>

        <a href="<?= base_url('equipment') ?>" 
           class="nav-link">
           <span class="material-symbols-outlined">inventory_2</span>Equipment
        </a>

        <a href="<?= base_url('borrowing') ?>" 
           class="nav-link">
           <span class="material-symbols-outlined">assignment_return</span>Borrowing
        </a>

        <a href="<?= base_url('returning') ?>" 
           class="nav-link">
           <span class="material-symbols-outlined">assignment_turned_in</span>Returning
        </a>

        <a href="<?= base_url('reserving') ?>" 
           class="nav-link">
           <span class="material-symbols-outlined">event_available</span>Reserving
        </a>

        <a href="<?= base_url('reports') ?>" 
           class="nav-link">
           <span class="material-symbols-outlined">bar_chart</span>Reports
        </a>
    </nav>

    <!-- LOGOUT BUTTON (bottom aligned) -->
    <div class="mt-auto">
        <a href="<?= base_url('auth/logout') ?>" class="btn logout-btn w-100 mt-3 d-flex align-items-center justify-content-center">
            <span class="material-symbols-outlined me-1">logout</span>
            Logout
        </a>
    </div>

</div>
