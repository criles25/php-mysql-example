<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/22/13
 * Time: 1:59 PM
 */
$shipActive = 'class="active"';

include_once 'header.php';

$error = "";
if (isset($_POST['order']))
{
    $toyArray = array();
    $quantityArray = array();
    $orderID = sanitizeString($_POST['order']);
    $query = "SELECT c.toyGameID, c.quantity, i.stockCount, i.name FROM contains c INNER JOIN inventory i ON c.toyGameID = i.toyGameID WHERE orderID = $orderID";
    $result = queryMysql($query);
    while ($row = mysql_fetch_row($result))
    {
        $toy = $row[0];
        $quantity = $row[1];
        $stockCount = $row[2];
        $toyName = $row[3];

        if ($quantity > $stockCount)
        {
            $error = "Not enough of $toyName($toy) in stock";
            break;
        }
        else
        {
            $toyArray[] = $toy;
            $quantityArray[] = $quantity;
        }
    }

    if ($error == "")
    {
        $date = getdate();
        $d = $date[0];
        $query = "UPDATE orders SET shipDate = $d WHERE orderID = $orderID";
        queryMysql($query);
        for ($j = 0; $j < count($toyArray); $j++)
        {
            $toy = $toyArray[$j];
            $quantity = $quantityArray[$j];
            $query = "UPDATE inventory SET stockCount = stockCount - $quantity WHERE toyGameID = $toy";
            queryMysql($query);
        }
    }

}
if ($userType == 1 || $userType == 2)
{
    echo <<<EOD

<h1>Ship Pending Orders</h1>
<h5>$error
<div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Pending orders</div>

        <!-- Table -->
        <table class="table">
        <tr>
            <td>Order ID</td>
            <td>Order date</td>
            <td>Shipping Address</td>
            <td>Name</td>
            <td>Toys</td>
            <td>Subtotal</td>
            <td>Ship?</td>
        </tr>


EOD;

    $query = "SELECT * FROM orders  WHERE shipDate = 0";
    $result = queryMysql($query);

    while ($row = mysql_fetch_row($result))
    {
        $orderDate = date('c', $row[1]);
        $shippingAddress = $row[3] . ", " . $row[4] . ", " . $row[5] . " " . $row[6];


        echo <<<EOD
    <tr>
        <td>$row[0]</td>
        <td>$orderDate</td>
        <td>$shippingAddress</td>

EOD;

        $query = "SELECT fName, lName, mInitial FROM users WHERE user IN (SELECT user FROM place WHERE orderID = $row[0])";
        $result2 = queryMysql($query);
        $row2 = mysql_fetch_row($result2);
        $name = $row2[0] . " " . $row2[2] . " " . $row2[1];
        echo <<<EOD
        <td>$name</td>
EOD;

        $query = "SELECT c.toyGameID, c.quantity, i.name FROM contains c INNER JOIN inventory i ON c.toyGameID = i.toyGameID WHERE orderID = $row[0]";
        $result2 = queryMysql($query);
        $toys = "";
        while($row2 = mysql_fetch_row($result2)) {
            if ($toys == "")
                $toys = $row2[1] . " of " . $row2[2] . "(" . $row2[0] . ")";
            else
                $toys = $toys . ", " . $row2[1] . " of " . $row2[2] . "(" . $row2[0] . ")";
        }

        echo "<td>$toys</td>";

        $query = "SELECT i.unitCost, c.quantity, i.percentOff FROM inventory i INNER JOIN contains c ON i.toyGameID = c.toyGameID WHERE c.orderID = $row[0]";
        $result2 = queryMysql($query);
        $subtotal = 0.00;
        while ($row2 = mysql_fetch_row($result2))
        {
            $subtotal = number_format($subtotal + ($row2[0] * $row2[2] * $row2[1]), 2);
        }
        echo "<td>$$subtotal</td>";

        echo <<<EOD
        <td>
        <form role="form" method='post' action='ship.php'>
            <input type="hidden" name="order" value="$row[0]">

            <button type="submit" class="btn btn-warning">Ship it</button>
        </form>
        </td>
EOD;


    }

    echo "</table></div></div></h5>";
}
else
    echo "Access denied";


include_once 'footer.php';