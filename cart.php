<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/17/13
 * Time: 2:51 PM
 */

$cartActive = 'class="active"';

include 'header.php';



echo <<<EOD
<h1>Toys In Your Cart</h1>
<h5>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Shopping Cart (*Type a number and press ENTER to update Quantity)</div>

    <!-- Table -->
    <table class="table">
    <tr>
        <td>#</td>
        <td>Toy</td>
        <td>Price</td>
        <td>Quantity</td>

    </tr>
EOD;
$formatted2 = 0;
$n = 0;
$toy = $toyCart->getToyName();
$quantity = $toyCart->getToyQuantity();
$price = $toyCart->getToyPrice();
$discount = $toyCart->getToyDiscount();
$finalPrice = 0;
$subtotal = 0;
for ($j = 0; $j < $toyCart->uniqueToys(); $j++)
{
$toynumber = $n;
$n++;
$finalPrice = ($price[$j] * $discount[$j]);
$subtotal += ($finalPrice * $quantity[$j]);
$formatted = number_format($finalPrice, 2, '.', ',');
$formatted2 = number_format($subtotal, 2, '.', ',');
echo <<<EOD
<tr>
    <td>$n</td>
    <td>$toy[$j]</td>
    <td>\$$formatted</td>
    <td><form role="form" method='post' action='cart.php'>

            <input type="number" class="form-control" min ='0' max='1000' name='quantity' value='$quantity[$j]'/>
            <input type="hidden" name="toynumber" value="$toynumber" />
           <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>

        </form>
    </td>
</tr>
EOD;
}
echo "</table></div><br>";

echo <<<EOD
<div class="well">Subtotal = $$formatted2</div>
<br>
EOD;

if ($loggedin && $size >=1)
{
echo <<<EOD
<a class="btn btn-warning" href="shipping.php?user=$user">Proceed to checkout</a>

EOD;
}
elseif ($loggedin && $size == 0)
{}
else
{
echo <<<EOD
<a class="btn btn-warning" href="login.php">Please login to checkout</a>
EOD;
}

echo "</h5>";
include 'footer.php';