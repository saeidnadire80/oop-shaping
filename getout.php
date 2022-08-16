<?php
session_start();
if(!$_SESSION){
    header('location:./ind.php');
}
session_destroy();
header('location:./login.php');
?>