<div class="glass-card">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <img src="https://img.icons8.com/ios-filled/100/ffffff/user.png" width="80" alt="User Icon" />

    <h2 class="mt-2">Login</h2>

    <form action="<?= base_url('auth/authenticate') ?>" method="post" novalidate>
        <input type="text" class="form-control my-2" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Your username" required>
        <input type="password" class="form-control my-2" id="password" name="password" placeholder="Your password" required>
        <button type="submit">Login</button>
        <p class="mt-2"><a href="<?= base_url('auth/forgot') ?>">Forgot password?</a></p>
    </form>
</div>