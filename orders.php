<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/23/13
 * Time: 8:38 PM
 */

$ordersActive = 'class="active"';

include 'header.php';

if ($loggedin)
{
    echo <<<EOD
    <h1>Your Orders</h1>
<h5>
<div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Orders</div>

        <!-- Table -->
        <table class="table">
        <tr>
            <td>Order ID</td>
            <td>Order date</td>
            <td>Shipping Address</td>
            <td>Toys</td>
            <td>Subtotal</td>
            <td>Ship Date</td>
        </tr>
EOD;

    $query = "SELECT orderID FROM place WHERE user = '$user'";
    $result = queryMysql($query);

    while ($row = mysql_fetch_row($result))
    {
        echo <<<EOD
    <tr>
        <td>$row[0]</td>
EOD;
        $query = "SELECT * FROM orders WHERE orderID = $row[0]";
        $result2 = queryMysql($query);
        $row2 = mysql_fetch_row($result2);
        $orderDate = date('c', $row2[1]);
        $shippingAddress = $row2[3] . ", " . $row2[4] . ", " . $row2[5] . " " . $row2[6];
        if ($row2[2] == 0)
            $shipDate = "Pending";
        else
            $shipDate = date('c', $row2[2]);

        echo <<<EOD
        <td>$orderDate</td>
        <td>$shippingAddress</td>
EOD;

        $query = "SELECT c.toyGameID, c.quantity, i.name FROM contains c INNER JOIN inventory i ON c.toyGameID = i.toyGameID WHERE orderID = $row[0]";
        $result2 = queryMysql($query);
        $toys = "";
        while($row2 = mysql_fetch_row($result2)) {
            if ($toys == "")
                $toys = $row2[1] . " of " . $row2[2];
            else
                $toys = $toys . ", " . $row2[1] . " of " . $row2[2];
        }

        echo "<td>$toys</td>";

        $query = "SELECT i.unitCost, c.quantity, i.percentOff FROM inventory i INNER JOIN contains c ON i.toyGameID = c.toyGameID WHERE c.orderID = $row[0]";
        $result2 = queryMysql($query);
        $subtotal = 0.00;
        while ($row2 = mysql_fetch_row($result2))
        {
            $subtotal = number_format($subtotal + ($row2[0] * $row2[2] * $row2[1]), 2);
        }
        echo "<td>$$subtotal</td><td>$shipDate</td></tr>";
    }

    echo "</table>";
}
else
{
    echo "Access denied";
}

include 'footer.php';
