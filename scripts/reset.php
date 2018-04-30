<?php
include '../includes/session.php';

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

if (isset($_SESSION['error'])) {
    echo "<script>
             window.history.go(-1);
          </script>";
    $_SESSION['error'] = false;
    exit();
}
