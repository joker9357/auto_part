<?php
/**
 * Created by PhpStorm.
 * User: xinweiwang
 * Date: 4/22/16
 * Time: 11:49 AM
 */
session_start();
if(!isset($_SESSION["cart"])){
    $cart=serialize(array());
}else{
    $cart=unserialize($_SESSION["cart"]);
}


$id=$_POST['id'];

unset($cart[$id]);
$_SESSION["cart"]=serialize($cart);
