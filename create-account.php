<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/14/2017
 * Time: 12:41 PM
 */
include ('classes/DB.php');

if (isset($_POST['createaccount'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    try {
        if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username' => $username))) {
            if(strlen($username) >= 6 && strlen($username) <= 32) {
                if(preg_match('/[a-zA-Z0-9_]+/', $username)) {
                    if(strlen($password) >= 8 && strlen($password) <= 60) {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email' => $email))) {
                                DB::query('INSERT INTO users (username, password, email, verified) VALUES (:username, :password, :email, \'0\')', array(':username' => $username, ':password' => password_hash($password, PASSWORD_BCRYPT), ':email' => $email));
                                echo "User Sucessfull Created";
                            } else {
                                echo "Invalid Email Address: Already Exist";
                            }
                        } else {
                            echo "Invalid Email Address";
                        }
                    }else{
                        echo "Invalid password: Length should be between 8 to 60";
                    }
                }else{
                    echo "Invalid Username: Username must monsist of only a-z A-Z 0-9 and _ characters only";
                }
            }else{
                echo "Invalid Username:Number of characters in username must be between 6 to 32";
            }
        }else  {
            echo "Invalid Username: Username Already Exists";
        }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}
  /*  try {
        $conn = new PDO('mysql:host=127.0.0.1;dbname=socialnetwork;charset=utf8','root','qazwsx');
        // set the PDO error mode to exception
        $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO users (id, username, password, email) VALUES (:id, :userame, :password, :email)");
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        echo "New records created successfully";
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}*/
?>

<h1>Register</h1>
<form action="create-account.php" method="post">
    <p><input type = "text" name ="username" value="" placeholder="Username ..."> </p>
    <p><input type = "password" name ="password" value="" placeholder="password ..."></p>
    <p><input type = "email" name ="email" value="" placeholder="someone@somesite.com"></p>
    <p><input type = "submit" name ="createaccount" value="Create Account"></p>
</form>
