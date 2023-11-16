<?php
// Start or resume the session
session_start();

// Check if product_name is set in the POST request
if (isset($_POST['product_name'])) {
    $productName = $_POST['product_name'];

    // Initialize the cart session variable if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the product to the cart or increment quantity if already in the cart
    if (isset($_SESSION['cart'][$productName])) {
        $_SESSION['cart'][$productName]['quantity']++;
    } else {
        $_SESSION['cart'][$productName] = ['quantity' => 1];
    }

    // Store the cart data in a cookie
    setcookie('cart', json_encode($_SESSION['cart']), time() + (86400 * 30), "/"); // 86400 = 1 day

    // Redirect back to the product listing page
    header('Location: index.php');
    exit();
} else {
    // Redirect to the product listing page if product_name is not set
    header('Location: index.php');
    exit();
}
?>


<?php
// Start or resume the session
session_start();

// Check if the cart session variable is set
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo '<h1>Shopping Cart</h1>';
    echo '<table>';
    echo '<tr><th>Product</th><th>Quantity</th></tr>';

    foreach ($_SESSION['cart'] as $productId => $item) {
        echo '<tr>';
        echo '<td>' . $productId . '</td>';
        echo '<td>' . $item['quantity'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p>Your cart is empty.</p>';
}
?>
