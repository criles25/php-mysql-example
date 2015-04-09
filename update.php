<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/19/13
 * Time: 4:34 PM
 */
$updateActive = 'class="active"';

include 'header.php';

$query = "SELECT * FROM inventory";
$result = queryMysql($query);
$numberOfRows = mysql_num_rows($result);

// set date variables
$lastWeek = time() - (7 * 24 * 60 * 60);
$lastMonth = time() - (31 * 24 * 60 * 60);
$lastYear = time() - (365 * 24 * 60 * 60);
$error = "";

if ($userType == 1)
{
    if (isset($_POST['restockAmount']))
    {
        $toygameid = sanitizeString($_POST['toygameid']);
        $amount = sanitizeString($_POST['restockAmount']);
        if (is_numeric($toygameid) && is_numeric($amount))
        {
            $query = "UPDATE inventory SET stockCount = stockCount + $amount WHERE toyGameID = $toygameid";
            queryMysql($query);
        }
        else
            $error = "Must enter an integer";
    }

    echo "<h1>Update Inventory</h1>";

    $query = "SELECT * FROM inventory";
    $result = queryMysql($query);

    echo <<<EOD

    <h5>$error
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Inventory</div>

        <!-- Table -->
        <table class="table">
        <tr>
            <td>Toy ID</td>
            <td>Toy Name</td>
            <td>Price</td>
            <td>Promotion rate</td>
            <td>Quantity</td>
            <td>Update Quantity</td>
        </tr>
EOD;

    while ($row = mysql_fetch_row($result))
    {
    echo <<<EOD
    <tr>
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[7]</td>
        <td>$row[5]</td>
        <td>

        <form role="form" method='post' action='update.php'>

            <input type="number" class="form-control" min ='-1000' max='1000' name='restockAmount' value='1'/>
            <input type="hidden" name="toygameid" value="$row[0]" />
           <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>

        </form>
        </td>
    </tr>
EOD;
    }

    echo "</table></div></div></h5></div>";
}
elseif ($userType == 2)
{
    if (isset($_POST['restockAmount']))
    {
        $toygameid = sanitizeString($_POST['toygameid']);
        $amount = sanitizeString($_POST['restockAmount']);
        if (is_numeric($toygameid) && is_numeric($amount))
        {
            $query = "UPDATE inventory SET stockCount = stockCount + $amount WHERE toyGameID = $toygameid";
            queryMysql($query);
        }
        else
            $error = "Must enter an integer";
    }

    if (isset($_POST['promoRate']))
    {
        $toygameid = sanitizeString($_POST['toygameid']);
        $rate = sanitizeString($_POST['promoRate']);
        if (is_numeric($toygameid) && is_numeric($rate))
        {
            $query = "UPDATE inventory SET percentOff = $rate WHERE toyGameID = $toygameid";
            queryMysql($query);
        }
        else
            $error = "Must enter an integer";
    }

    echo "<h1>Update Inventory</h1>";





    echo <<<EOD

    <h5>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Inventory</div>

        <!-- Table -->
        <table class="table">
        <tr>
            <td>Toy ID</td>
            <td>Toy Name</td>
            <td>Price</td>
            <td>Promotion rate</td>
            <td>Update Rate</td>
            <td>Quantity</td>
            <td>Update Quantity</td>
            <td>Sales past week</td>
            <td>Sales past month</td>
            <td>Sales past year</td>
        </tr>
EOD;

    $query = "SELECT * FROM inventory";
    $result = queryMysql($query);

    while ($row = mysql_fetch_row($result))
    {
        echo <<<EOD
    <tr>
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[7]</td>
        <td>

        <form role="form" method='post' action='update.php'>

            <input type="number" step="any" class="form-control" min ='0' max='1000' name='promoRate' value='$row[7]'/>
            <input type="hidden" name="toygameid" value="$row[0]" />
           <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>

        </form>
        </td>
        <td>$row[5]</td>
        <td>

        <form role="form" method='post' action='update.php'>

            <input type="number" class="form-control" min ='-1000' max='1000' name='restockAmount' value='1'/>
            <input type="hidden" name="toygameid" value="$row[0]" />
           <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>

        </form>
        </td>
EOD;

        $query2 = "SELECT SUM(quantity) FROM contains WHERE orderID IN (SELECT orderID FROM orders WHERE orderDate >= '$lastWeek' AND toyGameID = '$row[0]')";
        $result2 = queryMysql($query2);
        $row2 = mysql_fetch_row($result2);
        $salesLastWeek = $row2[0];
        if (!isset($salesLastWeek))
            $salesLastWeek = 0;

        $query2 = "SELECT SUM(quantity) FROM contains WHERE orderID IN (SELECT orderID FROM orders WHERE orderDate >= '$lastMonth' AND toyGameID = '$row[0]')";
        $result2 = queryMysql($query2);
        $row2 = mysql_fetch_row($result2);
        $salesLastMonth = $row2[0];
        if (!isset($salesLastMonth))
            $salesLastMonth = 0;

        $query2 = "SELECT SUM(quantity) FROM contains WHERE orderID IN (SELECT orderID FROM orders WHERE orderDate >= '$lastYear' AND toyGameID = '$row[0]')";
        $result2 = queryMysql($query2);
        $row2 = mysql_fetch_row($result2);
        $salesLastYear = $row2[0];
        if (!isset($salesLastYear))
            $salesLastYear = 0;

        echo <<<EOD
        <td>$salesLastWeek</td>
        <td>$salesLastMonth</td>
        <td>$salesLastYear</td>
    </tr>
EOD;
    }

    echo "</table></div></div></h5></div>";


}
else
{
        echo "Access denied";
}

include 'footer.php';