<?php
include('includes/header.php');
require_once 'classes/CartHandler.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartHandler = new CartHandler($_SESSION['cart']);

if (isset($_GET['action'])) {
    $id = $_GET['id'] ?? null;

    if ($_GET['action'] === 'emptycart') {
        $cartHandler->emptyCart();
        header('Location: index.php');
    }

    if ($_GET['action'] === 'minus' && $id !== null) {
        $currentQty = $_SESSION['cart'][$id]['qty'] ?? 0;
        $cartHandler->updateQuantity($id, $currentQty - 1);
        header('Location: cart.php');
    }

    if ($_GET['action'] === 'plus' && $id !== null) {
        $currentQty = $_SESSION['cart'][$id]['qty'] ?? 0;
        $cartHandler->updateQuantity($id, $currentQty + 1);
        header('Location: cart.php');
    }
}
?>

<!-- Products -->
<div class="cart py-5">
    <div class="container">
        <div class="d-flex justify-content-between">
            <div>
                <h2>Cart</h2>
                <p>
                    <?= count($_SESSION['cart']) ?> products
                </p>
            </div>
            <div>
                <a href="?action=emptycart" class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Are you sure?')">
                    Empty cart
                </a>
            </div>
        </div>
        <div class="my-5">
            <?php if (count($_SESSION['cart'])): ?>
                <div class="table-responsive">
                    <table class="table table-bordered cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td><?= $item['name'] ?></td>
                                    <td>
                                        <div class="quantity-control">
                                            <a href="?action=minus&id=<?= $item['id'] ?>"
                                               class="btn btn-sm btn-outline-secondary">-</a>
                                            <span class="quantity"><?= $item['qty'] ?></span>
                                            <a href="?action=plus&id=<?= $item['id'] ?>"
                                               class="btn btn-sm btn-outline-secondary">+</a>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <?= number_format($item['price'] * $item['qty'], 2, '.', '') ?> &euro;
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2" class="text-start"><strong>Total Price:</strong></td>
                                <td class="text-end">
                                    <?= number_format($cartHandler->calculateTotal(), 2, '.', '') ?> &euro;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Cart is empty!</p>
            <?php endif; ?>
        </div>
        <div>
            <?php if (isset($_SESSION['is_loggedin']) && $_SESSION['is_loggedin'] == 1): ?>
                <a href="checkout.php" class="btn btn-sm btn-outline-primary">Check out</a>
            <?php else: ?>
                Please <a href="login.php">login</a> first
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
