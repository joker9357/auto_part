<?php
/**
 * Created by PhpStorm.
 * User: xinweiwang
 * Date: 4/13/16
 * Time: 2:03 AM
 */
session_start();
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"]=serialize(array());
}
$cart=unserialize($_SESSION["cart"]);
$id=$_POST['id'];
if(!isset($cart[$id])){
    $cart[$id]=1;
}
$_SESSION["cart"]=serialize($cart);
echo $id;