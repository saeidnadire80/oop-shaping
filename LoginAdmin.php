<?php
include_once './Database.php';
class LoginAdmin {
    private static $con;
    public static function insertuser(){
        self::database();
        $query=mysqli_query(self::$con,"SELECT * FROM login");
        return $query;
    }

    public static function database(){
        self::$con=database::data();
    }
}
?>