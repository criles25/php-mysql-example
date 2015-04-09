<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/18/13
 * Time: 9:21 PM
 */
include_once 'header2.php';

if (isset($_POST['date']))
{
    $date = sanitizeString($_POST['date']);
    $street = $_SESSION['street'];
    $city = $_SESSION['city'];
    $zip = $_SESSION['zip'];
    $state = $_SESSION['state'];
    $toys = $toyCart->getToys();
    $quantities = $toyCart->getToyQuantity();

    $query = "INSERT INTO orders VALUES('null', '$date', 'null', '$street', '$city', '$zip', '$state')";
    queryMysql($query);
    $orderID = mysql_insert_id();

    $query = "INSERT INTO place VALUES('$user', '$orderID')";
    queryMysql($query);

    $size = count($toys);
    for ($j = 0; $j < $size; $j++) {
        $toygameID = $toys[$j];
        $quantity = $quantities[$j];
        $query = "INSERT INTO contains VALUES('$orderID', '$toygameID', '$quantity')";
        queryMysql($query);
    }





    echo <<<EOD
<h1 align="center">Your order has been placed!</h1><br>
<div class="container">
    <div class="well">
    <h4>Please do not hit refresh on this page! Unless you want your order ordered multiple times (but seriously please don't hit refresh)!</h4><h5>

        <b>Order details:</b><br />
        Order ID: <br>
        $orderID<br><br>
        Shipping address:<br>
        $street <br>
        $city, $state $zip<br><br>

        <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><b>Toys</b></div>

    <!-- Table -->
    <table class="table">
    <tr>
        <td>#</td>
        <td>Toy</td>
        <td>Price</td>
        <td>Quantity</td>
    </tr>
EOD;

    $n = 0;
    $toy = $toyCart->getToyName();
    $quantity = $toyCart->getToyQuantity();
    $price = $toyCart->getToyPrice();
    $discount = $toyCart->getToyDiscount();
    $weight = $toyCart->getWeight();
    $finalPrice = 0;
    $subtotal = 0;
    $totalLBS = 0;

    for ($j = 0; $j < $toyCart->uniqueToys(); $j++)
    {
        $n++;
        $finalPrice = ($price[$j] * $discount[$j]);
        $subtotal += ($finalPrice * $quantity[$j]);
        $formatted = number_format($finalPrice, 2, '.', ',');
        $totalLBS += $weight[$j];

        echo <<<EOD
<tr>
    <td>$n</td>
    <td>$toy[$j]</td>
    <td>\$$formatted</td>
    <td>$quantity[$j]</td>
</tr>
EOD;
    }
    echo "</table></div><br>";
    $subtotal2 = number_format($subtotal, 2, '.', ',');
    $shippingCost = number_format((5 + ($totalLBS * 0.75)), 2, '.', ','); // initial rate of $5 + $0.75/lb of weight
    $formatted2 = number_format(($subtotal + $shippingCost), 2, '.', ',');
    echo <<<EOD


Items: $$subtotal2<br>
Shipping & handling: $$shippingCost<br>
<font color="red"><b>Order total = \$$formatted2</b></font>
</div>
</div>

    <div class="container">
    <a class="btn btn-warning" href=account.php?user=$user>Return to your account</a></h5>
</div>
EOD;

    $_SESSION['cart'] = new Cart;
    $_SESSION['state'] = "";
    $_SESSION['city'] = "";
    $_SESSION['street'] = "";
    $_SESSION['zip'] = "";
}
else
{
    echo "<h1 align=center>Access denied</h1>";
}
include_once 'footer.php';