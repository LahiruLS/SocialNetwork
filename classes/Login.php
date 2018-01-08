<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/5/2017
 * Time: 9:27 PM
 */

class Login
{
    public static function isLoggedIn(){
        if(isset($_COOKIE['SNID'])){

            if(DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])))){
                $user_id = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])))[0][user_id];

                if(isset($_COOKIE['SNID_'])){
                    return $user_id;
                }else {
                    $cstrong= True;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    DB::query('INSERT INTO login_tokens (token, user_id) VALUES (:token, :user_id)', array(':token' => sha1($token), 'user_id' => $user_id));
                    DB::query('DELETE FROM login_tokens WHERE token-:token', array(':token' => sha1($_COOKIE['SNID'])));
                    setcookie("SNID", $token, time() + 60*60*24*7, '/', NULL, NULL, TRUE);
                    setcookie("SNID_", $token, time() + 60*60*24*3, '/', NULL, NULL, TRUE);

                    return $user_id;
                }

            }

        }
        return false;
    }

    public static function usernameLoggedin(){
        $user_id = self::isLoggedIn();
        return DB::query('SELECT username FROM users WHERE id=:user_id',array(':user_id'=>$user_id))[0][username];
    }
    public static function emailLoggedin(){
        $user_id = self::isLoggedIn();
        return DB::query('SELECT email FROM users WHERE id=:user_id',array(':user_id'=>$user_id))[0][email];
    }
}