<?php
include '../../includes/session.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

foreach($_POST as $field) {
    if (isset($field)) {
        $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        $town = filter_var($_POST['town'], FILTER_SANITIZE_STRING);
        $postcode = filter_var($_POST['postcode'], FILTER_SANITIZE_STRING);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $pass1 = filter_var($_POST['password1'], FILTER_SANITIZE_STRING);
        $pass2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
        $aLevel = filter_var($_POST['level'], FILTER_SANITIZE_STRING);
        $thisaccount = filter_var($_POST['userID'], FILTER_SANITIZE_STRING);
    }
}

include '../../includes/INIT.php';

try {
    if (!empty($pass1) && !empty($pass2)) {
        $cUppercase = preg_match('@[A-Z]@', $pass1);
        $cLowercase = preg_match('@[a-z]@', $pass1);
        $cNumber = preg_match('@[0-9]@', $pass1);
        if ($pass1 != $pass2) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eUser1";
            exit();
        }
        //Check passwords meet requirements
        if (!$cUppercase) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eUser2";
            exit();
        }
        if (!$cLowercase) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eUser3";
            exit();
        }
        if (!$cNumber) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eUser4";
            exit();
        }
        if (strlen($pass1) < 8) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "eUser5";
            exit();
        }
        $pass1 = password_hash($pass1, PASSWORD_BCRYPT);
        $sql = "UPDATE tbl_users SET Fullname = :Fullname, Password = :Password, Address1 = :Address1, Town = :Town, Postcode = :Postcode, City = :City, Country = :Country, aLevel = :aLevel WHERE userID = :userID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':Fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':Password', $pass1, PDO::PARAM_STR);
        $stmt->bindParam(':Address1', $address, PDO::PARAM_STR);
        $stmt->bindParam(':Town', $town, PDO::PARAM_STR);
        $stmt->bindParam(':Postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindParam(':City', $city, PDO::PARAM_STR);
        $stmt->bindParam(':Country', $country, PDO::PARAM_STR);
        $stmt->bindParam(':aLevel', $aLevel, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $thisaccount, PDO::PARAM_STR);
        $stmt->execute();
    }
    else {
        $sql = "UPDATE tbl_users SET Fullname = :Fullname, Address1 = :Address1, Town = :Town, Postcode = :Postcode, City = :City, Country = :Country, aLevel = :aLevel WHERE userID = :userID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':Fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':Address1', $address, PDO::PARAM_STR);
        $stmt->bindParam(':Town', $town, PDO::PARAM_STR);
        $stmt->bindParam(':Postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindParam(':City', $city, PDO::PARAM_STR);
        $stmt->bindParam(':Country', $country, PDO::PARAM_STR);
        $stmt->bindParam(':aLevel', $aLevel, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $thisaccount, PDO::PARAM_STR);
        $stmt->execute();
    }
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
if($stmt == false) {
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = "euserAdmin";
}
else
{
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = false;
}
exit();