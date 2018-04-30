<?php
include '../../includes/session.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

foreach($_POST as $field) {
    if (isset($field)) {
        $name = filter_var($_POST['genrename'], FILTER_SANITIZE_STRING);
    }
}

include '../../includes/INIT.php';

try {
    $userCheck = "SELECT GenreName FROM tbl_genre WHERE GenreName = '$name'";
    $result = $pdo->query($userCheck);
    $result->execute();
    $rowCount = $result->fetch(PDO::FETCH_ASSOC);

    //If there is a match show an error

    if ($rowCount > 1) {
        header("location:....//admin.php");
        $_SESSION['error'] = "genre1";
        exit();
    }
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
try {
    $sql = "INSERT into tbl_genre(GenreName) VALUES (:GenreName)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':GenreName', $name, PDO::PARAM_STR);
    $stmt->execute();
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
if($stmt == false) {
    echo '<a href="../../admin.php">Error cannot execute query</a>';
}
else
{
    header('location:../../admin.php');
}
exit();