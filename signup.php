<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/16/13
 * Time: 12:55 PM
 */
$signupActive = 'class="active"';
include_once 'header.php';

echo <<<_END



        <h1>Please enter your details to sign up</h1>
        <h5>
_END;

$error = $user = $pass = $fName = $lName = $mInitial = $userType = "";
if (isset($_SESSION['user'])) destroySession();
if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass1 = sanitizeString($_POST['pass1']);
    $pass2 = sanitizeString($_POST['pass2']);
    $fName = sanitizeString($_POST['fName']);
    $lName = sanitizeString($_POST['lName']);
    $mInitial = sanitizeString($_POST['mInitial']);
    $userType = 0; // make userType 0 by default, if user is an employee or manager the DBA can manually re-assign

    if ($pass1 != $pass2)
        $error = "Passwords don't match <br><br>";
    else
    {
        if ($user == "" || $pass1 == "" || $fName == "" || $lName == "" || $mInitial == "")
            $error = "Not all fields were entered<br /><br />";
        else
        {
            if (mysql_num_rows(queryMysql("SELECT * FROM users WHERE user='$user'")))
                $error = "That username already exists<br /><br />";
            else
            {
                queryMysql("INSERT INTO users VALUES('$user', '$pass1', '$userType', '$fName', '$lName', '$mInitial')");
                die("<h4>Account created</h4>Please Log in.<br /><br />");
            }
        }
    }
}

echo <<<_END
            <form method='post' action='signup.php'>$error


            <div class="input-group">
                <span class="input-group-addon">Username</span>
                <input type="text" maxlength='16' name='user' value='$user'
                class="form-control" placeholder="Username">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" maxlength='16' name='pass1' class="form-control"
                placeholder="Password">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Re-enter Password</span>
                <input type="password" maxlength='16' name='pass2' class="form-control"
                placeholder="Re-enter Password">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">First Name</span>
                <input type="text" maxlength='20' name='fName' value='$fName' class="form-control"
                placeholder="First Name">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Last Name</span>
                <input type="text" maxlength='20' name='lName' value='$lName' class="form-control"
                placeholder="Last Name">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Middle Initial</span>
                <input type="text" maxlength='1' name='mInitial' value='$mInitial' class="form-control"
                placeholder="Middle Initial">
            </div>
            <br>
            <input type='submit' value='Sign up' class="btn btn-default">

            </form>
        </h5>

_END;

include 'footer.php';
?>


