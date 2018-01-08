<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/5/2017
 * Time: 9:10 PM
 */

include ('./classes/DB.php');
include ('./classes/Login.php');

if(!Login::isLoggedIn()){
    die("Not Logged in");
}

if(isset($_POST['Confirm'])){
    if(isset($_POST['alldevices'])){
        DB::query('DELETE FROM login_tokes WHERE user_id=:user_id',array(':user_id'=>Login::isLoggedIn()));
    }else{
        if (isset($_COOKIE['SNID'])){
            DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
        }
        setcookie('SNID','1',time()-3600);
        setcookie('SNID_','1',time()-3600);
    }
}

?>

<h1>Logout of your account</h1>
<p>Are you sure you'd like to logout</p>

<form action="logout.php" method="post">
    <p> <input type="checkbox" name="alldevices" value="alldevices"> Logout all devices?<br/></p>
    <p><input type="submit" name="Confirm" value="Confirm"></p>
</form>
