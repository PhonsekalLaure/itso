<div class="main-content">

    <!-- Page Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2>RETURN LOG DETAILS</h2>
        <div>
            <i class="bi bi-arrow-return-left" style="font-size: 40px; color:white;"></i>
        </div>
    </div>

    <!-- Return Details Section -->
    <div class="row gx-5 gy-4 mt-5">
        <div class="col-md-8">
            <div class="activities-box" id="return-view-container">
                <div class="section-title">
                    <i class="bi bi-box-arrow-in-left"></i> Return Information
                </div>

                <form>
                    <style>
                        .return-form-group {
                            margin-bottom: 1.75rem;
                            padding-bottom: 1.75rem;
                            border-bottom: 1px solid #e9ecef;
                        }
                        .return-form-group:last-of-type {
                            border-bottom: none;
                            padding-bottom: 0;
                            margin-bottom: 1.5rem;
                        }
                        .section-subtitle {
                            font-size: 14px;
                            font-weight: 600;
                            color: #495057;
                            margin-top: 1.5rem;
                            margin-bottom: 1rem;
                            padding-bottom: 0.75rem;
                            border-bottom: 2px solid #0b824a;
                        }
                    </style>

                    <!-- Returner Information Section -->
                    <div class="section-subtitle">
                        <i class="bi bi-person-fill"></i> Returner Information
                    </div>
                    
                    <div class="return-form-group row">
                        <label for="borrower_name" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                account_circle
                            </span>
                            Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="borrower_name" name="borrower_name" readonly
                                value="<?= $borrow['borrower_name']; ?>">
                        </div>
                    </div>

                    <div class="return-form-group row">
                        <label for="email" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                mail
                            </span>
                            Email
                        </label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" readonly
                                value="<?= $borrow['email']; ?>">
                        </div>
                    </div>

                    <!-- Equipment Information Section -->
                    <div class="section-subtitle">
                        <i class="bi bi-box-fill"></i> Equipment Information
                    </div>

                    <div class="return-form-group row">
                        <label for="equipment_name" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                inventory_2
                            </span>
                            Equipment Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="equipment_name" name="equipment_name" readonly
                                value="<?= $borrow['equipment_name']; ?>">
                        </div>
                    </div>

                    <div class="return-form-group row">
                        <label for="description" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                description
                            </span>
                            Description
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" readonly rows="3"><?= $borrow['description']; ?></textarea>
                        </div>
                    </div>

                    <!-- Return Details Section -->
                    <div class="section-subtitle">
                        <i class="bi bi-clock-history"></i> Return Details
                    </div>

                    <div class="return-form-group row">
                        <label for="quantity" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                shopping_cart
                            </span>
                            Quantity
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="quantity" name="quantity" readonly
                                value="<?= $borrow['quantity']; ?>">
                        </div>
                    </div>

                    <div class="return-form-group row">
                        <label for="borrow_date" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                calendar_today
                            </span>
                            Borrow Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="borrow_date" name="borrow_date" readonly
                                value="<?= date('M d, Y h:i A', strtotime($borrow['borrow_date'])); ?>">
                        </div>
                    </div>

                    <div class="return-form-group row">
                        <label for="return_date" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                event_available
                            </span>
                            Return Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="return_date" name="return_date" readonly
                                value="<?= $borrow['return_date'] ? date('M d, Y h:i A', strtotime($borrow['return_date'])) : 'Not returned'; ?>">
                        </div>
                    </div>

                    <div class="return-form-group row">
                        <label for="status" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">
                                info
                            </span>
                            Status
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="status" name="status" readonly
                                value="<?= ucfirst($borrow['status']); ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <a href="<?= base_url("returns") ?>" class="btn btn-secondary d-flex align-items-center gap-1">
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
                    <i class="bi bi-info-circle-fill"></i> Return Summary
                </div>
                <div style="padding: 15px; background-color: #f8f9fa; border-radius: 8px; margin-bottom: 15px;">
                    <p><strong>Returner:</strong> <?= $borrow['borrower_name']; ?></p>
                    <p><strong>Equipment:</strong> <?= $borrow['equipment_name']; ?></p>
                    <p><strong>Quantity:</strong> <span class="badge bg-info"><?= $borrow['quantity']; ?></span></p>
                    <p><strong>Status:</strong> 
                        <?php 
                            $statusColor = strtolower($borrow['status']) === 'returned' ? 'bg-success' : 'bg-warning';
                        ?>
                        <span class="badge <?= $statusColor; ?>"><?= ucfirst($borrow['status']); ?></span>
                    </p>
                    <p><strong>Returned:</strong> <?= $borrow['return_date'] ? date('M d, Y', strtotime($borrow['return_date'])) : 'Not yet'; ?></p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    #return-view-container {
        height: 100%;
    }
</style>
