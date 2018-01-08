<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/14/2017
 * Time: 2:17 PM
 */

class DB {
    private static function connect(){
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=socialnetwork;charset=utf8','root','qazwsx');
        $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function query($query,$parms = array()){
        //$statement = self::connect();
        $statement = self::connect()->prepare($query);
        $statement -> execute($parms);

        if(explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll();
            return $data;
        }

    }
}