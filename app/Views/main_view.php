<div class="main-content">

    <!-- Top Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>ADMIN DASHBOARD</h2>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-person-circle" style="font-size: 40px; color:white;"></i>
            <div>
                <b><?= $admin['firstname'] . " " . $admin['lastname']; ?></b><br>
                <small>
                    <?php
                    if (strtolower($admin['role']) == 'admin') {
                        echo "Administrator";
                    } elseif (strtolower($admin['role']) == 'sadmin') {
                        echo "Super Administrator";
                    }
                    ?>
                </small><br>
                <small>Current time: <?= date("M d, Y h:i A", strtotime("+8 hours")); ?></small>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-4">

        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-title">Total Equipment</div>
                <div class="stats-number"><?= $total_equipment ?? 0 ?></div>
                <div class="sub-label">Registered equipment</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-title">Borrowed Today</div>
                <div class="stats-number"><?= $borrowed_today ?? 0 ?></div>
                <div class="sub-label">Today's activity</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-title">Currently Borrowed</div>
                <div class="stats-number"><?= $currently_borrowed ?? 0 ?></div>
                <div class="sub-label">Items not yet returned</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-title">Available Equipment</div>
                <div class="stats-number"><?= $available_equipment ?? 0 ?></div>
                <div class="sub-label">Units available</div>
            </div>
        </div>

    </div>

    <br>

    <!-- Recent Activities and Quick Actions -->
    <div class="row g-4">

        <!-- Recent Activities -->
        <div class="col-md-8">
            <div class="activities-box">
                <div class="section-title">
                    <i class="bi bi-clock-history"></i> Recent Activities
                </div>

                <div>
                    <?php if (!empty($recent_logs)): ?>
                        <ul>
                            <?php foreach ($recent_logs as $log): ?>
                                <li><?= esc($log); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No recent activities</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="quick-box">
                <div class="section-title">
                    <i class="bi bi-lightning-fill"></i> Quick Actions
                </div>
                <?php if (isset($admin) && strtolower($admin['role']) === 'sadmin'): ?>
                    <button class="quick-btn" onclick="window.location.href='<?= site_url('equipment/add') ?>'">
                        <i class="bi bi-plus-circle"></i> Add Equipment
                    </button>
                <?php endif; ?>

                <button class="quick-btn" onclick="window.location.href='<?= site_url('borrows') ?>'">
                    <i class="bi bi-cart-fill"></i> Process Borrowing
                </button>

                <button class="quick-btn" onclick="window.location.href='<?= site_url('returns') ?>'">
                    <i class="bi bi-arrow-return-left"></i> Process Returning
                </button>

                <button class="quick-btn" onclick="window.location.href='<?= site_url('reports') ?>'">
                    <i class="bi bi-bar-chart-fill"></i> View Reports
                </button>
            </div>
        </div>

    </div>

</div>