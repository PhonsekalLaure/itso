<div class="glass-card">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

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

    <img src="https://img.icons8.com/ios-filled/100/ffffff/lock.png" width="80" alt="Lock Icon" />

    <h2 class="mt-2">Reset Password</h2>

    <p class="mt-2" style="color: #eee;">Enter your new password below.</p>

    <form action="<?= base_url('auth/reset/' . $admin_id) ?>" method="post" novalidate id="resetForm">
        <?= csrf_field() ?>
        
        <input type="password" class="form-control my-2" id="password" name="password" 
               placeholder="New password" required>
        
        <input type="password" class="form-control my-2" id="confirm_password" name="confirm_password" 
               placeholder="Confirm new password" required>
        
        <button type="submit" class="mt-2">Reset Password</button>

        <p class="mt-2"><a href="<?= base_url('/') ?>">Back to login</a></p>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('resetForm');
        
        form.addEventListener('submit', function(e) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long!');
                return false;
            }
        });
    });
</script>