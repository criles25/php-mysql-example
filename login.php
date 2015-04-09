<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/16/13
 * Time: 4:30 PM
 */

$loginActive = 'class="active"';

include_once 'header.php';

echo "
<h1>Please enter your details to log in</h1>
<h4>";
$error = $user = $pass = "";

if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    if ($user == "" || $pass == "")
    {
        $error = "Not all fields were entered<br />";
    }
    else
    {
        $query = "SELECT user,pass FROM users WHERE user='$user' AND pass='$pass'";
        if (mysql_num_rows(queryMysql($query)) == 0)
        {
            $error = "Username/Password invalid<br><br>";
        }
        else
        {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die("You are now logged in. Please <a href='account.php?user=$user'>" .
                "click here</a> to continue.<br /><br />");
        }
    }
}

echo <<<_END
<form method='post' action='login.php'>$error


<div class="input-group">
    <span class="input-group-addon">Username</span>
    <input type="text" maxlength='16' name='user' value='$user'
    class="form-control" placeholder="Username">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon">Password</span>
    <input type="password" maxlength='16' name='pass' class="form-control"
    placeholder="Password">
</div>
<br>
    <input type='submit' value='Login' class="btn btn-default">

</form>
<br>
<a href="signup.php">Not registered? Sign up here.</a>
</h4>
_END;

include 'footer.php';