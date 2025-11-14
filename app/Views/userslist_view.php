<header class="text-center py-4">
    <h1 class="mb-0">Users</h1>
</header>
<main>
    <div class="container">
        <div class="d-flex justify-content-end mb-3">
            <a href="<?= base_url('users/add'); ?>" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
                <span class="material-symbols-outlined">
                    add
                </span>
                Add User
            </a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Role</th>
                            <th class="ps-3">Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th class="text-start pe-3" style="width: 170px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="ps-4"><?= ucfirst($user['role']) ?></td>
                                <td class="ps-3"><?= $user['username'] ?></td>
                                <td><?= $user['fullname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td class="text-end pe-3">
                                    <a href="<?= base_url('users/view/'.$user['id']); ?>" class="btn btn-outline-success btn-sm me-1"
                                        title="View">
                                        <span class="material-symbols-outlined">
                                            visibility
                                        </span>
                                    </a>
                                    <a href="<?= base_url('users/edit/'.$user['id']); ?>" class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete" data-id="<?= $user['id'];?>" data-name="<?= htmlspecialchars($user['username']) ;?>" >
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
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

    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
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