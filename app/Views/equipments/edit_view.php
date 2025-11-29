<div class="main-content">

    <!-- Page Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>EDIT EQUIPMENT</h2>
        <div>
            <i class="bi bi-pencil-square" style="font-size: 40px; color:white;"></i>
        </div>
    </div>

    <div class="row gx-5 gy-4 mt-5">
        <div class="col-md-8">
            <div class="activities-box" id="equipment-edit-container">
                <div class="section-title">
                    <i class="bi bi-box-fill"></i> Edit Equipment Information
                </div>

                <form action="<?= base_url('equipments/update/'.$equipment['equipment_id']); ?>" method="post" enctype="multipart/form-data">

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

                    <!-- Product Name -->
                    <div class="equipment-form-group row">
                        <label for="name" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined">inventory_2</span>
                            Product Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" required value="<?= $equipment['name']; ?>">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="equipment-form-group row">
                        <label for="description" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined">description</span>
                            Description
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= $equipment['description']; ?></textarea>
                        </div>
                    </div>

                    <!-- Accessories -->
                    <div class="equipment-form-group row">
                        <label for="accessories" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined">handyman</span>
                            Accessories
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="accessories" name="accessories" rows="3" required><?= $equipment['accessories']; ?></textarea>
                        </div>
                    </div>

                    <!-- Total Count -->
                    <div class="equipment-form-group row">
                        <label for="total_count" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined">stack</span>
                            Total Count
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="total_count" name="total_count" required value="<?= $equipment['total_count']; ?>">
                        </div>
                    </div>

                    <!-- Available Count -->
                    <div class="equipment-form-group row">
                        <label for="available_count" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined">check_circle</span>
                            Available Count
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="available_count" name="available_count" required value="<?= $equipment['available_count']; ?>">
                        </div>
                    </div>

                    <!-- Date Added -->
                    <div class="equipment-form-group row">
                        <label for="date_added" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined">calendar_today</span>
                            Date Added
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" readonly value="<?= date('M d, Y h:i A', strtotime($equipment['date_added'])); ?>">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-start mt-4 gap-2">
                        <a href="<?= base_url("equipments") ?>" class="btn btn-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Back
                        </a>

                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">save</span>
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Summary Card (SAME AS VIEW_VIEW) -->
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
    #equipment-edit-container {
        height: 100%;
    }
</style>
