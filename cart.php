<?php
include 'includes/session.php';
include 'includes/header.php';
include 'includes/INIT.php';

$carts = array();
$thisaccount = $thisuser;

try {
    $sql = 'SELECT * FROM tbl_cart JOIN tbl_mybooks ON tbl_cart.bookID = tbl_mybooks.stockID WHERE tbl_cart.userID = :userID';
    $result = $pdo->prepare($sql);
    $result->bindParam(':userID', $thisuser, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching cart; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $carts[] = array('ID' => $row['bookID'], 'Quantity' => $row['Quantity'], 'title' => $row['title'], 'Year' => $row['year'], 'Price' => $row['unitPrice']);
}
if (isset($_SESSION['userID']))
{
    if ($thisuser != $thisaccount) {
        header('location:cart.php?userid=' . $thisuser . '');
    }
}
else  {
    header('location:login.php');
}

include 'includes/nav.php';
?>
<div class="container-fluid">
    <div class="row cart">
        <div class="col-md-8 col-md-offset-2">
            <h2>Your Cart</h2>
            <?php
                $subtotal = 0;
                $shipping = 0;
                $VAT = 0.2;
            ?>
            <div class="items">
                <?php
                if (empty($carts)) {
                    if (isset($_SESSION['error'])) {
                        if ($_SESSION['error'] == "payment1") {
                            echo "<p class='payerror'>Your payment was not processed, please <a href='scripts/reset.php'>try again.</a></p>";
                        } else if ($_SESSION['error'] == "payment2") {
                            echo "<p class='payment text-success'>Your payment has been processed and your order placed. <a href='books.php'>Continue shopping.</a></p>";
                        }
                    }
                    echo "<h3 class='none'>There are no items in your cart. <a href=books.php>Begin shopping.</a></h3>";
                }
                else {
                    echo "<h3>Item Quantity <b class='pull-right'>Price</b></h3>";
                    foreach ($carts as $cart):
                        $price = $cart['Price'];
                        if ($cart['Quantity'] > 1) {
                            $price = $price * $cart['Quantity'];
                        }
                        echo "<div class='book'><form action='scripts/deleteitem.php' method='post'><input type='hidden' value='" . $cart['ID'] . "' name='bookID'><button type='submit' name='submit' class='remove'>(Remove)</button></form>&nbsp;<a href='book.php?id=" . $cart['ID'] . "'>" . $cart['title'] . "</a>&nbsp;<b>x" . $cart['Quantity'] . "</b><b class='pull-right'>£" . $price . "</b></div>";
                            $subtotal += $price;
                    endforeach;
                }
                ?>
            </div>
            <div class="cost">
                <?php
                if (!empty($carts)) {
                    if ($subtotal > 49) {
                        $shipping = 0;
                    }
                    else {
                        $shipping = 2;
                    }
                    //$PreVAT = $subtotal + $shipping;
                    $ThisVAT = $subtotal * $VAT;
                    echo "<h3>Total <b class='pull-right'>Including</b></h3>";
                    echo "<p>Subtotal: <b class='pull-right'>£" . number_format((float)$subtotal, 2, '.', '') . "</b></p>"
                            . "<p>Shipping: <b class='pull-right'>£" . number_format((float)$shipping, 2, '.', '') . "</b></p>"
                            . "<p>VAT: <b class='pull-right'>£" . number_format((float)$ThisVAT, 2, '.', '') . "</b></p>";
                    $Total = $subtotal + $shipping;
                    $NewTotal = number_format((float)$Total, 2, '.', '');
                    echo "<p class='total'>Total: <b class='pull-right'>£" . $NewTotal . "</b>";
                    echo "<div class='clearfix'><form method='post' action='scripts/emptycart.php'><button type='submit' name='submit'>Empty Cart</button></form><form action='scripts/checkout.php' method='post'><input type='hidden' name='Total' value='" . $NewTotal . "'><button type='submit' name='submit'>Checkout</button></form></div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>

