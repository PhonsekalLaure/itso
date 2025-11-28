<header class="text-center py-4">
    <h1 class="mb-0">Edit User</h1>
</header>
<main>
    <div class="col col-md-6 mx-auto">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form action="<?= base_url("users/update/" . $user['user_id']); ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="firstname" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                account_circle
                            </span>
                            First Namme
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                value="<?= $user['firstname']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="lastname" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                description
                            </span>
                            Last Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                value="<?= $user['lastname']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                mail
                            </span>
                            Email
                        </label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= $user['email']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="acctype" class="form-label fw-bold">
                            <i class="bi bi-lock-fill"></i> Account Type
                        </label>
                        <select class="form-control" id="acctype" name="acctype" disabled required>
                            <option value="" disabled selected><?= $user['role']; ?></option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= base_url("users") ?>" class="btn btn-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                            Back
                        </a>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                save
                            </span>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>