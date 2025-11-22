<header class="text-center py-4">
    <h1 class="mb-0">Edit Product</h1>
</header>
<main>
    <div class="col col-md-6 mx-auto">
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form action="<?= base_url('products/update/'.$product['id']); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">Current Image</label>
                        <div class="col-sm-9">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= base_url('public/assets/images/products/' . $product['image']); ?>" alt="<?= $product['name']; ?>" class="img-fluid rounded" style="max-height: 150px;">
                            <?php else: ?>
                                <div class="text-muted d-flex align-items-center gap-2">
                                    <span class="material-symbols-outlined" style="font-size:32px;">
                                        imagesmode
                                    </span>
                                    <span>No image available</span>
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
                            <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ;?>"
                                required>
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
                            <input type="number" step="0.01" class="form-control" id="price" name="price"
                                value="<?= $product['price'] ;?>" required>
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
                            <input type="text" class="form-control" id="description" name="description"
                                value="<?= $product['description'];?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="image" class="col-sm-3 col-form-label fw-bold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 28px;">
                                image
                            </span>
                            Change Image
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control" type="file" name="image" id="image">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= base_url("products") ?>" class="btn btn-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                            Back
                        </a>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined">
                                save
                            </span>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>