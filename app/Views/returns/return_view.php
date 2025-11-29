<header class="text-center py-4">
    <h1 class="mb-0">Return Log Details</h1>
</header>
<main>
    <div class="col col-md-8 mx-auto">
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form>
                    <!-- Borrower Information Section -->
                    <h5 class="mb-3 border-bottom pb-2">Return Information</h5>
                    
                    <div class="mb-3 row">
                        <label for="borrower_name" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                account_circle
                            </span>
                            Return Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="borrower_name" name="borrower_name" readonly
                                value="<?= $borrow['borrower_name']; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
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
                    <h5 class="mb-3 border-bottom pb-2 mt-4">Equipment Information</h5>

                    <div class="mb-3 row">
                        <label for="equipment_name" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                inventory_2
                            </span>
                            Equipment Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="equipment_name" name="equipment_name" readonly
                                value="<?= $borrow['equipment_name']; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="description" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                description
                            </span>
                            Description
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" readonly rows="3"><?= $borrow['description']; ?></textarea>
                        </div>
                    </div>

                    <!-- Borrow Details Section -->
                    <h5 class="mb-3 border-bottom pb-2 mt-4">Borrow Details</h5>

                    <div class="mb-3 row">
                        <label for="quantity" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                shopping_cart
                            </span>
                            Quantity
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="quantity" name="quantity" readonly
                                value="<?= $borrow['quantity']; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="borrow_date" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                calendar_today
                            </span>
                            Borrow Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="borrow_date" name="borrow_date" readonly
                                value="<?= $borrow['borrow_date']; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="return_date" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                event_available
                            </span>
                            Return Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="return_date" name="return_date" readonly
                                value="<?= $borrow['return_date'] ?? 'Not returned'; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="status" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
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
                   <a href="<?= base_url('returns') ?>" class="btn btn-secondary d-flex align-items-center gap-1">
    <span class="material-symbols-outlined">arrow_back</span> Back to Dashboard
</a>



                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
/* Center the card and give it width */
main .col {
    margin-top: 3rem;
}

.card {
    border-radius: 15px;
    border: 1px solid #dee2e6;
    max-width: 700px;
    margin: 0 auto;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-3px);
}

/* Card body padding */
.card-body {
    padding: 2.5rem;
}

/* Section headers */
h5 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #495057;
    margin-top: 2rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #dee2e6;
}

/* Inputs and textareas */
input[readonly],
textarea[readonly] {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    color: #495057;
    height: 45px;
    font-size: 1rem;
    padding: 0.5rem;
}

textarea[readonly] {
    min-height: 80px;
}

/* Labels icons */
label span.material-symbols-outlined {
    color: #6c757d;
    font-size: 24px;
}

/* Back button */
a.btn-secondary {
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

a.btn-secondary:hover {
    background-color: #5a6268;
    color: #fff;
    text-decoration: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    input[readonly], textarea[readonly] {
        font-size: 0.95rem;
    }
}
</style>
