<?php
include '../../includes/session.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

if (isset($_POST['genreref']) && ($_POST['name'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
}

include '../../includes/INIT.php';

try {
    $sql = "UPDATE tbl_subgenre SET genreID = :genreID, subgenreName = :subgenreName WHERE subgenreID = :subgenreID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':genreID', $_POST['genreref'], PDO::PARAM_STR);
    $stmt->bindParam(':subgenreName', $name, PDO::PARAM_STR);
    $stmt->bindParam(':subgenreID', $_POST['subgenreID'], PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
if($stmt == false) {
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = "subgenre2";
}
else
{
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = false;
}
exit();