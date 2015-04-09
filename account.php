<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/16/13
 * Time: 10:33 PM
 */

$accountActive = 'class="active"';

include 'header.php';

if (!$loggedin) die();
echo <<<_END
<h1>Your Account</h1>
<h4>
Orders<br>
<a href="orders.php">View your current and past orders</a>
<br>
<br>
Log Out<br>
<a href="logout.php">Not $user? Log out here</a>
</h4>
_END;

include 'footer.php';