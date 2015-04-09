<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/15/13
 * Time: 4:02 PM
 */

$dbhost = 'localhost';
$dbname = 'test9';
$dbuser = 'root';
$dbpass = '';
$appname = "Amazing Toy Store";
mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br />";
}

function queryMysql($query)
{
    $result = mysql_query($query) or die(mysql_error());
    return $result;
}

function destroySession()
{
    $_SESSION=array();
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
    session_destroy();
}

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return mysql_real_escape_string($var);
}

// cart class
class Cart
{
    private  $toys = array();
    private  $toyQuantity = array();
    private  $toyName = array();
    private  $toyPrice = array();
    private  $toyDiscount = array();
    private  $toyWeight = array();

    public function addToCart($t, $tq, $tn, $tp, $td, $tw)
    {
        $max = sizeof($this->toys);

        if (in_array($t, $this->toys)) {
            for ($j = 0; $j < $max; $j++) {
                if ($t == $this->toys[$j]) {
                    $this->toyQuantity[$j] += $tq;
                }
            }
        } else {
            $this->toys[$max] = $t;
            $this->toyQuantity[$max] = $tq;
            $this->toyName[$max] = $tn;
            $this->toyPrice[$max] = $tp;
            $this->toyDiscount[$max] = $td;
            $this->toyWeight[$max] = $tw;
        }
    }
    public function uniqueToys()
    {
            return count($this->toys);
    }
    public function cartSize()
    {
        return array_sum($this->toyQuantity);
    }
    public function getToyName()
    {
        return $this->toyName;
    }
    public function getToyQuantity()
    {
        return $this->toyQuantity;
    }
    public function getToyPrice()
    {
        return $this->toyPrice;
    }
    public function getToyDiscount()
    {
        return $this->toyDiscount;
    }
    public function getToys()
    {
        return $this->toys;
    }
    public function getWeight()
    {
        return $this->toyWeight;
    }
    public function updateQuantity($t, $tq)
    {
        $this->toyQuantity[$t] = $tq;
    }
    public function removeToy($t)
    {
        unset($this->toys[$t]);
        $this->toys = array_values($this->toys);
        unset($this->toyQuantity[$t]);
        $this->toyQuantity = array_values($this->toyQuantity);
        unset($this->toyName[$t]);
        $this->toyName = array_values($this->toyName);
        unset($this->toyPrice[$t]);
        $this->toyPrice = array_values($this->toyPrice);
        unset($this->toyDiscount[$t]);
        $this->toyDiscount = array_values($this->toyDiscount);
        unset($this->toyWeight[$t]);
        $this->toyWeight = array_values($this->toyWeight);
    }
}

// set timezone
date_default_timezone_set('America/New_York');

?>