<?php
include '../includes/session.php';
include '../includes/INIT.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

try {
    $sql = "DELETE FROM tbl_cards WHERE cardID = :cardID AND userID = :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":cardID", $_POST['cardID'], PDO::PARAM_STR);
    $stmt->bindParam(":userID", $thisuser, PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    header('location: /assignment2/404');
    exit();
}
if($stmt == false) {
    echo '<script>alert("Your card was not deleted.");</script>';
}
else
{
    header('location:../account?userid=' . $thisuser . '');
}
exit();