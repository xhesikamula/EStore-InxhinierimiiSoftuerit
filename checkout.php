<?php
include('includes/header.php');

if (!isset($_SESSION['is_loggedin']) || $_SESSION['is_loggedin'] != 1) {
    die('<div class="container my-4">Please <a href="login.php">login</a> first</div>');
}

$errors = [];
$totalPrice = calculateTotalPrice($_SESSION['cart']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout_btn'])) {
    // Ensure all fields are set to avoid undefined array key warnings
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $card_number = $_POST['card_number'] ?? '';
    $expiry_date = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    // Validation: Ensure required fields are not empty
    if (empty($fullname) || empty($email) || empty($phone) || empty($address) || empty($card_number) || empty($expiry_date) || empty($cvv)) {
        $errors[] = 'All fields are required!';
    }

    if (empty($errors)) {
        $data = [
            'user_id' => $_SESSION['id'],
            'customer_data' => "$fullname<br />$phone<br />$email<br />$address",
            'notes' => $notes,
            'total' => array_reduce($_SESSION['cart'], function ($sum, $item) {
                return $sum + ($item['qty'] * $item['price']);
            }, 0)
        ];

        // Insert order into database
        if ($crud->create('orders', $data)) {
            $order_id = $crud->getLastInsertedId(); // Get last inserted ID properly

            foreach ($_SESSION['cart'] as $item) {
                $crud->create('order_product', ['order_id' => $order_id, 'products_id' => $item['id']]);
            }

            unset($_SESSION['cart']);
            header('Location: index.php?action=checkout&status=1');
            exit();
        } else {
            $errors[] = 'Something went wrong! Please try again.';
        }
    }
}
?>

<!-- Checkout Page -->
<div class="checkout py-5">
    <div class="container">
        <h4 class="mb-4">Checkout</h4>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div class="form-group">
                <label>Fullname:</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Notes (Optional):</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <!-- Credit Card Details -->
            <div class="form-group">
                <label>Card Number:</label>
                <input type="text" name="card_number" class="form-control" required>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <label>Expiry Date:</label>
                    <input type="text" name="expiry_date" class="form-control" placeholder="MM/YY" required>
                </div>
                <div class="col-md-6">
                    <label>CVV:</label>
                    <input type="text" name="cvv" class="form-control" required>
                </div>
            </div>

            <button type="submit" name="checkout_btn" class="btn btn-primary mt-3">Pay with Credit Card</button>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>
