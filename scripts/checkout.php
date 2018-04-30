<?php
include '../includes/session.php';
include '../includes/INIT.PHP';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

if (isset($_POST['Total']) || (!empty($_POST['Total']))) {
    $Total = filter_var($_POST['Total'], FILTER_SANITIZE_STRING);
}

$carts = array();
$books = array();
$quantity = array();

try {
    $sql = 'SELECT * FROM tbl_cart WHERE userID = :userID';
    $result = $pdo->prepare($sql);
    $result->bindParam(':userID', $thisuser, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching cart; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $carts[] = array('ID' => $row['bookID'], 'Quantity' => $row['Quantity'], 'User' => $row['userID']);
}


foreach ($carts as $cart):
    //For all records found, add the books to an array
    array_push($books, $cart['ID']);
    //For all records found, add the quantities to an array
    array_push($quantity, $cart['Quantity']);
endforeach;

//Convert the arrays to strings to add to the db
$booklist =  implode(", ",$books);
$allquantity =  implode(", ",$quantity);

try {
    $sql = 'INSERT INTO tbl_orders (bookID, Quantity, userID, Total) VALUES (:bookID, :Quantity, :userID, :Total)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':bookID', $booklist, PDO::PARAM_STR);
    $stmt->bindParam(':Quantity', $allquantity, PDO::PARAM_STR);
    $stmt->bindParam(':userID', $thisuser, PDO::PARAM_STR);
    $stmt->bindParam(':Total', $Total, PDO::PARAM_STR);
    $stmt->execute();
} catch (PDOException $e) {
    header('location: /assignment2/404');
    exit();
}
try {
    $sql = "DELETE FROM tbl_cart WHERE userID = :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userID", $thisuser, PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    header('location: /assignment2/404');
    exit();
}
if($stmt == false) {
    header('location:../cart');
    $_SESSION['error'] = "payment1";
}
else
{
    header('location:../cart');
    $_SESSION['error'] = "payment2";
}
exit();