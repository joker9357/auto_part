<?php
/**
 * Created by PhpStorm.
 * User: xinweiwang
 * Date: 4/13/16
 * Time: 5:40 PM
 */
session_start();
$_SESSION['cart']=serialize(array());
echo "<script language='javascript'>";
echo "alert(\"success!\");";

echo "location='index.php'";

echo "</script>";