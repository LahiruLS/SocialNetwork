<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/14/2017
 * Time: 12:40 PM
 */

include ('./classes/DB.php');
include ('./classes/Login.php');

$username = "";
$isFollowing = False;
$verified = False;

if (isset($_GET['username'])){
    if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))){

        $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
        $followerid = Login::isLoggedIn();
        $userid = DB::query('SELECT id from users WHERE userame=:username',array(':username'=>$username))[0][id];
        $verified = DB::query('SELECT verified FROM users WHERE username=:username', array(':username'=>$username))[0][verified];


        if (isset($_POST['follow'])){
            if ($userid != $followerid) {
                if (!DB::query('SELECT folower_id FROM followers WHERE user_id=:userid', array(':userid' => $userid))) {
                    if ($folowerid == 6){
                        DB::query('UPDATE users SET verified=1 WHERE id=:userid', array(':userid'=>$userid));
                    }
                    DB::query('INSERT INTO folowers (user_id, follower_id) VALUES (:userid, :folowerid) ', array(':userid' => $userid, ':folowerid' => $folowerid));
                } else {
                    echo 'Already Following';
                }

                $isFollowing = True;
            }
        }

        if (isset($_POST['unfollow'])){
            if ($userid != $followerid) {
                if (DB::query('SELECT folower_id FROM followers WHERE user_id=:userid', array(':userid' => $userid))) {
                    if ($folowerid == 6){
                        DB::query('UPDATE users SET verified=0 WHERE id=:userid', array(':userid'=>$userid));
                    }
                    DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':folowerid' => $folowerid));
                }

                $isFollowing = False;
            }
        }

        if (DB::query('SELECT folower_id FROM followers WHERE user_id=:userid', array(':userid'=>$userid))) {
            $isFollowing = True;
        }



    }else{
        die("User not Foound");
    }
}

?>

<h1><?php echo $username?>'s Profile'<?php if($verified) {echo ' - Verified';} ?></h1>
<form action="profile.php?username=<?php echo $username; ?>" method="post">
    <?php
        if ($userid != $followerid){
            if($isFollowing){
                echo '<input type="submit" name="unfollow" value="UnFollow">';

            }else{
                echo '<input type="submit" name="follow" value="Follow">';
            }
        }
    ?>
</form>
