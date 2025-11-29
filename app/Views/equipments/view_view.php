<div class="main-content">

    <!-- Page Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>VIEW EQUIPMENT</h2>
        <div>
            <i class="bi bi-box-seam" style="font-size: 40px; color:white;"></i>
        </div>
    </div>

    <!-- Equipment Details Section -->
    <div class="row gx-5 gy-4 mt-5">
        <div class="col-md-8">
            <div class="activities-box" id="equipment-view-container">
                <div class="section-title">
                    <i class="bi bi-box-fill"></i> Equipment Information
                </div>

                <form>
                    <style>
                        .equipment-form-group {
                            margin-bottom: 1.75rem;
                            padding-bottom: 1.75rem;
                            border-bottom: 1px solid #e9ecef;
                        }
                        .equipment-form-group:last-of-type {
                            border-bottom: none;
                            padding-bottom: 0;
                            margin-bottom: 1.5rem;
                        }
                    </style>
                    <div class="equipment-form-group row">
                        <label for="name" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                inventory_2
                            </span>
                            Product Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" readonly value="<?= $equipment['name']; ?>">
                        </div>
                    </div>

                    <div class="equipment-form-group row">
                        <label for="description" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                description
                            </span>
                            Description
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" readonly rows="3"><?= $equipment['description']; ?></textarea>
                        </div>
                    </div>

                    <div class="equipment-form-group row">
                        <label for="accessories" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                handyman
                            </span>
                            Accessories
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="accessories" name="accessories" readonly rows="3"><?= $equipment['accessories']; ?></textarea>
                        </div>
                    </div>

                    <div class="equipment-form-group row">
                        <label for="total_count" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                stack
                            </span>
                            Total Count
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="total_count" name="total_count" readonly value="<?= $equipment['total_count']; ?>">
                        </div>
                    </div>

                    <div class="equipment-form-group row">
                        <label for="available_count" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                check_circle
                            </span>
                            Available Count
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="available_count" name="available_count" readonly value="<?= $equipment['available_count']; ?>">
                        </div>
                    </div>

                    <div class="equipment-form-group row">
                        <label for="date_added" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                calendar_today
                            </span>
                            Date Added
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="date_added" name="date_added" readonly value="<?= date('M d, Y h:i A', strtotime($equipment['date_added'])); ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <a href="<?= base_url("equipments") ?>" class="btn btn-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="col-md-4">
            <div class="quick-box">
                <div class="section-title">
                    <i class="bi bi-info-circle-fill"></i> Equipment Summary
                </div>
                <div style="padding: 15px; background-color: #f8f9fa; border-radius: 8px; margin-bottom: 15px;">
                    <p><strong>Product:</strong> <?= $equipment['name']; ?></p>
                    <p><strong>Total:</strong> <span class="badge bg-info"><?= $equipment['total_count']; ?></span></p>
                    <p><strong>Available:</strong> <span class="badge bg-success"><?= $equipment['available_count']; ?></span></p>
                    <p><strong>In Use:</strong> <span class="badge bg-warning"><?= $equipment['total_count'] - $equipment['available_count']; ?></span></p>
                    <p><strong>Added:</strong> <?= date('M d, Y', strtotime($equipment['date_added'])); ?></p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    #equipment-view-container {
        height: 100%;
    }
</style>
