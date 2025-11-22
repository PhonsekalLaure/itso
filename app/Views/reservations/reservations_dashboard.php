<div class="main-content">

    <!-- Top Header styled like dashboard -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>RESERVATION MANAGEMENT</h2>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-person-circle" style="font-size: 40px; color:#0b824a;"></i>
            <div>
                <?php $sessUser = session()->get('user'); ?>
                <b><?= $user['firstname'] . " " . $user['lastname']; ?></b><br>
                <small>
                    <?php
                    if (strtolower($user['role']) == 'admin') {
                        echo "Administrator";
                    } elseif (strtolower($user['role']) == 'sadmin') {
                        echo "Super Administrator";
                    }
                    ?>
                </small><br>
                <small>Current time: <?= date("M d, Y h:i A", strtotime("+8 hours")); ?></small>
            </div>
        </div>
    </div>

    <!-- NEW RESERVATION panel with form -->
    <div class="quick-box mb-4">
        <div class="section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> NEW RESERVATION
        </div>
        
        <form action="<?= base_url('reservations/insert'); ?>" method="post" id="addReservationForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="user_id" class="form-label fw-bold">
                        <i class="bi bi-person-badge"></i> Reserver
                    </label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="" disabled selected>Select reserver</option>
                        <?php foreach ($users as $reserver): ?>
                            <option value="<?= $reserver['user_id'] ?>">
                                <?= $reserver['firstname'] . ' ' . $reserver['lastname'] ?> (<?= $reserver['email'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="equipment_id" class="form-label fw-bold">
                        <i class="bi bi-box-seam"></i> Equipment
                    </label>
                    <select class="form-control" id="equipment_id" name="equipment_id" required>
                        <option value="" disabled selected>Select equipment</option>
                        <?php foreach ($equipments as $eq): ?>
                            <option value="<?= $eq['equipment_id'] ?>" data-available="<?= $eq['available_count'] ?>">
                                <?= $eq['name'] ?> (Available: <?= $eq['available_count'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="quantity" class="form-label fw-bold">
                        <i class="bi bi-calculator"></i> Quantity
                    </label>
                    <input type="number" class="form-control" id="quantity" name="quantity" 
                           placeholder="Enter quantity" min="1" required>
                </div>
                
                <div class="col-md-4">
                    <label for="reservation_date" class="form-label fw-bold">
                        <i class="bi bi-calendar-plus"></i> Reservation Date
                    </label>
                    <input type="datetime-local" class="form-control" id="reservation_date" name="reservation_date" required>
                </div>
                
                <div class="col-md-4">
                    <label for="pickup_date" class="form-label fw-bold">
                        <i class="bi bi-calendar-check"></i> Pickup Date
                    </label>
                    <input type="datetime-local" class="form-control" id="pickup_date" name="pickup_date" required>
                </div>
                
                <div class="col-md-6">
                    <label for="expected_return_date" class="form-label fw-bold">
                        <i class="bi bi-calendar-event"></i> Expected Return
                    </label>
                    <input type="datetime-local" class="form-control" id="expected_return_date" name="expected_return_date" required>
                </div>
                
                <div class="col-md-6">
                    <label for="priority" class="form-label fw-bold">
                        <i class="bi bi-flag"></i> Priority Level
                    </label>
                    <select class="form-control" id="priority" name="priority" required>
                        <option value="" disabled selected>Select priority</option>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <label for="purpose" class="form-label fw-bold">
                        <i class="bi bi-card-text"></i> Purpose
                    </label>
                    <textarea class="form-control" id="purpose" name="purpose" rows="2" 
                              placeholder="Enter purpose of reservation" required></textarea>
                </div>
                
                <div class="col-12 text-end">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </button>
                    <button type="submit" class="btn ms-2" 
                            style="background:#f4b029; color:#fff; font-weight:600;">
                        <i class="bi bi-calendar-plus"></i> Add Reservation
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- RESERVATION LOGS panel -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2"><i class="bi bi-calendar2-range"></i> RESERVATION LOGS</div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4">Reserver</th>
                        <th>Equipment</th>
                        <th>Quantity</th>
                        <th>Pickup Date</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th class="text-start pe-3" style="width: 210px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td class="ps-4"><?= $reservation['reserver_name'] ?? 'N/A' ?></td>
                            <td><?= $reservation['equipment_name'] ?? 'N/A' ?></td>
                            <td><?= $reservation['quantity'] ?? '0' ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($reservation['pickup_date'])) ?></td>
                            <td>
                                <?php 
                                $priority = strtolower($reservation['priority'] ?? 'medium');
                                $priorityClass = '';
                                if ($priority == 'urgent') {
                                    $priorityClass = 'bg-danger';
                                } elseif ($priority == 'high') {
                                    $priorityClass = 'bg-warning text-dark';
                                } elseif ($priority == 'medium') {
                                    $priorityClass = 'bg-info text-dark';
                                } else {
                                    $priorityClass = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?= $priorityClass ?>"><?= ucfirst($priority) ?></span>
                            </td>
                            <td>
                                <?php 
                                $status = strtolower($reservation['status'] ?? 'pending');
                                $badgeClass = '';
                                if ($status == 'pending') {
                                    $badgeClass = 'bg-warning text-dark';
                                } elseif ($status == 'approved') {
                                    $badgeClass = 'bg-success';
                                } elseif ($status == 'picked_up') {
                                    $badgeClass = 'bg-primary';
                                } elseif ($status == 'cancelled') {
                                    $badgeClass = 'bg-danger';
                                } elseif ($status == 'completed') {
                                    $badgeClass = 'bg-dark';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('reservations/view/' . $reservation['reservation_id']); ?>" 
                                   class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <?php if ($status == 'pending'): ?>
                                    <a href="#" class="btn btn-outline-success btn-sm me-1 btn-approve" 
                                       title="Approve"
                                       data-id="<?= $reservation['reservation_id']; ?>"
                                       data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reserver'); ?>">
                                        <span class="material-symbols-outlined">check_circle</span>
                                    </a>
                                    <a href="#" class="btn btn-outline-warning btn-sm me-1 btn-cancel" 
                                       title="Cancel"
                                       data-id="<?= $reservation['reservation_id']; ?>"
                                       data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reserver'); ?>">
                                        <span class="material-symbols-outlined">cancel</span>
                                    </a>
                                <?php elseif ($status == 'approved'): ?>
                                    <a href="#" class="btn btn-outline-primary btn-sm me-1 btn-pickup" 
                                       title="Mark as Picked Up"
                                       data-id="<?= $reservation['reservation_id']; ?>"
                                       data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reserver'); ?>">
                                        <span class="material-symbols-outlined">shopping_bag</span>
                                    </a>
                                <?php endif; ?>
                                <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete" 
                                   data-id="<?= $reservation['reservation_id']; ?>"
                                   data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reservation'); ?>">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Approve Confirmation Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Approve Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to approve the reservation for <strong id="modalApproveName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-success" id="confirmApproveBtn">Approve</a>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel the reservation for <strong id="modalCancelName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <a href="#" class="btn btn-warning" id="confirmCancelBtn">Yes, Cancel</a>
            </div>
        </div>
    </div>
</div>

<!-- Pickup Confirmation Modal -->
<div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pickupModalLabel">Mark as Picked Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Confirm that <strong id="modalPickupName"></strong> has picked up the equipment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-primary" id="confirmPickupBtn">Confirm Pickup</a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this reservation for <strong id="modalReservationName"></strong>?
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
        // Set default reservation date to current date/time
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('reservation_date').value = now.toISOString().slice(0, 16);

        // Approve modal functionality
        var approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
        var confirmApproveBtn = document.getElementById('confirmApproveBtn');
        var modalApproveName = document.getElementById('modalApproveName');

        document.querySelectorAll('.btn-approve').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var reservationId = this.getAttribute('data-id');
                var reserverName = this.getAttribute('data-name');
                modalApproveName.textContent = reserverName;
                confirmApproveBtn.href = "<?= base_url('reservations/approve/') ?>" + reservationId;
                approveModal.show();
            });
        });

        // Cancel modal functionality
        var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
        var confirmCancelBtn = document.getElementById('confirmCancelBtn');
        var modalCancelName = document.getElementById('modalCancelName');

        document.querySelectorAll('.btn-cancel').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var reservationId = this.getAttribute('data-id');
                var reserverName = this.getAttribute('data-name');
                modalCancelName.textContent = reserverName;
                confirmCancelBtn.href = "<?= base_url('reservations/cancel/') ?>" + reservationId;
                cancelModal.show();
            });
        });

        // Pickup modal functionality
        var pickupModal = new bootstrap.Modal(document.getElementById('pickupModal'));
        var confirmPickupBtn = document.getElementById('confirmPickupBtn');
        var modalPickupName = document.getElementById('modalPickupName');

        document.querySelectorAll('.btn-pickup').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var reservationId = this.getAttribute('data-id');
                var reserverName = this.getAttribute('data-name');
                modalPickupName.textContent = reserverName;
                confirmPickupBtn.href = "<?= base_url('reservations/pickup/') ?>" + reservationId;
                pickupModal.show();
            });
        });

        // Delete modal functionality
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        var modalReservationName = document.getElementById('modalReservationName');

        document.querySelectorAll('.btn-delete').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var reservationId = this.getAttribute('data-id');
                var reservationName = this.getAttribute('data-name');
                modalReservationName.textContent = reservationName;
                confirmDeleteBtn.href = "<?= base_url('reservations/delete/') ?>" + reservationId;
                deleteModal.show();
            });
        });

        // Form validation
        var form = document.getElementById('addReservationForm');
        form.addEventListener('submit', function(e) {
            var equipmentSelect = document.getElementById('equipment_id');
            var selectedOption = equipmentSelect.options[equipmentSelect.selectedIndex];
            var availableCount = parseInt(selectedOption.getAttribute('data-available'));
            var quantity = parseInt(document.getElementById('quantity').value);
            
            if (quantity > availableCount) {
                e.preventDefault();
                alert('Quantity cannot exceed available count (' + availableCount + ')!');
                return false;
            }

            var reservationDate = new Date(document.getElementById('reservation_date').value);
            var pickupDate = new Date(document.getElementById('pickup_date').value);
            var returnDate = new Date(document.getElementById('expected_return_date').value);

            if (pickupDate <= reservationDate) {
                e.preventDefault();
                alert('Pickup date must be after reservation date!');
                return false;
            }

            if (returnDate <= pickupDate) {
                e.preventDefault();
                alert('Expected return date must be after pickup date!');
                return false;
            }
        });

        // Update quantity max based on selected equipment
        document.getElementById('equipment_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var availableCount = parseInt(selectedOption.getAttribute('data-available'));
            document.getElementById('quantity').setAttribute('max', availableCount);
        });
    });
</script>

<style>
    /* Minor table theming to align with dashboard palette */
    .users-table thead th {
        background: #eaf6ef;
        color: #0b824a;
        border-bottom: 2px solid #0b824a;
    }

    .users-table tbody tr td {
        border-top: 1px solid #e3e3e3;
    }

    .quick-box .section-title {
        color: #0b824a;
        font-weight: 700;
    }

    /* Form styling */
    .quick-box form .form-label {
        color: #0b824a;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .quick-box form .form-control,
    .quick-box form select,
    .quick-box form textarea {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 8px 12px;
    }

    .quick-box form .form-control:focus,
    .quick-box form select:focus,
    .quick-box form textarea:focus {
        border-color: #0b824a;
        box-shadow: 0 0 0 0.2rem rgba(11, 130, 74, 0.15);
    }

    /* Badge styling */
    .badge {
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 6px;
    }
</style>