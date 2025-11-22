<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>EQUIPMENTS</h2>

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

    <!-- NEW EQUIPMENT panel with form quick action -->
    <div class="quick-box mb-4">
        <div class="section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> NEW EQUIPMENT
        </div>

        <div class="d-flex justify-content-end">
            <a href="<?= base_url('equipments/add'); ?>" class="btn" style="background:#f4b029; color:#fff; font-weight:600;">
                <i class="bi bi-plus-lg"></i> Add Equipment
            </a>
        </div>
    </div>

    <!-- EQUIPMENT LIST panel -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2"><i class="bi bi-hdd-stack"></i> EQUIPMENT LIST</div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 150px;">Name</th>
                        <th class="ps-3">Description</th>
                        <th>Total</th>
                        <th>Available</th>
                        <th class="text-start pe-3" style="width: 190px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipments as $eq): ?>
                        <tr>
                            <td class="ps-3"><?= $eq['name'] ?? '' ?></td>
                            <td><?= $eq['description'] ?? '' ?></td>
                            <td><?= $eq['total_count'] ?? '' ?></td>
                            <td><?= $eq['available_count'] ?? '' ?></td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('equipments/view/' . $eq['id']); ?>" class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <a href="<?= base_url('equipments/edit/' . $eq['id']); ?>" class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete" data-id="<?= $eq['id']; ?>" data-name="<?= htmlspecialchars($eq['name'] ?? 'equipment'); ?>">
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
        <h5 class="modal-title" id="deleteModalLabel">Delete equipment</h5>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete modal functionality
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
</style>