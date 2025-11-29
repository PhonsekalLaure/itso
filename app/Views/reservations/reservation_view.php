<div class="main-content" style="padding: 20px; font-family: Arial, sans-serif;">

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #0b824a;">Reservation Details</h2>
        <a href="<?= base_url('reservations'); ?>" style="padding: 8px 16px; background: #f4b029; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600;">Back to Reservations</a>
    </div>

    <!-- Reservation Card -->
    <div class="card shadow-sm p-4" style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h4 class="mb-3" style="color: #0b824a;">Reservation Info</h4>

        <?php
        // Ensure status always has a valid value
        $status = strtolower($reservation['status'] ?? 'pending');


        $badgeColors = [
            'pending' => 'background: #ffc107; color: #000;',
            'approved' => 'background: #28a745; color: #fff;',
            'picked_up' => 'background: #0d6efd; color: #fff;',
            'cancelled' => 'background: #dc3545; color: #fff;',
            'completed' => 'background: #343a40; color: #fff;',
        ];

        $badgeStyle = $badgeColors[$status] ?? 'background: #6c757d; color: #fff;';
        ?>

        <table class="table table-borderless" style="width:100%; font-size:14px;">
            <tr>
                <th style="text-align: left; padding: 8px; width:200px; color:#0b824a;">Reserver Name:</th>
                <td><?= htmlspecialchars($reservation['reserver_name'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; color:#0b824a;">Reserver Email:</th>
                <td><?= htmlspecialchars($reservation['reserver_email'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; color:#0b824a;">Equipment:</th>
                <td><?= htmlspecialchars($reservation['equipment_name'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; color:#0b824a;">Quantity:</th>
                <td><?= $reservation['quantity'] ?? 0 ?></td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; color:#0b824a;">Reservation Date:</th>
                <td><?= date('M d, Y h:i A', strtotime($reservation['reservation_date'])) ?></td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; color:#0b824a;">Pickup Date:</th>
                <td><?= date('M d, Y h:i A', strtotime($reservation['pickup_date'])) ?></td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>
                    <span style="<?= $badgeStyle ?> padding:5px 10px; border-radius:5px;">
                        <?= ucfirst(str_replace('_', ' ', $status)) ?>
                    </span>
                </td>
            </tr>
        </table>

        <!-- Action Buttons -->
        <div class="mt-4">
            <?php if ($status === 'pending'): ?>
                <a href="#" class="btn" id="btnApprove" style="background:#28a745; color:#fff; margin-right: 10px;">Approve</a>
                <a href="#" class="btn" id="btnCancel" style="background:#ffc107; color:#000; margin-right: 10px;">Cancel</a>
            <?php elseif ($status === 'approved'): ?>
                <a href="#" class="btn" id="btnPickup" style="background:#0d6efd; color:#fff; margin-right: 10px;">Mark as Picked Up</a>
            <?php endif; ?>
            <a href="#" class="btn" id="btnDelete" style="background:#dc3545; color:#fff;">Delete</a>
        </div>
    </div>
</div>

<?php
$resName = htmlspecialchars($reservation['reserver_name'] ?? 'reserver');
$resId = $reservation['reservation_id'];
?>

<!-- Modals -->
<?php foreach(['approve','cancel','pickup','delete'] as $action): ?>
<div class="modal fade" id="<?= $action ?>Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="padding:20px; border-radius:10px;">
            <h5 style="color:#0b824a; text-transform: capitalize;"><?= $action ?> Reservation</h5>
            <p>
                <?php if($action == 'pickup'): ?>
                    Confirm that <strong><?= $resName ?></strong> has picked up the equipment?
                <?php else: ?>
                    Are you sure you want to <?= $action ?> this reservation for <strong><?= $resName ?></strong>?
                <?php endif; ?>
            </p>
            <div style="text-align:right;">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= base_url("reservations/$action/$resId") ?>" class="btn btn-<?= $action==='approve'?'success':($action==='cancel'?'warning':($action==='pickup'?'primary':'danger')) ?>">
                    <?= ucfirst($action) ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = {
        btnApprove: 'approveModal',
        btnCancel: 'cancelModal',
        btnPickup: 'pickupModal',
        btnDelete: 'deleteModal'
    };

    for (const [btnId, modalId] of Object.entries(buttons)) {
        const btn = document.getElementById(btnId);
        if(btn) btn.addEventListener('click', e => { 
            e.preventDefault(); 
            new bootstrap.Modal(document.getElementById(modalId)).show(); 
        });
    }
});
</script>
