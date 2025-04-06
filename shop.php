<?php 
    include('includes/header.php');

    $products = $crud->read('products');

    // Check if search query exists and is at least 3 characters long
    if(isset($_GET['search']) && strlen(trim($_GET['search'])) >= 3) {
        $searchTerm = trim($_GET['search']);
        $products = $crud->search('products', 'name', $searchTerm);
    }
?>

<!-- Products -->
<div class="products py-5">
    <div class="container">
        <div class="d-flex justify-content-between">
            <div>
                <h2>Explore products</h2>
                <p><?= count($products) ?> products available</p>
            </div>
            <div>
                <!-- Search Form -->
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">
                    <input type="text" name="search" class="form-control" placeholder="Search products..." 
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                </form>
            </div>
        </div>

        <div class="row mt-5">
        <?php if($products && count($products)): ?>
            <?php foreach($products as $product): ?>
                <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card" style="width: 18rem;">
                    <img src="dashboard/products/images/<?= $product['image'] ?>" class="product-image" alt="<?= $product['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name'] ?></h5>
                        <p class="card-text card-text-product">
                            <?= $product['price'] ?> &euro;
                            <br />
                            <?php if($product['discount'] > 0): ?>
                                <span class="badge bg-danger"><?= $product['discount'] ?>%</span>
                                <?php
                                    $new_price = $product['price'] - ($product['price'] * ($product['discount'] / 100));
                                    echo number_format($new_price, 2, ".", "");
                                ?> &euro;
                            <?php endif; ?>
                        </p>
                        <a href="view-product.php?id=<?= $product['id'] ?>" class="btn btn-outline-secondary">
                            View product
                        </a>
                    </div>
                </div> <!-- ./card -->
            </div> <!-- ./col -->
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                No products found!
            </div>
        <?php endif; ?>
        </div> <!-- ./row -->
    </div>
</div>

<?php include('includes/footer.php'); ?>
