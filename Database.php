<?php
class database {
    private static $localhost;
    private static $root;
    private static $password;
    private static $db;
    private static $con;
    public static function setlocalhost($localhost){
        self::$localhost=$localhost;
    }
    public static function getlocalhost(){
        return self::$localhost;
    }
    public static function setroot($root){
        self::$root=$root;
    }
    public static function getroot(){
        return self::$root;
    }
    public static function setpassword($password){
        self::$password=$password;
    }
    public static function getpassword(){
        return self::$password;
    }
    public static function setdb($db){
        self::$db=$db;
    }
    public static function getdb(){
        return self::$db;
    }
    public static function data(){
        self::$con=mysqli_connect(self::getlocalhost(),self::getroot(),self::getpassword(),self::getdb());
       return self::$con;
    }
}
database::setlocalhost('localhost');
database::setroot('root');
database::setpassword("");
database::setdb('sase');
?>