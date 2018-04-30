<?php

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

/* Verifying with password_hash method */
if(isset($_POST['email']) && isset($_POST['password'])) {
    $thisuser = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
	$thispass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
}
include '../includes/INIT.php';
if (!isset($_SESSION)) {
    session_start();
}
try {
    $sql = "SELECT * FROM tbl_users WHERE Email = :Email";
    $result = $pdo->prepare($sql);
    $result->bindParam(":Email", $thisuser);
    $result->execute();
    $num = $result->fetch(PDO::FETCH_ASSOC);
    $hash = $num['Password'];
    if (password_verify($thispass, $hash)) {
        if ($num > 1) {
            $_SESSION['userID'] = $num['userID'];
            $_SESSION['Email'] = $thisuser;
            $_SESSION['Fullname'] = $num['Fullname'];
            $_SESSION['aLevel'] = $num['aLevel'];
        }
        if ($num['aLevel'] == '1') {
            header("location:../admin");
            $_SESSION['error'] = false;
        }
        else {
            echo "<script>window.history.go(-2);</script>";
            $_SESSION['error'] = false;
        }
    }
    else {
        header("location:../login");
        $_SESSION['error'] = "login1";
        exit();
    }
}
catch (PDOException $e) {
    header('location: /assignment2/404');
    exit();
}
