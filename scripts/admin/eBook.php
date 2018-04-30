<?php

include '../../includes/session.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

foreach($_POST as $field) {
    if (isset($field)) {
        $author = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        $month = filter_var($_POST['month'], FILTER_SANITIZE_STRING);
        $year = filter_var($_POST['year'], FILTER_SANITIZE_STRING);
        $publisher = filter_var($_POST['pubref'], FILTER_SANITIZE_STRING);
        $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
        $subgenre = filter_var($_POST['subref'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
    }
}

try {
    if(isset($_FILES['bookImage'])){
        $file = $_FILES['bookImage'];

        //file properties
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // find out file extension
        $file_extension = explode('.', $file_name);
        $file_extension = strtolower(end($file_extension));

        //set allowed file types array
        $allowed = array('png', 'jpg', 'jpeg', 'gif');

        //check file extension is valid
        if(in_array($file_extension, $allowed)){
            //check file has no errors
            if($file_error ===0){
                //check file size is not too large
                if($file_size <= 2097152) {
                    //generate unique file name
                    $file_name_new = uniqid('', true) . '.' . $file_extension;
                    //set file storage destination
                    $file_destination = '../images/books/' . $file_name_new;
                    //move file to new location
                    move_uploaded_file($file_tmp, $file_destination);
                }
            }
        }
    }
}
catch (Exception $e) {
    echo "Something went wrong";
}
include '../../includes/INIT.php';


try {
    if (empty($_FILES['bookImage']) || (!isset($_POST['bookImage']))) {
        $sql = "UPDATE tbl_mybooks SET author = :author, title = :title, month = :month, year = :year, publisherID = :publisherID, type = :type, subgenreID = :subgenreID, description = :description, quantity = :quantity, unitPrice = :unitPrice WHERE stockID = :stockID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_STR);
        $stmt->bindParam(':publisherID', $publisher, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':subgenreID', $subgenre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_STR);
        $stmt->bindParam(':unitPrice', $price, PDO::PARAM_STR);
        $stmt->bindParam(':stockID', $_POST['bookID'], PDO::PARAM_STR);
        $stmt->execute();
    }
    else {
        $sql = "UPDATE tbl_mybooks SET author = :author, title = :title, month = :month, year = :year, publisherID = :publisherID, type = :type, subgenreID = :subgenreID, description = :description, quantity = :quantity, unitPrice = :unitPrice, image = :image WHERE stockID = :stockID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_STR);
        $stmt->bindParam(':publisherID', $publisher, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':subgenreID', $subgenre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_STR);
        $stmt->bindParam(':unitPrice', $price, PDO::PARAM_STR);
        $stmt->bindParam(':image', $file_name_new, PDO::PARAM_STR);
        $stmt->bindParam(':stockID', $_POST['bookID'], PDO::PARAM_STR);
        $stmt->execute();
    }
}
catch(PDOException $e) {
    echo "Error !: " . $e->getMessage() . "<br>";
    exit();
}
if($stmt == false) {
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = "book2";
}
else
{
    echo "<script>window.history.go(-1);</script>";
    $_SESSION['error'] = false;
}
exit();