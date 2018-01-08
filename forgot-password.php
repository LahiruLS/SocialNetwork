<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/5/2017
 * Time: 10:33 PM
 */

include ('./classes/DB.php');
include ('./classes/Login.php');

if (isset($_POST[resetpassword])){
   if (isset($_POST['email'])){
       $email = $_POST['email'];
       $cstrong= True;
       $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
       $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email' => $email))[0]['id'];
       DB::query('INSERT INTO password_tokens (token, user_id) VALUES (:token, :user_id)', array(':token' => sha1($token), 'user_id' => $user_id));
        echo "Recovery Email Sent";
        echo '<br />';
        echo $token;
   } else{
       echo "Please Enter the Email address to reset the password";
   }

}

?>

<h1>Forgot Password</h1>
<form action="forgot-password.php" method="post">
    <p><input type="text" name="email" value="" placeholder="Email ..."></p>
    <p><input type="submit" name="resetpassword" value="Reset Password"></p>
</form>
