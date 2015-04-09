<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/24/13
 * Time: 8:59 PM
 */

include 'header.php';

if (isset($_POST['searchTerm']))
{
    $searchterm = sanitizeString($_POST['searchTerm']);
    $query = "SELECT * FROM inventory WHERE name = '$searchterm'";
    $result = queryMysql($query);

    if ($row = mysql_fetch_row($result))
    {
        $price = $row[2];
        $discount = number_format($row[7], '2', '.', ',');
        $finalPrice = number_format(($price * $discount), '2', '.', ',');
        $percentOff = "";
        if ((1 - $discount) > 0)
            $percentOff = ((1 - $discount) * 100) . "% off";

        echo <<<EOD
        <h5><div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="$row[4]" width="150" height="150">
                <div class="caption">
                    <h4>$row[1]</h4>
                    <p>$row[3] $$finalPrice <b>$percentOff</b></p>
                    <form method="post" action="cart.php?user=$userstr">
                        <div class="input-group">
                            <span class="input-group-addon">Quantity</span>
                            <input type="number" min ='1' name='quantity' value='1' class="form-control">
                        </div>
                        <br>
                        <input type="hidden" name="toy" value="$row[0]">
                        <input type="hidden" name="toyName" value="$row[1]">
                        <input type="hidden" name="price" value="$row[2]">
                        <input type="hidden" name="discount" value="$row[7]">
                        <input type="hidden" name="weight" value="$row[6]">
                        <input type='submit' value='Add To Cart' class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
        </div></h5>

EOD;
    }
    else
    {
        echo "<h4>Sorry, we do not carry '$searchterm'</h4>";
    }

}

include 'footer.php';