<?php
include '../../includes/session.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

foreach($_POST as $field) {
    if (isset($field)) {
        $genre = filter_var($_POST['genreref'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['subgenrename'], FILTER_SANITIZE_STRING);

    }
}

include '../../includes/INIT.php';

try {
    $userCheck = "SELECT subgenreName FROM tbl_subgenre WHERE subgenreName = '$name'";
    $result = $pdo->query($userCheck);
    $result->execute();
    $rowCount = $result->fetch(PDO::FETCH_ASSOC);

    //If there is a match show an error

    if ($rowCount > 1) {
        header('location:../../admin.php');
        $_SESSION['error'] = "subgenre1";
        exit();
    }
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
try {
    $sql = "INSERT into tbl_subgenre(genreID, subgenreName) VALUES (:genreID, :subgenreName)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':genreID', $genre, PDO::PARAM_STR);
    $stmt->bindParam(':subgenreName', $name, PDO::PARAM_STR);
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