<header class="text-center py-4">
    <h1 class="mb-0">Products</h1>
</header>
<main>
    <div class="col col-md-7 mx-auto">
        <div class="d-flex justify-content-end mb-3">
            <a href="<?= base_url('products/add'); ?>" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
                <span class="material-symbols-outlined">
                    add
                </span>
                Add Product
            </a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 150px;">Image</th>
                            <th class="ps-3">Product</th>
                            <th style="width: 150px;">Price</th>
                            <th class="text-start pe-3" style="width: 190px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="text-center">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= base_url('public/assets/images/products/' . $product['image']); ?>" alt="<?= $product['name']; ?>" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="material-symbols-outlined text-muted" style="font-size:32px;">
                                            imagesmode
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="ps-3"><?= $product['name'] ?></td>
                                <td>₱<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <a href="<?= base_url('products/view/'.$product['id']); ?>" class="btn btn-outline-success btn-sm me-1"
                                        title="View">
                                        <span class="material-symbols-outlined">
                                            visibility
                                        </span>
                                    </a>
                                    <a href="<?= base_url('products/edit/'.$product['id']); ?>" class="btn btn-outline-warning btn-sm me-1" title="Edit">
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm btn-delete" title="Delete" data-id="<?= $product['id'];?>" data-name="<?= htmlspecialchars($product['name']) ;?>" >
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <strong id="modalProductName"></strong>?
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
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    var modalProductName = document.getElementById('modalProductName');

    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var productId = this.getAttribute('data-id');
            var productName = this.getAttribute('data-name');
            modalProductName.textContent = productName;
            confirmDeleteBtn.href = "<?= base_url('products/delete/') ?>" + productId;
            deleteModal.show();
        });
    });
});
</script>