<header class="text-center py-4">
    <h1 class="mb-0">View Product</h1>
</header>
<main>
    <div class="col col-md-6 mx-auto">
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                image
                            </span>
                            Image
                        </label>
                        <div class="col-sm-9">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= base_url('public/assets/images/products/' . $product['image']); ?>" alt="<?= $product['name']; ?>" class="img-fluid rounded" style="max-height: 200px;">
                            <?php else: ?>
                                <div class="text-muted">
                                    <span class="material-symbols-outlined" style="font-size:48px;">
                                        imagesmode
                                    </span>
                                    <p>No image available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                inventory_2
                            </span>
                            Product Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" readonly value="<?= $product['name'];?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="price" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                attach_money
                            </span>
                            Price
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="price" name="price" readonly value="₱<?= number_format($product['price'], 2);?>">
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
                            <textarea class="form-control" id="description" name="description" readonly rows="3"><?= $product['description'];?></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mt-4">
                        <a href="<?= base_url("products") ?>" class="btn btn-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>