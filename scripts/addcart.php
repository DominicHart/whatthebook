<?php
include '../includes/session.php';
include '../includes/INIT.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

if (!isset($_SESSION['userID']))
{
    header('location:../login.php');
}
try {
    $book = filter_var(($_GET['id']), FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM tbl_cart WHERE bookID = '$book' AND userID = '$thisuser'";
    $result = $pdo->query($sql);
    $result->execute();
    $rowCount = $result->fetch(PDO::FETCH_ASSOC);

    //If there is a match show an error

    if ($rowCount > 1) {
        try {
            $book = filter_var(($_GET['id']), FILTER_SANITIZE_STRING);
            $sql = "UPDATE tbl_cart SET Quantity = Quantity + 1 WHERE bookID = :bookID AND userID = :userID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':bookID', $book, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $thisuser, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(PDOException $e) {
            header('location: /assignment2/404.php');
            exit();
        }
        if($stmt == false) {
            echo '<script>alert("Your item/s could not be added to the cart.");</script>';
        }
        else
        {
            header('location:../cart.php?userid=' . $thisuser .'');
        }
    }
    else {
        try {
            $book = filter_var(($_GET['id']), FILTER_SANITIZE_STRING);
            $quantity = 1;
            $sql = "INSERT INTO tbl_cart(bookID, Quantity, userID) VALUES (:bookID, :Quantity, :userID)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':bookID', $book, PDO::PARAM_STR);
            $stmt->bindParam(':Quantity', $quantity, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $thisuser, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(PDOException $e) {
            header('location: /assignment2/404.php');
            exit();
        }
        if($stmt == false) {
            echo '<script>alert("Your item/s could not be added to the cart.");</script>';
        }
        else
        {
            header('location:../cart.php?userid=' . $thisuser .'');
            $_SESSION['error'] = false;
        }
    }
}
catch(PDOException $e) {
    eader('location: /assignment2/404.php');
    exit();
}