<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>BORROW MANAGEMENT</h2>

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

    <!-- NEW BORROW panel with form -->
    <div class="quick-box mb-4">
        <div class="section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> NEW BORROW
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> <?= esc(session()->getFlashdata('info')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('borrows/insert'); ?>" method="post" id="addBorrowForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="user_id" class="form-label fw-bold">
                        <i class="bi bi-person-badge"></i> Borrower
                    </label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="" disabled selected>Select borrower</option>
                        <?php foreach ($users as $borrower): ?>
                            <option value="<?= $borrower['user_id'] ?>">
                                <?= $borrower['firstname'] . ' ' . $borrower['lastname'] ?> (<?= $borrower['email'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="equipment_id" class="form-label fw-bold">
                        <i class="bi bi-box-seam"></i> Equipment
                    </label>
                    <select class="form-control" id="equipment_id" name="equipment_id" required>
                        <option value="" disabled selected>Select equipment</option>
                        <?php foreach ($equipments as $eq): ?>
                            <option value="<?= $eq['equipment_id'] ?>" data-available="<?= $eq['available_count'] ?>">
                                <?= $eq['name'] ?> (Available: <?= $eq['available_count'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="quantity" class="form-label fw-bold">
                        <i class="bi bi-calculator"></i> Quantity
                    </label>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity"
                        min="1" required>
                </div>

                <div class="col-md-4">
                    <label for="borrow_date" class="form-label fw-bold">
                        <i class="bi bi-calendar-check"></i> Borrow Date
                    </label>
                    <input type="datetime-local" class="form-control" id="borrow_date" name="borrow_date" required>
                </div>

                <div class="col-12 text-end">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </button>
                    <button type="submit" class="btn ms-2" style="background:#f4b029; color:#fff; font-weight:600;">
                        <i class="bi bi-plus-lg"></i> Add Borrow
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- BORROW LOGS panel -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2"><i class="bi bi-journal-text"></i> BORROW LOGS</div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4">Borrower</th>
                        <th>Equipment</th>
                        <th>Quantity</th>
                        <th>Borrow Date</th>
                        <th>Status</th>
                        <th class="text-start pe-3" style="width: 190px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrows as $borrow): ?>
                        <tr>
                            <td class="ps-4"><?= $borrow['borrower_name'] ?? 'N/A' ?></td>
                            <td><?= $borrow['equipment_name'] ?? 'N/A' ?></td>
                            <td><?= $borrow['quantity'] ?? '0' ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($borrow['borrow_date'])) ?></td>
                            <td>
                                <?php
                                $status = strtolower($borrow['status'] ?? 'pending');
                                $badgeClass = '';
                                if ($status == 'borrowed') {
                                    $badgeClass = 'bg-warning text-dark';
                                } elseif ($status == 'returned') {
                                    $badgeClass = 'bg-success';
                                } else {
                                    $badgeClass = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('borrows/view/' . $borrow['borrow_id']); ?>"
                                    class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <?php if ($status != 'returned'): ?>
                                    <a href="<?= base_url('borrows/return/' . $borrow['borrow_id']); ?>" class="btn btn-outline-primary btn-sm me-1 btn-return" title="Mark as Returned"
                                        data-id="<?= $borrow['borrow_id']; ?>"
                                        data-name="<?= htmlspecialchars($borrow['borrower_name'] ?? 'borrower'); ?>">
                                        <span class="material-symbols-outlined">assignment_return</span>
                                    </a>
                                <?php endif; ?>
                                <?php if (isset($admin) && strtolower($admin['role']) === 'sadmin'): ?>
                                    <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete"
                                        data-id="<?= $borrow['borrow_id']; ?>"
                                        data-name="<?= htmlspecialchars($borrow['borrower_name'] ?? 'borrow record'); ?>">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($pages) && $pages): ?>
            <div class="d-flex justify-content-end mt-3">
                <?= $pages->links() ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete borrow record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this borrow record for <strong id="modalBorrowName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set default borrow date to current date/time
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('borrow_date').value = now.toISOString().slice(0, 16);

        // Return modal functionality

        // Delete modal functionality
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        var modalBorrowName = document.getElementById('modalBorrowName');

        document.querySelectorAll('.btn-delete').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var borrowId = this.getAttribute('data-id');
                var borrowName = this.getAttribute('data-name');
                modalBorrowName.textContent = borrowName;
                confirmDeleteBtn.href = "<?= base_url('borrows/delete/') ?>" + borrowId;
                deleteModal.show();
            });
        });

        // Form validation
        var form = document.getElementById('addBorrowForm');
        form.addEventListener('submit', function (e) {
            var equipmentSelect = document.getElementById('equipment_id');
            var selectedOption = equipmentSelect.options[equipmentSelect.selectedIndex];
            var availableCount = parseInt(selectedOption.getAttribute('data-available'));
            var quantity = parseInt(document.getElementById('quantity').value);

            if (quantity > availableCount) {
                e.preventDefault();
                alert('Quantity cannot exceed available count (' + availableCount + ')!');
                return false;
            }
        });

        // Update quantity max based on selected equipment
        document.getElementById('equipment_id').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var availableCount = parseInt(selectedOption.getAttribute('data-available'));
            document.getElementById('quantity').setAttribute('max', availableCount);
        });
    });
</script>

<style>
    /* Minor table theming to align with dashboard palette */
    .users-table thead th {
        background: #eaf6ef;
        color: #0b824a;
        border-bottom: 2px solid #0b824a;
    }

    .users-table tbody tr td {
        border-top: 1px solid #e3e3e3;
    }

    .quick-box .section-title {
        color: #0b824a;
        font-weight: 700;
    }

    /* Form styling */
    .quick-box form .form-label {
        color: #0b824a;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .quick-box form .form-control,
    .quick-box form select,
    .quick-box form textarea {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 8px 12px;
    }

    .quick-box form .form-control:focus,
    .quick-box form select:focus,
    .quick-box form textarea:focus {
        border-color: #0b824a;
        box-shadow: 0 0 0 0.2rem rgba(11, 130, 74, 0.15);
    }

    /* Badge styling */
    .badge {
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 6px;
    }
</style>