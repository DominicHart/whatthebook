<?php
include '../includes/session.php';
include '../includes/INIT.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

try {
    $item = filter_var(($_POST['bookID']), FILTER_SANITIZE_STRING);
    $sql = "DELETE FROM tbl_cart WHERE bookID = :bookID AND userID = :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":bookID", $item, PDO::PARAM_STR);
    $stmt->bindParam(":userID", $thisuser, PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    header('location: /assignment2/404');
    exit();
}
if($stmt == false) {
    echo '<script>alert("Item not deleted from cart");</script>';
}
else
{
    header('location:../cart');
}
exit();