<?php
    if(!isset($_POST['id'])){
        header('location:./carts/cart.php');
        return;
}
   $conect =mysqli_connect('localhost','root','','saeid');
   if(! $conect){
       echo 'no conect :' . mysqli_connect_error();
       exit;
   }
   $id = $_POST['id'];
   $stitmat = mysqli_prepare($conect , "DELETE FROM bascts where id = ?");
    $id = (int)$_POST['id'];
    mysqli_stmt_bind_param($stitmat,'i',$id);
    mysqli_stmt_execute($stitmat);
    header('location:./cart.php');
    return;
    ?>