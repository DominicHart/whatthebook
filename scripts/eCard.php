<?php
include '../includes/session.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

foreach($_POST as $field) {
    if (isset($field)) {
        $month = $_POST['expMonth'];
        $months = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        if (!in_array($month, $months)) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eCard1";
            exit();
        }
        $year = $_POST['expYear'];
        $startyear = date("Y");
        $endyear = date("Y") + 19;
        $years = range($startyear, $endyear);
        if (!in_array($year, $years)) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eCard2";
            exit();
        }
        $expiry = $month . "/" . $year; //String
        $type = $_POST['cardType'];
        $types = array('Visa/Delta/Electron', 'Mastercard/Eurocard', 'American Express', 'Solo/Maestro', 'Maestro');
        if (!in_array($type, $types)) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eCard3";
            exit();
        }
        $cardNo = filter_var($_POST['cardNumber'], FILTER_SANITIZE_STRING);
        $salt = '$f/dsf/5et_fgh/dsg/_sdfgsdfdsfdsfdsf..safdsaf/_dgfsdafdsaf.///_adfga';
        $cardNo = hash('sha256', $salt.$cardNo);
        $securityNo = filter_var($_POST['securityNo'], FILTER_SANITIZE_STRING);
        $cardName = filter_var($_POST['cardName'], FILTER_SANITIZE_STRING);
        $cardID = filter_var($_POST['cardID'], FILTER_SANITIZE_STRING);
    }
}
include '../includes/INIT.php';
try {
    if (!empty($cardNo)) {
        $sql = "UPDATE tbl_cards SET cardType = :cardType, cardNo = :cardNo, securityNo = :securityNo, cardName = :cardName, validTo = :validTo WHERE cardID = :cardID AND userID = :userID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":cardType", $type, PDO::PARAM_STR);
        $stmt->bindParam(':cardNo', $cardNo, PDO::PARAM_STR);
        $stmt->bindParam(':securityNo', $securityNo, PDO::PARAM_STR);
        $stmt->bindParam(":cardName", $cardName, PDO::PARAM_STR);
        $stmt->bindParam(":validTo", $expiry, PDO::PARAM_STR);
        $stmt->bindParam(":cardID", $cardID, PDO::PARAM_STR);
        $stmt->bindParam(":userID", $thisuser, PDO::PARAM_STR);
        $stmt->execute();
    }
    else {
        $sql = "UPDATE tbl_cards SET cardType = :cardType, securityNo = :securityNo, cardName = :cardName, validTo = :validTo WHERE cardID = :cardID AND userID = :userID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":cardType", $type, PDO::PARAM_STR);
        $stmt->bindParam(':securityNo', $securityNo, PDO::PARAM_STR);
        $stmt->bindParam(":cardName", $cardName, PDO::PARAM_STR);
        $stmt->bindParam(":validTo", $expiry, PDO::PARAM_STR);
        $stmt->bindParam(":cardID", $cardID, PDO::PARAM_STR);
        $stmt->bindParam(":userID", $thisuser, PDO::PARAM_STR);
        $stmt->execute();
    }
}
catch(PDOException $e) {
    header('location: /assignment2/404');
    exit();
}
if($stmt == false) {
    echo '<script>alert("Your card was not edited.");</script>';
    exit();
}
else
{
    header('location:../account?userid=' . $thisuser . '');
    $_SESSION['error'] = false;
}
exit();