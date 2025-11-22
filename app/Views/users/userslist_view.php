<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>ASSOCIATES &amp; STUDENTS</h2>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-person-circle" style="font-size: 40px; color:#0b824a;"></i>
            <div>
                <?php $sessUser = session()->get('user'); ?>
                <b><?= isset($sessUser['firstname']) && isset($sessUser['lastname']) ? ($sessUser['firstname'] . ' ' . $sessUser['lastname']) : 'User'; ?></b><br>
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

    <!-- NEW USER panel (CTA to Add User) -->
    <div class="quick-box mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="section-title mb-0 d-flex align-items-center gap-2"><i class="bi bi-plus-circle"></i> NEW USER
            </div>
            <a href="<?= base_url('users/add'); ?>" class="btn"
                style="background:#f4b029; color:#fff; font-weight:600; border-radius:10px; padding:10px 16px;">ADD
                USER</a>
        </div>
    </div>

    <!-- USER LIST panel -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2"><i class="bi bi-people-fill"></i> USER LIST</div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4">Role</th>
                        <th class="ps-3">Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th class="text-start pe-3" style="width: 170px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="ps-4">
                                <?php
                                if (strtolower($user['role']) == 'admin') {
                                    echo "Administrator";
                                } elseif (strtolower($user['role']) == 'sadmin') {
                                    echo "Super Administrator";
                                }
                                ?>
                            </td>
                            <td class="ps-3"><?= $user['username'] ?></td>
                            <td><?= $user['firstname'] ?></td>
                            <td><?= $user['lastname'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('users/view/' . $user['user_id']); ?>"
                                    class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <a href="<?= base_url('users/edit/' . $user['user_id']); ?>"
                                    class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete"
                                    data-id="<?= $user['user_id']; ?>"
                                    data-name="<?= htmlspecialchars($user['username']); ?>">
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
                <h5 class="modal-title" id="deleteModalLabel">Delete user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="modaluserName"></strong>?
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
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        var modaluserName = document.getElementById('modaluserName');

        document.querySelectorAll('.btn-delete').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var userId = this.getAttribute('data-id');
                var userName = this.getAttribute('data-name');
                modaluserName.textContent = userName;
                confirmDeleteBtn.href = "<?= base_url('users/delete/') ?>" + userId;
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
</style>