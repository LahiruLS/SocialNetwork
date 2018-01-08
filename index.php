<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/14/2017
 * Time: 12:40 PM
 */

include ('./classes/DB.php');
include ('./classes/Login.php');


if (Login::isLoggedIn()) {
    echo Login::isLoggedIn()."Logged in";
}else{
    echo  "Not Logged in";
}

?>