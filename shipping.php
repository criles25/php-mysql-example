<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/18/13
 * Time: 3:23 PM
 */

include_once 'header2.php';
if ($loggedin && $toyCart->uniqueToys() >=1)
{
$error = "";

if (isset($_POST['street']))
{
    $street = sanitizeString($_POST['street']);
    $city = sanitizeString($_POST['city']);
    $zip = sanitizeString($_POST['zip']);
    $state = sanitizeString($_POST['state']);

    if ($street == "" || $city == "" || $state == "" || $zip == "")
        $error = "Not all fields were entered<br /><br />";
    else
    {
        $_SESSION['street'] = $street;
        $_SESSION['city'] = $city;
        $_SESSION['zip'] = $zip;
        $_SESSION['state'] = $state;

        die("<h1 align=center>Confirm Shipping Address</h1><br>
        <div class=container><div class=well>
        <h5><b>Address saved as:</b><br>
        $street, $city,<br>
        $state, $zip<br>
        Is this correct?<br><br>
        <a href=checkout.php>Yes, review order</a><br>
        <a href=shipping.php?user=$user> No, change the address</a></h5></div></div>");

    }

}

echo <<<_END

<h1 align="center"> Please enter a shipping address</h1>


<h5>
<div class="container">
    <div class="span3"></div><!--/.span3-->
    <div class="well">

        <form method='post' action='shipping.php?user=$user'>$error

            <div class="input-group">
                <span class="input-group-addon">Street</span>
                <input type="text" maxlength='50' name='street'
                class="form-control" placeholder="Street">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">City</span>
                <input type="text" maxlength='25' name='city'
                class="form-control" placeholder="City">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">State</span>
                <input type="text" maxlength='2' name='state'
                class="form-control" placeholder="State">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">ZIP</span>
                <input type="number" maxlength='5' name='zip'
                class="form-control" placeholder="ZIP">
            </div>
            <br>
            <input type='submit' value='Ship to this address' class="btn btn-warning">

        </form>
        <br>
        <p><b>Address Accuracy</b><br>Make sure you get your stuff!
        If the address is not entered correctly, your package may be returned as undeliverable.
        You would then have to place a new order. Save time and avoid frustration by entering
        the address information in the appropriate boxes and double-checking for typos and other errors.</p>

</div>
</div>
</div>
</h5>
_END;
}
else
{
    echo "<h1 align=center>Access denied</h1>";
}
include 'footer.php';