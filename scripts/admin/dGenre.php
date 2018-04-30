<?php
include '../../includes/session.php';
include '../../includes/INIT.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

try {
    $sql = "DELETE FROM tbl_genre WHERE GenreID = :genreID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":genreID", $_POST['genreID'], PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
try {
    $sql = "DELETE FROM tbl_subgenre WHERE genreID = :genreID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":genreID", $_POST['genreID'], PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
if($stmt == false) {
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = "genre3";
}
else
{
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = false;
}
exit();