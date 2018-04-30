<?php
include '../includes/session.php';
include '../includes/header.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

foreach($_POST as $field) {
    if (isset($field) || (!empty($field))) {
        $month = filter_var($_POST['expMonth'], FILTER_SANITIZE_STRING);
        $months = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        if (!in_array($month, $months)) {
            header("location:../account.php?id=" . $thisuser . "");
            exit();
        }
        $year = filter_var($_POST['expYear'], FILTER_SANITIZE_STRING);
        $startyear = date("Y");
        $endyear = date("Y") + 19;
        $years = range($startyear, $endyear);
        if (!in_array($year, $years)) {
            header("location:../account.php?id=" . $thisuser . "");
            exit();
        }
        $expiry = $month . "/" . $year; //String
        $type = filter_var($_POST['cardType'], FILTER_SANITIZE_STRING);
        $types = array('Visa/Delta/Electron', 'Mastercard/Eurocard', 'American Express', 'Solo/Maestro', 'Maestro');
        if (!in_array($type, $types)) {
            header("location:../account.php?id=" . $thisuser . "");
            exit();
        }
        $cardNo = filter_var($_POST['cardNumber'], FILTER_SANITIZE_STRING);
        $salt = '$f/dsf/5et_fgh/dsg/_sdfgsdfdsfdsfdsf..safdsaf/_dgfsdafdsaf.///_adfga';
        $cardNo = hash('sha256', $salt.$cardNo);
        $securityNo = filter_var($_POST['securityNo'], FILTER_SANITIZE_STRING);
        $cardName = filter_var($_POST['cardName'], FILTER_SANITIZE_STRING);
    }
    else {
        echo "<script>
             window.history.go(-1);
          </script>";
        exit();
    }
}

include '../includes/INIT.php';

try {
    $sql = "INSERT into tbl_cards(userID, cardType, cardNo, securityNo, cardName, validTo) VALUES (:userID, :cardType, :cardNo, :securityNo, :cardName, :validTo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $thisuser, PDO::PARAM_STR);
    $stmt->bindParam(':cardType', $type, PDO::PARAM_STR);
    $stmt->bindParam(':cardNo', $cardNo, PDO::PARAM_STR);
    $stmt->bindParam(':securityNo', $securityNo, PDO::PARAM_STR);
    $stmt->bindParam(':cardName', $cardName, PDO::PARAM_STR);
    $stmt->bindParam(':validTo', $expiry, PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
if($stmt == false) {
    echo '<script>alert("Your card was not added.");</script>';
    exit();
}
else
{
    header('location:../account?userid=' . $thisuser . '');
}
exit();
