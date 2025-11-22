<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>ASSOCIATES &amp; STUDENTS</h2>

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

    <!-- NEW USER panel with form -->
    <div class="quick-box mb-4">
        <div class="section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> NEW USER
        </div>
        
        <form action="<?= base_url('users/insert'); ?>" method="post" id="addUserForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="firstname" class="form-label fw-bold">
                        <i class="bi bi-person"></i> First Name
                    </label>
                    <input type="text" class="form-control" id="firstname" name="firstname" 
                           placeholder="Enter First Name" required>
                </div>

                <div class="col-md-6">
                    <label for="lastname" class="form-label fw-bold">
                        <i class="bi bi-person"></i> Last Name
                    </label>
                    <input type="text" class="form-control" id="lastname" name="lastname" 
                           placeholder="Enter Last Name" required>
                </div>
                
                <div class="col-md-6">
                    <label for="email" class="form-label fw-bold">
                        <i class="bi bi-envelope"></i> Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Enter email" required>
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
                    <button type="submit" class="btn ms-2" 
                            style="background:#f4b029; color:#fff; font-weight:600;">
                        <i class="bi bi-person-plus"></i> Add User
                    </button>
                </div>
            </div>
        </form>
    </div>

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
                                <a href="<?= base_url('users/edit/' . $user['user_id']); ?>"
                                    class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete"
                                    data-id="<?= $user['user_id']; ?>"
                                    data-name="<?= htmlspecialchars($user['firstname']); ?>">
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

        // Password confirmation validation
        var form = document.getElementById('addUserForm');
        form.addEventListener('submit', function(e) {
            var password = document.getElementById('password').value;
            var confPassword = document.getElementById('confpassword').value;
            
            if (password !== confPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
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