<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>ASSOCIATES &amp; STUDENTS</h2>

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
    <?php if (isset($admin) && strtolower($admin['role']) === 'sadmin'): ?>
        <!-- NEW USER panel with form -->
        <div class="quick-box mb-4">
            <div class="section-title mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i> NEW USER
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

            <form action="<?= base_url('users/insert'); ?>" method="post" id="addUserForm">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label fw-bold">
                            <i class="bi bi-person"></i> First Name
                        </label>
                        <input type="text" class="form-control" id="firstname" name="firstname"
                            placeholder="Enter First Name" value="<?= set_value('firstname') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="lastname" class="form-label fw-bold">
                            <i class="bi bi-person"></i> Last Name
                        </label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name"
                            value="<?= set_value('lastname') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                            value="<?= set_value('email') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="acctype" class="form-label fw-bold">
                            <i class="bi bi-lock-fill"></i> Account Type
                        </label>
                        <select class="form-control" id="acctype" name="acctype" required>
                            <option value="" disabled selected>Select account type</option>
                            <option value="student">Associate</option>
                            <option value="associate">Student</option>
                        </select>
                    </div>

                    <div class="col-12 text-end">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Clear
                        </button>
                        <button type="button" id="openConfirmAddModalBtn" class="btn ms-2"
                            style="background:#f4b029; color:#fff; font-weight:600;">
                            <i class="bi bi-person-plus"></i> Add User
                        </button>

                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- USER LIST panel -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2"><i class="bi bi-people-fill"></i> USER LIST</div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4">Role</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th class="text-start pe-3" style="width: 170px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="ps-4"><?= $user['role'] ?></td>
                            <td><?= $user['firstname'] ?></td>
                            <td><?= $user['lastname'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('users/view/' . $user['user_id']); ?>"
                                    class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <?php if (isset($admin) && strtolower($admin['role']) === 'sadmin'): ?>
                                    <a href="<?= base_url('users/edit/' . $user['user_id']); ?>"
                                        class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>

                                    <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete"
                                        data-id="<?= $user['user_id']; ?>"
                                        data-name="<?= htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']); ?>">
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
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmAddModal" tabindex="-1" aria-labelledby="confirmAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmAddModalLabel">Confirm Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to create this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmAddBtn" class="btn btn-warning">Yes, Add User</button>
            </div>
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
        // Delete modal functionality
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

        // Add User confirmation flow with validation
        var addUserForm = document.getElementById('addUserForm');
        var confirmAddModalEl = document.getElementById('confirmAddModal');
        var confirmAddModal = new bootstrap.Modal(confirmAddModalEl);
        var openConfirmBtn = document.getElementById('openConfirmAddModalBtn');
        var confirmAddBtn = document.getElementById('confirmAddBtn');

        // Intercept Add User button: validate before showing modal
        if (openConfirmBtn) {
            openConfirmBtn.addEventListener('click', function () {
                if (!addUserForm.checkValidity()) {
                    addUserForm.reportValidity();
                    return;
                }
                confirmAddModal.show();
            });
        }

        // On confirm, submit the form
        if (confirmAddBtn) {
            confirmAddBtn.addEventListener('click', function () {
                addUserForm.submit();
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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