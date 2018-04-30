<?php

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

include '../includes/session.php';

//Loop through variables to check if they have been set
foreach($_POST as $field) {
    if (isset($field)) {
        //Filter input
        $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email1'], FILTER_SANITIZE_STRING);
        $email2 = filter_var($_POST['email2'], FILTER_SANITIZE_STRING);
        $newpass = filter_var($_POST['password1'], FILTER_SANITIZE_STRING);
        $newpass2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
        $address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
        $town = filter_var($_POST['town'], FILTER_SANITIZE_STRING);
        $postcode = filter_var($_POST['postcode'], FILTER_SANITIZE_STRING);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $alevel = 0;
        //Password requirements
        $cUppercase = preg_match('@[A-Z]@', $newpass);
        $cLowercase = preg_match('@[a-z]@', $newpass);
        $cNumber = preg_match('@[0-9]@', $newpass);
        //Check passwords match
        if ($newpass != $newpass2) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "reg1";
            exit();
        }
        //Check passwords meet requirements
        if(!$cUppercase) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "reg2";
            exit();
        }
        if (!$cLowercase) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "reg3";
            exit();
        }
        if (!$cNumber) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "reg4";
            exit();
        }
        if (strlen($newpass) < 8) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "reg5";
            exit();
        }
        //Check email addresses match
        if ($email != $email2) {
            header("location:../account.php?id=" . $thisuser . "");
            $_SESSION['error'] = "reg6";
            exit();
        }
        if ($alevel != 0) {
            exit();
        }
        //Hash the password
        $newpass = password_hash($newpass, PASSWORD_BCRYPT);
    }
}
include '../includes/INIT.php';

//Select existing email addresses from the database and check for a match
try {
    $userCheck = "SELECT Email FROM tbl_users WHERE Email = '$email'";
    $result = $pdo->query($userCheck);
    $result->execute();
    $rowCount = $result->fetch(PDO::FETCH_ASSOC);

    //If there is a match show an error

    if ($rowCount > 1) {
        header("location:../account.php?id=" . $thisuser . "");
        $_SESSION['error'] = "reg7";
        exit();
    }
}
catch(PDOException $e) {
    header('location: /assignment2/404.php');
    exit();
}
//Insert the record into the database
try {
    $sql = "INSERT into tbl_users(Fullname, Email, Password, Address1, Town, Postcode, City, Country, aLevel) VALUES (:Fullname, :Email, :Password, :Address1, :Town, :Postcode, :City, :Country, :aLevel)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':Fullname', $fullname, PDO::PARAM_STR);
    $stmt->bindParam(':Email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':Password', $newpass, PDO::PARAM_STR);
    $stmt->bindParam(':Address1', $address1, PDO::PARAM_STR);
    $stmt->bindParam(':Town', $town, PDO::PARAM_STR);
    $stmt->bindParam(':Postcode', $postcode, PDO::PARAM_STR);
    $stmt->bindParam(':City', $city, PDO::PARAM_STR);
    $stmt->bindParam(':Country', $country, PDO::PARAM_STR);
    $stmt->bindParam(':aLevel', $alevel, PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
if($stmt == false) {
    header("location:../login");
    $_SESSION['error'] = "reg7";
    exit();
}
else
{
    header('location:../index');
}
exit();

