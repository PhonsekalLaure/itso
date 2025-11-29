<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>RETURN MANAGEMENT</h2>

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

    <!-- NEW RETURN panel with form -->
    <div class="quick-box mb-4">
        <div class="section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> PROCESS RETURN
        </div>

        <form action="<?= base_url('returns/insert'); ?>" method="post" id="addReturnForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="borrow_id" class="form-label fw-bold">
                        <i class="bi bi-file-text"></i> Select Borrow Record
                    </label>
                    <select class="form-control" id="borrow_id" name="borrow_id" required>
                        <option value="" disabled selected>Select borrow to return</option>
                        <?php foreach ($active_borrows as $borrow): ?>
                            <option value="<?= $borrow['borrow_id'] ?>" data-borrower="<?= $borrow['borrower_name'] ?>"
                                data-equipment="<?= $borrow['equipment_name'] ?>" data-quantity="<?= $borrow['quantity'] ?>"
                                data-borrow-date="<?= $borrow['borrow_date'] ?>">
                                <?= $borrow['borrower_name'] ?> - <?= $borrow['equipment_name'] ?> (Qty:
                                <?= $borrow['quantity'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="return_date" class="form-label fw-bold">
                        <i class="bi bi-calendar-check"></i> Return Date
                    </label>
                    <input type="datetime-local" class="form-control" id="return_date" name="return_date" required>
                </div>

                <!-- Display borrow details -->
                <div class="col-12" id="borrowDetails" style="display: none;">
                    <div class="alert alert-info">
                        <h6 class="mb-2"><strong>Borrow Details:</strong></h6>
                        <p class="mb-1"><strong>Borrower:</strong> <span id="detailBorrower"></span></p>
                        <p class="mb-1"><strong>Equipment:</strong> <span id="detailEquipment"></span></p>
                        <p class="mb-1"><strong>Quantity:</strong> <span id="detailQuantity"></span></p>
                        <p class="mb-0"><strong>Borrowed On:</strong> <span id="detailBorrowDate"></span></p>
                    </div>
                </div>

                <div class="col-12 text-end">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </button>
                    <button type="submit" class="btn ms-2" style="background:#f4b029; color:#fff; font-weight:600;">
                        <i class="bi bi-check-circle"></i> Process Return
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- RETURN LOGS panel -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center justify-content-between gap-2">
            <div>
                <i class="bi bi-journal-check"></i> RETURN LOGS
            </div>
            <div>
                <a href="#" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                    data-bs-target="#clearAllModal">
                    Clear All
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4">Borrower</th>
                        <th>Equipment</th>
                        <th>Quantity</th>
                        <th>Return Date</th>
                        <th class="text-start pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($returns as $return): ?>
                        <tr>
                            <td class="ps-4"><?= $return['borrower_name'] ?? 'N/A' ?></td>
                            <td><?= $return['equipment_name'] ?? 'N/A' ?></td>
                            <td><?= $return['quantity'] ?? '0' ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($return['return_date'])) ?></td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('returns/view/' . $return['return_id']); ?>"
                                    class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
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

<!-- Process Return Confirmation Modal -->
<div class="modal fade" id="confirmReturnModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Confirm Return</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to process this return?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmReturnBtn">Yes, Process Return</button>
            </div>
        </div>
    </div>
</div>

<!-- Clear All Confirmation Modal -->
<div class="modal fade" id="clearAllModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Confirm Clear All</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to clear <b>all returned records</b>?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= base_url('returns/clearAll'); ?>" class="btn btn-warning">Clear All</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set default return date
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('return_date').value = now.toISOString().slice(0, 16);

        // Borrow details logic
        document.getElementById('borrow_id').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            if (!selectedOption.value) return;

            document.getElementById('detailBorrower').textContent = selectedOption.getAttribute('data-borrower');
            document.getElementById('detailEquipment').textContent = selectedOption.getAttribute('data-equipment');
            document.getElementById('detailQuantity').textContent = selectedOption.getAttribute('data-quantity');
            document.getElementById('detailBorrowDate').textContent = new Date(selectedOption.getAttribute('data-borrow-date')).toLocaleString('en-US', {
                year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });

            document.getElementById('borrowDetails').style.display = 'block';
        });

        <?php if (!empty($prefill_borrow_id)): ?>
                (function () {
                    var pre = '<?= esc($prefill_borrow_id) ?>';
                    var sel = document.getElementById('borrow_id');
                    if (sel) {
                        // Wait a tick to ensure options are populated
                        setTimeout(function () {
                            sel.value = pre;
                            sel.dispatchEvent(new Event('change'));
                            // Scroll to the form so the user sees it
                            var formTop = document.getElementById('borrowDetails');
                            if (formTop) formTop.scrollIntoView({ behavior: 'smooth' });
                        }, 50);
                    }
                })();
        <?php endif; ?>

        // Reset form handler
        document.querySelector('button[type="reset"]').addEventListener('click', function () {
            document.getElementById('borrowDetails').style.display = 'none';
        });

        // Process Return confirmation modal
        var form = document.getElementById('addReturnForm');
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmReturnModal'));
        var confirmBtn = document.getElementById('confirmReturnBtn');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var returnDate = new Date(document.getElementById('return_date').value);
            var now = new Date();
            if (returnDate > now) {
                alert('Return date cannot be in the future!');
                return false;
            }

            confirmModal.show();
        });

        confirmBtn.addEventListener('click', function () {
            confirmModal.hide();
            form.submit(); // submit after confirmation
        });
    });
</script>

<style>
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
        box-shadow: 0 0 5px rgba(11, 130, 74, 0.3);
    }
</style>