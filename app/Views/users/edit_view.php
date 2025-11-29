<div class="main-content">

    <!-- Page Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>EDIT USER</h2>
        <div>
            <i class="bi bi-person-circle" style="font-size: 40px; color:white;"></i>
        </div>
    </div>

    <!-- User Details Section -->
    <div class="row gx-5 gy-4 mt-5">
        <div class="col-md-8">
            <div class="activities-box" id="user-edit-container">
                <div class="section-title">
                    <i class="bi bi-person-fill"></i> User Information
                </div>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url("users/update/" . $user['user_id']); ?>" method="post"
                    enctype="multipart/form-data">
                    <style>
                        .user-form-group {
                            margin-bottom: 1.75rem;
                            padding-bottom: 1.75rem;
                            border-bottom: 1px solid #e9ecef;
                        }
                        .user-form-group:last-of-type {
                            border-bottom: none;
                            padding-bottom: 0;
                            margin-bottom: 1.5rem;
                        }
                    </style>
                    <div class="user-form-group row">
                        <label for="firstname" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                account_circle
                            </span>
                            First Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                value="<?= $user['firstname']; ?>" required>
                        </div>
                    </div>
                    <div class="user-form-group row">
                        <label for="lastname" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                person
                            </span>
                            Last Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                value="<?= $user['lastname']; ?>" required>
                        </div>
                    </div>
                    <div class="user-form-group row">
                        <label for="email" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                mail
                            </span>
                            Email
                        </label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= $user['email']; ?>" required>
                        </div>
                    </div>
                    <div class="user-form-group row">
                        <label for="acctype" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                lock
                            </span>
                            Account Type
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="acctype" name="acctype" readonly
                                value="<?= ucfirst($user['role']); ?>">
                        </div>
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

        <!-- Quick Info Card -->
        <div class="col-md-4">
            <div class="quick-box">
                <div class="section-title">
                    <i class="bi bi-info-circle-fill"></i> User Summary
                </div>
                <div style="padding: 15px; background-color: #f8f9fa; border-radius: 8px; margin-bottom: 15px;">
                    <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                    <p><strong>Role:</strong> <?= ucfirst($user['role']); ?></p>
                    <p><strong>Email:</strong> <?= $user['email']; ?></p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    #user-edit-container {
        height: 100%;
    }
</style>