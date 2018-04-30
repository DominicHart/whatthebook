<?php

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

session_start();

//define variables
if (isset($_SESSION['userID']))
{
    $username = $_SESSION['Email'];
    $thisuser = $_SESSION['userID'];
    $fullname = $_SESSION['Fullname'];
    $aLevel = $_SESSION['aLevel'];
    if (!isset($_SESSION['error'])) {
        $_SESSION['error'] = false;
    }
}
