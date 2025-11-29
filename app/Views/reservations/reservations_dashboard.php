<div class="main-content">

    <!-- Dashboard Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>RESERVATION MANAGEMENT</h2>
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-person-circle" style="font-size: 40px; color:white;"></i>
            <div>
                <b><?= $admin['firstname'] . " " . $admin['lastname']; ?></b><br>
                <small>
                    <?= (strtolower($admin['role']) == 'sadmin') ? 'Super Administrator' : 'Administrator' ?>
                </small><br>
                <small>Current time: <?= date("M d, Y h:i A", strtotime("+8 hours")); ?></small>
            </div>
        </div>
    </div>

    <!-- New Reservation Form -->
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
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" min="1" required>
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

                <div class="col-12 text-end">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </button>
                    <button type="button" id="triggerAddReservationBtn" class="btn ms-2" style="background:#f4b029; color:#fff; font-weight:600;">
                        <i class="bi bi-calendar-plus"></i> Add Reservation
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Reservation Logs -->
    <div class="quick-box">
        <div class="section-title d-flex align-items-center gap-2">
            <i class="bi bi-calendar2-range"></i> RESERVATION LOGS
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 users-table">
                <thead>
                    <tr>
                        <th class="ps-4">Reserver</th>
                        <th>Equipment</th>
                        <th>Quantity</th>
                        <th>Pickup Date</th>
                        <th>Status</th>
                        <th class="text-start pe-3" style="width: 210px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): 
                        $status = strtolower($reservation['status'] ?? 'pending');
                        $badgeClass = match($status) {
                            'pending' => 'bg-warning text-dark',
                            'approved' => 'bg-success',
                            'picked_up' => 'bg-primary',
                            'cancelled' => 'bg-danger',
                            'completed' => 'bg-dark',
                            default => 'bg-secondary'
                        };
                    ?>
                        <tr>
                            <td class="ps-4"><?= $reservation['reserver_name'] ?? 'N/A' ?></td>
                            <td><?= $reservation['equipment_name'] ?? 'N/A' ?></td>
                            <td><?= $reservation['quantity'] ?? '0' ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($reservation['pickup_date'])) ?></td>
                            <td><span class="badge <?= $badgeClass ?>"><?= ucfirst(str_replace('_', ' ', $status)) ?></span></td>
                            <td class="text-end pe-3">
                                <a href="<?= base_url('reservations/view/' . $reservation['reservation_id']); ?>" class="btn btn-outline-success btn-sm me-1" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>

                                <?php if ($status == 'pending'): ?>
                                    <a href="#" class="btn btn-outline-success btn-sm me-1 btn-approve" data-id="<?= $reservation['reservation_id']; ?>" data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reserver'); ?>" title="Approve">
                                        <span class="material-symbols-outlined">check_circle</span>
                                    </a>
                                    <a href="#" class="btn btn-outline-warning btn-sm me-1 btn-cancel" data-id="<?= $reservation['reservation_id']; ?>" data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reserver'); ?>" title="Cancel">
                                        <span class="material-symbols-outlined">cancel</span>
                                    </a>
                                <?php elseif ($status == 'approved'): ?>
                                    <a href="#" class="btn btn-outline-primary btn-sm me-1 btn-pickup" data-id="<?= $reservation['reservation_id']; ?>" data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reserver'); ?>" title="Mark as Picked Up">
                                        <span class="material-symbols-outlined">shopping_bag</span>
                                    </a>
                                <?php endif; ?>

                                <a href="#" class="btn btn-outline-danger btn-sm btn-delete" data-id="<?= $reservation['reservation_id']; ?>" data-name="<?= htmlspecialchars($reservation['reserver_name'] ?? 'reservation'); ?>" title="Delete">
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

<!-- Modals (Cancel, Pickup, Delete, Add Reservation Confirmation) -->
<?php foreach(['cancel', 'pickup', 'delete'] as $modal): ?>
<div class="modal fade" id="<?= $modal ?>Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize"><?= $modal ?> reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if($modal === 'cancel'): ?>
                    Are you sure you want to cancel the reservation for <strong id="modalCancelName"></strong>?
                <?php elseif($modal === 'pickup'): ?>
                    Confirm that <strong id="modalPickupName"></strong> has picked up the equipment?
                <?php else: ?>
                    Are you sure you want to delete this reservation for <strong id="modalReservationName"></strong>?
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <?php if($modal === 'cancel'): ?>
                    <a href="#" class="btn btn-warning" id="confirmCancelBtn">Yes, Cancel</a>
                <?php elseif($modal === 'pickup'): ?>
                    <a href="#" class="btn btn-primary" id="confirmPickupBtn">Confirm Pickup</a>
                <?php else: ?>
                    <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Delete</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Add Reservation Confirmation Modal -->
<div class="modal fade" id="addReservationConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to add this reservation?</p>
                <p><strong>Reserver:</strong> <span id="confirmReserver"></span></p>
                <p><strong>Equipment:</strong> <span id="confirmEquipment"></span></p>
                <p><strong>Quantity:</strong> <span id="confirmQuantity"></span></p>
                <p><strong>Pickup Date:</strong> <span id="confirmPickupDate"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmAddReservationBtn">Yes, Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to approve the reservation for <strong id="modalApproveName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-success" id="confirmApproveBtn">Yes, Approve</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Default reservation date
    let now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('reservation_date').value = now.toISOString().slice(0,16);

    // Modal helper function
    const setupModal = (btnClass, modalId, nameId, confirmBtnId, urlBase) => {
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        const confirmBtn = document.getElementById(confirmBtnId);
        const nameEl = document.getElementById(nameId);

        document.querySelectorAll(btnClass).forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const id = btn.dataset.id;
                nameEl.textContent = btn.dataset.name;
                confirmBtn.href = urlBase + id;
                modal.show();
            });
        });
    };

    // Setup all modals
    setupModal('.btn-approve', 'approveModal', 'modalApproveName', 'confirmApproveBtn', '<?= base_url('reservations/approve/') ?>');
    setupModal('.btn-cancel', 'cancelModal', 'modalCancelName', 'confirmCancelBtn', '<?= base_url('reservations/cancel/') ?>');
    setupModal('.btn-pickup', 'pickupModal', 'modalPickupName', 'confirmPickupBtn', '<?= base_url('reservations/pickup/') ?>');
    setupModal('.btn-delete', 'deleteModal', 'modalReservationName', 'confirmDeleteBtn', '<?= base_url('reservations/delete/') ?>');

    // Update quantity max on equipment change
    document.getElementById('equipment_id').addEventListener('change', function() {
        this.setAttribute('max', this.selectedOptions[0].dataset.available);
    });

    // Add Reservation Modal
    const form = document.getElementById('addReservationForm');
    const triggerBtn = document.getElementById('triggerAddReservationBtn');
    const confirmBtn = document.getElementById('confirmAddReservationBtn');
    const addModal = new bootstrap.Modal(document.getElementById('addReservationConfirmModal'));

    triggerBtn.addEventListener('click', function() {
        const reserver = document.getElementById('user_id').selectedOptions[0]?.text;
        const equipment = document.getElementById('equipment_id').selectedOptions[0]?.text;
        const quantity = document.getElementById('quantity').value;
        const pickupDate = document.getElementById('pickup_date').value;

        if(!reserver || !equipment || !quantity || !pickupDate) {
            alert('Please fill all fields correctly!');
            return;
        }

        // Quantity validation
        const available = parseInt(document.getElementById('equipment_id').selectedOptions[0].dataset.available);
        if(quantity > available) { alert(`Quantity cannot exceed available count (${available})!`); return; }

        const reservationDate = new Date(document.getElementById('reservation_date').value);
        const pickupDateObj = new Date(pickupDate);
        if(pickupDateObj <= reservationDate) { alert('Pickup date must be after reservation date!'); return; }

        // Fill modal
        document.getElementById('confirmReserver').textContent = reserver;
        document.getElementById('confirmEquipment').textContent = equipment;
        document.getElementById('confirmQuantity').textContent = quantity;
        document.getElementById('confirmPickupDate').textContent = new Date(pickupDate).toLocaleString();

        addModal.show();
    });

    confirmBtn.addEventListener('click', function() {
        form.submit();
    });
});
</script>

<style>
.users-table thead th { background: #eaf6ef; color: #0b824a; border-bottom: 2px solid #0b824a; }
.users-table tbody tr td { border-top: 1px solid #e3e3e3; }

.quick-box .section-title { color: #0b824a; font-weight: 700; }
.quick-box form .form-label { color: #0b824a; font-size: 14px; margin-bottom: 5px; }
.quick-box form .form-control, .quick-box form select, .quick-box form textarea { border: 1px solid #dcdcdc; border-radius: 8px; padding: 8px 12px; }
.quick-box form .form-control:focus, .quick-box form select:focus, .quick-box form textarea:focus { border-color: #0b824a; box-shadow: 0 0 0 0.2rem rgba(11,130,74,0.15); }
.badge { padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 6px; }
</style>
