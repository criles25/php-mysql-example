<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/15/13
 * Time: 2:17 PM
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

// fill shopping cart with new toy
if(isset($_POST['toy'])) {
    $toy = sanitizeString($_POST['toy']);
    $quantity = sanitizeString($_POST['quantity']);
    $name = sanitizeString($_POST['toyName']);
    $price = sanitizeString($_POST['price']);
    $discount = sanitizeString($_POST['discount']);
    $weight = sanitizeString($_POST['weight']);
    $toyCart->addToCart($toy, $quantity, $name, $price, $discount, $weight);
    $_SESSION['cart'] = $toyCart;
}

// update quantity of toy in cart
if (isset($_POST['toynumber']))
{
    $toynumber = sanitizeString($_POST['toynumber']);
    $quantity = sanitizeString($_POST['quantity']);
    if ($quantity == 0)
    {
        $toyCart->removeToy($toynumber);
        $_SESSION['cart'] = $toyCart;
    }
    else
    {
        $toyCart->updateQuantity($toynumber, $quantity);
        $_SESSION['cart'] = $toyCart;
    }
}

// cart size
$size = $toyCart->cartSize();

// login user
$userstr = '(Guest)';
$userType = 0;
if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "($user)";
    $query = "SELECT userType FROM users WHERE user = '$user'";
    $result = queryMysql($query);
    $row = mysql_fetch_row($result);
    $userType = $row[0];
}
else $loggedin = FALSE;

// setup active page
if (!isset($aboutActive))
    $aboutActive = "";
if (!isset($accountActive))
    $accountActive = "";
if (!isset($cartActive))
    $cartActive = "";
if (!isset($contactActive))
    $contactActive = "";
if (!isset($homeActive))
    $homeActive = "";
if (!isset($loginActive))
    $loginActive = "";
if (!isset($logoutActive))
    $logoutActive = "";
if (!isset($ordersActive))
    $ordersActive = "";
if (!isset($setupActive))
    $setupActive = "";
if (!isset($signupActive))
    $signupActive = "";
if (!isset($toysActive))
    $toysActive = "";
if (!isset($updateActive))
    $updateActive = "";
if (!isset($shipActive))
    $shipActive = "";
if (!isset($ordersActive))
    $ordersActive = "";

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



if ($loggedin)
{
if ($userType == 0) {
echo <<<EOD
    <body>
            <div class="navbar navbar-default navbar-fixed-top" role="navigation">

                <div class="container">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">$appname</a>
                    </div>

                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li $homeActive><a href="home.php">Home</a></li>
                            <li $aboutActive><a href="about.php">About</a></li>
                            <li $contactActive><a href="contact.php">Contact</a></li>
                            <li $toysActive><a href="toys.php">Toys</a></li>

                            <li class="dropdown" $accountActive>
                                <a href="account.php?user=$userstr" class="dropdown-toggle" data-toggle="dropdown">Your Account <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li $accountActive><a href="account.php?user=$userstr">Your Account</a></li>

                                    <li $ordersActive><a href="orders.php">Orders</a></li>
                                    <li class="divider"></li>
                                    <li $logoutActive><a href="logout.php">Not $user? Log Out</a></li>
                                </ul>

                        </ul>
                        <div class="col-sm-3 col-md-3">
                            <form class="navbar-form" role="search" action="search.php" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search toys" name="searchTerm" id="searchTerm">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                            </form>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li $cartActive><a href="cart.php?user=$userstr"><span class="glyphicon glyphicon-shopping-cart"></span> Your Cart <span class="badge">$size</span></a></li>
                        </ul>
                    </div><!--/.nav-collapse -->

                </div>
            </div>
            <br>
            <div class="container">
                <div class="jumbotron">
EOD;
}
if ($userType == 1 || $userType == 2)
{
    echo <<<EOD
    <body>


            <div class="navbar navbar-default navbar-fixed-top" role="navigation">

                <div class="container">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">$appname</a>

                    </div>

                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">

                            <li $homeActive><a href="home.php">Home</a></li>
                            <li $aboutActive><a href="about.php">About</a></li>
                            <li $contactActive><a href="contact.php">Contact</a></li>
                            <li $toysActive><a href="toys.php">Toys</a></li>

                            <li class="dropdown" $accountActive>
                                <a href="account.php?user=$userstr" data-toggle="dropdown" class="dropdown-toggle">Your Account <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li $accountActive><a href="account.php?user=$userstr">Your Account</a></li>

                                    <li $ordersActive><a href="orders.php">Orders</a></li>
                                    <li class="divider"></li>
                                    <li $logoutActive><a href="logout.php">Not $user? Log Out</a></li>
                                </ul>
                            </li>


                            <li $updateActive><a href="update.php">Update</a></li>
                            <li $shipActive><a href="ship.php">Ship</a></li>



                        </ul>
                        <div class="col-sm-3 col-md-3">
                            <form class="navbar-form" role="search" action="search.php" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search toys" name="searchTerm" id="searchTerm">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                            </form>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li $cartActive><a href="cart.php?user=$userstr"><span class="glyphicon glyphicon-shopping-cart"></span> Your Cart <span class="badge">$size</span></a></li>
                        </ul>
                    </div><!--/.nav-collapse -->

                </div>
            </div>
            <br>
            <div class="container">
                <div class="jumbotron">
EOD;
}
}
else
{
echo <<<_END
    <body>
            <div class="navbar navbar-default navbar-fixed-top" role="navigation">

                <div class="container">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">$appname</a>
                    </div>

                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li $homeActive><a href="home.php">Home</a></li>
                            <li $aboutActive><a href="about.php">About</a></li>
                            <li $contactActive><a href="contact.php">Contact</a></li>
                            <li $toysActive><a href="toys.php">Toys</a></li>
                            <li $signupActive><a href="signup.php">Sign Up</a></li>
                            <li $loginActive><a href="login.php">Log In</a></li>
                        </ul>
                        <div class="col-sm-3 col-md-3">
                            <form class="navbar-form" role="search" action="search.php" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search toys" name="searchTerm" id="searchTerm">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li $cartActive><a href="cart.php?user=$userstr"><span class="glyphicon glyphicon-shopping-cart"></span> Your Cart <span class="badge">$size</span></a></li>
                        </ul>
                    </div><!--/.nav-collapse -->

                </div>
            </div>
            <br>
            <div class="container">
                <div class="jumbotron">
_END;
}
?>