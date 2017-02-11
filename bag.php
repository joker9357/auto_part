<?php
/**
 * Created by PhpStorm.
 * User: xinweiwang
 * Date: 4/13/16
 * Time: 12:10 PM
 */
session_start();
if(!isset($_SESSION["cart"])){
    echo 0;
}else{
    $cart=unserialize($_SESSION["cart"]);
    $keys=array_keys($cart);
    echo count($keys);
}