<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/17/13
 * Time: 10:26 AM
 */
$logoutActive = 'class="active"';
include_once 'header.php';
if (isset($_SESSION['user']))
{
    destroySession();
    echo "<h4>You have been logged out. Please " .
        "<a href='home.php'>click here</a> to continue to the home page.</h4>";
}
else echo "<h4>" .
    "You cannot log out because you are not logged in</h4>";
?>