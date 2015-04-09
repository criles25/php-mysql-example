<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/18/13
 * Time: 3:24 PM
 */
include 'functions.php';

session_start();

// create shopping cart
if (isset($_SESSION['cart']))
    $toyCart = $_SESSION['cart'];
else {
    $toyCart = new Cart;
    $_SESSION['cart'] = $toyCart;
}

// login user
$userstr = '(Guest)';
if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "($user)";
}
else $loggedin = FALSE;

echo <<<_END
<!DOCTYPE html>

    <head>

        <link rel="shortcut icon" href="favicon.png">

        <title>$appname</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/navbar-fixed-top.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>
_END;

?>