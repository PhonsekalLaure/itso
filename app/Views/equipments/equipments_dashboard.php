<div class="main-content">

    <!-- Top Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>EQUIPMENTS</h2>
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-person-circle" style="font-size: 40px; color:#0b824a;"></i>
            <div>
                <b><?= $admin['firstname'] . " " . $admin['lastname']; ?></b><br>
                <small>
                    <?php
                    if (strtolower($admin['role']) == 'admin')
                        echo "Administrator";
                    elseif (strtolower($admin['role']) == 'sadmin')
                        echo "Super Administrator";
                    ?>
                </small><br>
                <small>Current time: <?= date("M d, Y h:i A", strtotime("+8 hours")); ?></small>
            </div>
        </div>
    </div>
    <?php if (isset($admin) && strtolower($admin['role']) === 'sadmin'): ?>
        <!-- NEW EQUIPMENT Form -->
        <div class="quick-box mb-4">
            <div class="section-title mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i> NEW EQUIPMENT
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

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('equipments/insert'); ?>" method="post" id="addEquipmentForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold"><i class="bi bi-box-seam"></i> Equipment Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter equipment name"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label fw-bold"><i class="bi bi-card-text"></i>
                            Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Enter description" required>
                    </div>
                    <div class="col-md-6">
                        <label for="accessories" class="form-label fw-bold"><i class="bi bi-card-text"></i> Accessories
                        </label>
                        <input type="text" class="form-control" id="accessories" name="accessories"
                            placeholder="Enter accessories" required>

                    </div>
                    <div class="col-md-6">
                        <label for="total_count" class="form-label fw-bold"><i class="bi bi-calculator"></i> Total
                            Count</label>
                        <input type="number" class="form-control" id="total_count" name="total_count"
                            placeholder="Enter total count" min="0" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Clear</button>
                        <button type="submit" class="btn ms-2" style="background:#f4b029; color:#fff; font-weight:600;">
                            <i class="bi bi-plus-lg"></i> Add Equipment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- EQUIPMENT LIST -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2"><i class="bi bi-hdd-stack"></i> EQUIPMENT LIST</div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Accessories</th>
                        <th>Total</th>
                        <th>Available</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipments as $eq): ?>
                        <tr>
                            <td><?= $eq['name'] ?? '' ?></td>
                            <td><?= $eq['description'] ?? '' ?></td>
                            <td><?= $eq['accessories'] ?? ''; ?></td>
                            <td><?= $eq['total_count'] ?? '' ?></td>
                            <td><?= $eq['available_count'] ?? '' ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('equipments/view/' . $eq['equipment_id']); ?>"
                                    class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <?php if (isset($admin) && strtolower($admin['role']) === 'sadmin'): ?>
                                <a href="<?= base_url('equipments/edit/' . $eq['equipment_id']); ?>"
                                    class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete"
                                    data-id="<?= $eq['equipment_id']; ?>"
                                    data-name="<?= htmlspecialchars($eq['name'] ?? 'equipment'); ?>">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                                <?php endif; ?>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="modalEquipmentName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Add Confirmation Modal -->
<div class="modal fade" id="confirmAddModal" tabindex="-1" aria-labelledby="confirmAddModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmAddModalLabel">Confirm Add Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to add this equipment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmAddBtn">Yes, Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Delete modal ---
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        var modalEquipmentName = document.getElementById('modalEquipmentName');

        document.querySelectorAll('.btn-delete').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var eqId = this.getAttribute('data-id');
                var eqName = this.getAttribute('data-name');
                modalEquipmentName.textContent = eqName;
                confirmDeleteBtn.href = "<?= base_url('equipments/delete/') ?>" + eqId;
                deleteModal.show();
            });
        });

        // --- Add Equipment confirmation modal ---
        var form = document.getElementById('addEquipmentForm');
        var confirmAddModal = new bootstrap.Modal(document.getElementById('confirmAddModal'));
        var confirmAddBtn = document.getElementById('confirmAddBtn');

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // stop default submit

            // Validation: available_count vs total_count
            var totalCount = parseInt(document.getElementById('total_count').value);
            var availableCountInput = document.getElementById('available_count');
            var availableCount = availableCountInput ? parseInt(availableCountInput.value) : totalCount;

            if (availableCount > totalCount) {
                alert('Available count cannot be greater than total count!');
                return false;
            }

            // Show confirmation modal
            confirmAddModal.show();
        });

        // Submit after confirmation
        confirmAddBtn.addEventListener('click', function () {
            form.submit();
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

    .quick-box form .form-control {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 8px 12px;
    }

    .quick-box form .form-control:focus {
        border-color: #0b824a;
        box-shadow: 0 0 0 0.2rem rgba(11, 130, 74, 0.15);
    }
</style>