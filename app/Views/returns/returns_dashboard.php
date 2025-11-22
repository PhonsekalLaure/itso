<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>RETURN MANAGEMENT</h2>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-person-circle" style="font-size: 40px; color:#0b824a;"></i>
            <div>
                <?php $sessUser = session()->get('user'); ?>
                <b><?= $user['firstname'] . " " . $user['lastname']; ?></b><br>
                <small>
                    <?php
                    if (strtolower($user['role']) == 'admin') {
                        echo "Administrator";
                    } elseif (strtolower($user['role']) == 'sadmin') {
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
                            <option value="<?= $borrow['borrow_id'] ?>" 
                                    data-borrower="<?= $borrow['borrower_name'] ?>"
                                    data-equipment="<?= $borrow['equipment_name'] ?>"
                                    data-quantity="<?= $borrow['quantity'] ?>"
                                    data-borrow-date="<?= $borrow['borrow_date'] ?>">
                                <?= $borrow['borrower_name'] ?> - <?= $borrow['equipment_name'] ?> (Qty: <?= $borrow['quantity'] ?>)
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
                
                <div class="col-md-6">
                    <label for="condition_status" class="form-label fw-bold">
                        <i class="bi bi-clipboard-check"></i> Condition Status
                    </label>
                    <select class="form-control" id="condition_status" name="condition_status" required>
                        <option value="" disabled selected>Select condition</option>
                        <option value="good">Good - No damage</option>
                        <option value="damaged">Damaged - Minor issues</option>
                        <option value="broken">Broken - Major issues</option>
                        <option value="lost">Lost - Equipment missing</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="penalty_amount" class="form-label fw-bold">
                        <i class="bi bi-cash"></i> Penalty Amount (₱)
                    </label>
                    <input type="number" class="form-control" id="penalty_amount" name="penalty_amount" 
                           placeholder="Enter penalty (if any)" min="0" step="0.01" value="0">
                </div>
                
                <div class="col-12">
                    <label for="remarks" class="form-label fw-bold">
                        <i class="bi bi-card-text"></i> Remarks
                    </label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="2" 
                              placeholder="Enter any remarks about the return"></textarea>
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
                    <button type="submit" class="btn ms-2" 
                            style="background:#f4b029; color:#fff; font-weight:600;">
                        <i class="bi bi-check-circle"></i> Process Return
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- RETURN LOGS panel -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2"><i class="bi bi-journal-check"></i> RETURN LOGS</div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4">Borrower</th>
                        <th>Equipment</th>
                        <th>Quantity</th>
                        <th>Return Date</th>
                        <th>Condition</th>
                        <th>Penalty</th>
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
                            <td>
                                <?php 
                                $condition = strtolower($return['condition_status'] ?? 'good');
                                $badgeClass = '';
                                if ($condition == 'good') {
                                    $badgeClass = 'bg-success';
                                } elseif ($condition == 'damaged') {
                                    $badgeClass = 'bg-warning text-dark';
                                } elseif ($condition == 'broken') {
                                    $badgeClass = 'bg-danger';
                                } elseif ($condition == 'lost') {
                                    $badgeClass = 'bg-dark';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($condition) ?></span>
                            </td>
                            <td>
                                <?php if ($return['penalty_amount'] > 0): ?>
                                    <span class="text-danger fw-bold">₱<?= number_format($return['penalty_amount'], 2) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">₱0.00</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('returns/view/' . $return['return_id']); ?>" 
                                   class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete" 
                                   data-id="<?= $return['return_id']; ?>"
                                   data-name="<?= htmlspecialchars($return['borrower_name'] ?? 'return record'); ?>">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete return record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this return record for <strong id="modalReturnName"></strong>?
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
        // Set default return date to current date/time
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('return_date').value = now.toISOString().slice(0, 16);

        // Show borrow details when borrow record is selected
        document.getElementById('borrow_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var borrower = selectedOption.getAttribute('data-borrower');
            var equipment = selectedOption.getAttribute('data-equipment');
            var quantity = selectedOption.getAttribute('data-quantity');
            var borrowDate = selectedOption.getAttribute('data-borrow-date');

            document.getElementById('detailBorrower').textContent = borrower;
            document.getElementById('detailEquipment').textContent = equipment;
            document.getElementById('detailQuantity').textContent = quantity;
            document.getElementById('detailBorrowDate').textContent = new Date(borrowDate).toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            document.getElementById('borrowDetails').style.display = 'block';
        });

        // Auto-suggest penalty based on condition
        document.getElementById('condition_status').addEventListener('change', function() {
            var condition = this.value;
            var penaltyField = document.getElementById('penalty_amount');
            
            if (condition === 'damaged') {
                penaltyField.value = '100.00';
            } else if (condition === 'broken') {
                penaltyField.value = '500.00';
            } else if (condition === 'lost') {
                penaltyField.value = '1000.00';
            } else {
                penaltyField.value = '0.00';
            }
        });

        // Delete modal functionality
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        var modalReturnName = document.getElementById('modalReturnName');

        document.querySelectorAll('.btn-delete').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var returnId = this.getAttribute('data-id');
                var returnName = this.getAttribute('data-name');
                modalReturnName.textContent = returnName;
                confirmDeleteBtn.href = "<?= base_url('returns/delete/') ?>" + returnId;
                deleteModal.show();
            });
        });

        // Form validation
        var form = document.getElementById('addReturnForm');
        form.addEventListener('submit', function(e) {
            var returnDate = new Date(document.getElementById('return_date').value);
            var now = new Date();

            if (returnDate > now) {
                e.preventDefault();
                alert('Return date cannot be in the future!');
                return false;
            }
        });

        // Reset form handler
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            document.getElementById('borrowDetails').style.display = 'none';
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
        box-shadow: 0 0