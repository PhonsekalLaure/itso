<?php
// Forgot password view (Bootstrap)
?>

    <div class="row min-vh-100 align-items-center justify-content-center">
        <div class="col-12 col-sm-9 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Reset Password</h3>

                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <p class="text-muted small mb-4">
                        Enter your username and we'll send you a link to reset your password.
                    </p>

                    <form action="<?= base_url('auth/reset-request') ?>" method="post" novalidate>
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Your username" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Send Reset Link</button>
                        </div>

                    </form>

                    <div class="mt-3 text-center">
                        <a href="<?= base_url('') ?>">Back to login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
