<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>REPORTS MANAGEMENT</h2>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-person-circle" style="font-size: 40px; color:#0b824a;"></i>
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

    <!-- Equipment Reports Section -->
    <div class="quick-box mb-4">
        <div class="section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-bar-graph"></i> EQUIPMENT REPORTS
        </div>

        <div class="row g-3">
            <!-- Active Equipment List Report -->
            <div class="col-md-6">
                <div class="report-card">
                    <div class="report-icon">
                        <i class="bi bi-check-circle-fill" style="font-size: 48px; color: #0b824a;"></i>
                    </div>
                    <h5 class="report-title">Active Equipment List</h5>
                    <p class="report-description">
                        Generate a list of all active equipment in the system.
                    </p>
                    <form action="<?= base_url('reports/active-equipment'); ?>" method="post" class="mb-2">
                        <div class="mb-3">
                            <label for="format_active" class="form-label fw-bold">
                                <i class="bi bi-file-earmark"></i> Export Format
                            </label>
                            <select class="form-control" id="format_active" name="format" disabled required>
                                <option value="pdf" selected>PDF Document</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-download"></i> Generate Report
                        </button>
                    </form>
                </div>
            </div>

            <!-- Unusable Equipment Report -->
            <div class="col-md-6">
                <div class="report-card">
                    <div class="report-icon">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 48px; color: #dc3545;"></i>
                    </div>
                    <h5 class="report-title">Unusable Equipment Report</h5>
                    <p class="report-description">
                        Generate a report of equipment that is unavailable for borrowing. 
                    </p>
                    <form action="<?= base_url('reports/unusable-equipment'); ?>" method="post" class="mb-2">
                        <div class="mb-3">
                            <label for="format_unusable" class="form-label fw-bold">
                                <i class="bi bi-file-earmark"></i> Export Format
                            </label>
                            <select class="form-control" id="format_unusable" name="format" disabled required>
                                <option value="pdf" selected>PDF Document</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-download"></i> Generate Report
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Borrowing History Report -->
    <div class="quick-box">
        <div class="section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-person-lines-fill"></i> USER BORROWING HISTORY
        </div>

        <div class="report-card">
            <div class="report-icon">
                <i class="bi bi-clock-history" style="font-size: 48px; color: #0d6efd;"></i>
            </div>
            <h5 class="report-title">User Borrowing History Report</h5>
            <p class="report-description">
                Generate borrowing history for a specific user or all users.
            </p>

            <form action="<?= base_url('reports/borrowing-history'); ?>" method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="user_id" class="form-label fw-bold">
                            <i class="bi bi-person-badge"></i> Select User (Optional)
                        </label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">All Users</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['user_id'] ?>">
                                    <?= $user['firstname'] . ' ' . $user['lastname'] ?> (<?= $user['email'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="date_from" class="form-label fw-bold">
                            <i class="bi bi-calendar-range"></i> From Date (Optional)
                        </label>
                        <input type="date" class="form-control" id="date_from" name="date_from">
                    </div>

                    <div class="col-md-3">
                        <label for="date_to" class="form-label fw-bold">
                            <i class="bi bi-calendar-range"></i> To Date (Optional)
                        </label>
                        <input type="date" class="form-control" id="date_to" name="date_to">
                    </div>

                    <div class="col-md-6">
                        <label for="format_history" class="form-label fw-bold">
                            <i class="bi bi-file-earmark"></i> Export Format
                        </label>
                        <select class="form-control" id="format_history" name="format" disabled required>
                            <option value="pdf" selected>PDF Document</option>
                        </select>
                    </div>

                    <div class="col-12 text-end">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Clear Filters
                        </button>
                        <button type="submit" class="btn ms-2" style="background:#0d6efd; color:#fff; font-weight:600;">
                            <i class="bi bi-download"></i> Generate Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Date validation for borrowing history
        var dateFrom = document.getElementById('date_from');
        var dateTo = document.getElementById('date_to');

        if (dateTo) {
            dateTo.addEventListener('change', function () {
                if (dateFrom.value && dateTo.value) {
                    if (new Date(dateTo.value) < new Date(dateFrom.value)) {
                        alert('End date must be after start date!');
                        dateTo.value = '';
                    }
                }
            });
        }

        // Show loading indicator on form submit
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function () {
                var btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating...';
                }
            });
        });
    });
</script>

<style>
    /* Report Card Styling */
    .report-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        border: 2px solid #dcdcdc;
        transition: 0.2s ease;
        height: 100%;
    }

    .report-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .report-icon {
        text-align: center;
        margin-bottom: 20px;
    }

    .report-title {
        color: #0b824a;
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 15px;
        text-align: center;
    }

    .report-description {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Stats Card */
    .stats-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        border: 2px solid #dcdcdc;
        transition: 0.2s ease;
        text-align: center;
        min-height: 150px;
    }

    .stats-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .stats-title {
        font-size: 18px;
        font-weight: 600;
        color: #0b824a;
    }

    .stats-number {
        font-size: 40px;
        font-weight: 800;
        margin-top: 5px;
        color: #333;
    }

    .sub-label {
        font-size: 13px;
        margin-top: -5px;
    }

    /* Section Title */
    .section-title {
        font-weight: 700;
        font-size: 20px;
        color: #0b824a;
        margin-bottom: 15px;
    }

    /* Quick Stats */
    .stat-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #e3e3e3;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        font-weight: 500;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #0b824a;
    }

    /* Quick Box */
    .quick-box {
        background: white;
        padding: 25px;
        border-radius: 15px;
        border: 2px solid #dcdcdc;
    }

    /* Form styling */
    .quick-box form .form-label,
    .report-card form .form-label {
        color: #0b824a;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .quick-box form .form-control,
    .quick-box form select,
    .report-card form .form-control,
    .report-card form select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 8px 12px;
    }

    .quick-box form .form-control:focus,
    .quick-box form select:focus,
    .report-card form .form-control:focus,
    .report-card form select:focus {
        border-color: #0b824a;
        box-shadow: 0 0 0 0.2rem rgba(11, 130, 74, 0.15);
    }

    /* Dashboard Header */
    .dashboard-header {
        background: white;
        padding: 20px 30px;
        border-radius: 15px;
        border: 2px solid #0b824a;
        margin-bottom: 25px;
    }

    .dashboard-header h2 {
        font-size: 30px;
        font-weight: 700;
        color: #0b824a;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .report-card {
            margin-bottom: 20px;
        }
    }
</style>