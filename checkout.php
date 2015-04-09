<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/18/13
 * Time: 3:13 PM
 */

include_once 'header2.php';
if ($loggedin && $toyCart->uniqueToys() >=1 && isset($_SESSION['street']))
{
$street = $_SESSION['street'];
$city = $_SESSION['city'];
$zip = $_SESSION['zip'];
$state = $_SESSION['state'];
$date = getdate();
$d = $date[0];


echo <<<EOD
<h1 align="center">Review your order</h1>
<h5>
<div class="container">
<div class="well">
<b>Shipping address</b><br>
$street, $city,<br>
$state, $zip<br>
</div>
</div>
<br>
<div class="container">
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><b>Shopping Cart</b></div>

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
echo "</table></div></div><br>";
$subtotal2 = number_format($subtotal, 2, '.', ',');
$shippingCost = number_format((5 + ($totalLBS * 0.75)), 2, '.', ','); // initial rate of $5 + $0.75/lb of weight
$formatted2 = number_format(($subtotal + $shippingCost), 2, '.', ',');
echo <<<EOD
<div class="container">
<div class="well">
<b>Order summary</b><br>
Items: $$subtotal2<br>
Shipping & handling: $$shippingCost<br>
<font color="red"><b>Order total = \$$formatted2</b></font></div>
</div>
</div>
EOD;

// checkout button
echo <<<_END
<div class="container">
    <form method='post' action='processing.php?user=$user'>

        <input type="hidden" name='date' value='$d'>

        <input type='submit' value='Place order' class="btn btn-warning">
    </form>
</div>

_END;
}
else
{
    echo "<h1 align=center>Access denied</h1>";
}
include_once 'footer.php';