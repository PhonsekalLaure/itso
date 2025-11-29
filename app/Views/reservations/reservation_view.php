<div class="main-content p-4" style="font-family: Arial, sans-serif;">

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">Reservation Details</h2>
        <a href="<?= base_url('reservations'); ?>" class="btn btn-warning">Back to Reservations</a>
    </div>

    <!-- Reservation Card -->
    <div class="card shadow-sm p-4">
        <h4 class="text-success mb-3">Reservation Info</h4>

        <?php
        // Normalize status
        $status = strtolower(trim($reservation['status'] ?? 'pending'));
        $badgeColors = [
            'pending'   => 'bg-warning text-dark',
            'approved'  => 'bg-success text-white',
            'picked_up' => 'bg-primary text-white',
            'cancelled' => 'bg-danger text-white',
        ];
        $badgeClass = $badgeColors[$status] ?? 'bg-secondary text-white';
        $displayText = ucfirst(str_replace('_', ' ', $status));
        ?>

        <table class="table table-borderless" style="font-size:14px;">
            <tr>
                <th class="text-success" style="width:200px;">Reserver Name:</th>
                <td><?= htmlspecialchars($reservation['reserver_name'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th class="text-success">Reserver Email:</th>
                <td><?= htmlspecialchars($reservation['reserver_email'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th class="text-success">Equipment:</th>
                <td><?= htmlspecialchars($reservation['equipment_name'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th class="text-success">Quantity:</th>
                <td><?= $reservation['quantity'] ?? 0 ?></td>
            </tr>
            <tr>
                <th class="text-success">Reservation Date:</th>
                <td><?= date('M d, Y h:i A', strtotime($reservation['reservation_date'])) ?></td>
            </tr>
            <tr>
                <th class="text-success">Pickup Date:</th>
                <td><?= date('M d, Y h:i A', strtotime($reservation['pickup_date'])) ?></td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>
                    <span class="badge <?= $badgeClass ?>"><?= $displayText ?></span>
                </td>
            </tr>
        </table>

        <!-- Action Buttons -->
        <div class="mt-4">
            <?php if ($status === 'pending'): ?>
                <a href="#" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</a>
                <a href="#" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</a>
            <?php elseif ($status === 'approved'): ?>
                <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#pickupModal">Mark as Picked Up</a>
            <?php endif; ?>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a>
        </div>
    </div>
</div>

<?php $resId = $reservation['reservation_id']; ?>

<!-- Modals -->
<?php foreach(['approve','cancel','pickup','delete'] as $action): ?>
<div class="modal fade" id="<?= $action ?>Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4 rounded">
            <h5 class="text-success text-capitalize"><?= $action ?> Reservation</h5>
            <p>
                <?php if($action === 'pickup'): ?>
                    Confirm that <strong><?= htmlspecialchars($reservation['reserver_name']) ?></strong> has picked up the equipment?
                <?php else: ?>
                    Are you sure you want to <?= $action ?> this reservation for <strong><?= htmlspecialchars($reservation['reserver_name']) ?></strong>?
                <?php endif; ?>
            </p>
            <div class="text-end">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= base_url("reservations/$action/$resId") ?>" class="btn btn-<?= $action==='approve'?'success':($action==='cancel'?'warning':($action==='pickup'?'primary':'danger')) ?>">
                    <?= ucfirst($action) ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
