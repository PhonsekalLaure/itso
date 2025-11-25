<header class="text-center py-4">
    <h1 class="mb-0">View User</h1>
</header>
<main>
    <div class="col col-md-6 mx-auto">
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form>
                    <div class="mb-3 row">
                        <label for="role" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                assignment_ind
                            </span>
                            Role
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="role" name="role" readonly
                                value="<?= ucfirst($user['role']); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="firstname" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                account_circle
                            </span>
                            First Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname" readonly
                                value="<?= $user['firstname']; ?>">
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
                            <input type="text" class="form-control" id="lastname" name="lastname" readonly
                                value="<?= $user['lastname']; ?>">
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
                            <input type="email" class="form-control" id="email" name="email" readonly
                                value="<?= $user['email']; ?>">
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mt-4">
                        <a href="<?= base_url("users") ?>" class="btn btn-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>