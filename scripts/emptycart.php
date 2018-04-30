<?php
include '../includes/session.php';
include '../includes/INIT.PHP';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

try {
    $sql = "DELETE FROM tbl_cart WHERE userID = :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $thisuser, PDO::PARAM_INT);
    $stmt->execute();

}
catch(PDOException $e) {
    header('location: /assignment2/404');
    exit();
}
if($stmt == false) {
    echo '<script>alert("Your cart could not be emptied.");</script>';
}
else
{
    header('location:../cart');
}
exit();