<header class="text-center py-4">
    <h1 class="mb-0">Add User</h1>
</header>
<main>
    <div class="col col-md-6 mx-auto">
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form action="<?= base_url('users/insert'); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                account_circle
                            </span>
                            Username
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Enter Username" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fullname" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                description
                            </span>
                            Full Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" step="0.01" class="form-control" id="fullname" name="fullname"
                                placeholder="Enter Full name" required>
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
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                password_2
                            </span>
                            Password
                        </label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter Password" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="confpassword" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                password_2
                            </span>
                            Confirm Password
                        </label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="confpassword" name="confpassword"
                                placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= base_url('users'); ?>" class="btn btn-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                            Back
                        </a>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                person_add
                            </span>
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>