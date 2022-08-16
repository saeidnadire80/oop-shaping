<?php
include_once './validation.php';
$error=new errorr();
session_start();
$message = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username=$error->request('username');
    $password =$error->request('password');
    $name=$error->request('name');
    $lastname=$error->request('lastname');
    
    
    if(is_null($username)){
        $error->set('username','فیلد نام کاربر نمیتواند خالی باشد');
    }
    

    if(is_null($password)){
      $error->set('password','فیلد پسورد نمیتواند خالی باشد');
    }
    
    
    if(strlen($password) > 100 ){
      $error->set('password','تعداد کاراکتر پسورد نمیتواند بیشتر از ده کاراکتر باشد');
    }



    if(is_null($name)){
      $error->set('name','فیلد نام نمیتواند خالی باشد');
    }



    if(is_null($lastname)){
      $error->set('lastname','فیلد نام خانوادگی نمیتواند خالی باشد');
    }


    if(! is_null($username) && ! is_null($password) && strlen($password) <= 100 && ! is_null($name) && ! is_null($lastname)){
            $conect =mysqli_connect('localhost','root','','saeid');
            if(! $conect){
                echo 'no conect :';
                exit;
            }
            $hash =password_hash($password,PASSWORD_DEFAULT);
            $stitmat=mysqli_prepare($conect,"INSERT INTO users(name,lastname,username,password) values (?,?,?,?)");
            mysqli_stmt_bind_param($stitmat,'ssss',$name,$lastname,$username,$hash);
            mysqli_stmt_execute($stitmat);
            $stmt=mysqli_prepare($conect,"SELECT * FROM users where username ='{$username}' ");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($result->num_rows == 0){
                $errors['login'] = 'نام کاربری و رمز ورود با هم همخوانی ندارند';
            }
            else{
                $item = mysqli_fetch_assoc($result);
            $_SESSION['user'] = [
                'id' => $item['id']
            ];
            header('location:./dashbord.php');
        }
    }
    }
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="./asset/css/style.css">
  </head>

<body>

   
  <!--header-->
  <nav class="navbar-expand bg-light">
  <div class="container">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="./index.php">HOMI</a>
      </li>
    </ul>
  </div>
</nav>
</div>
<div style="color:white;" class="container mt-3">
  <h2 style="text-align:center;">REGISTER</h2>
  <form action="./rigster.php" method="post">
    <div class="mb-3 mt-3">
      <label for="name">name:</label>
      <input type="name" class="form-control" id="name" placeholder="Enter name" name="name">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if($error->has('name')){?>
                                                <?= $error->get('name');?><?php } ?></h5>
    </div>
    <div class="mb-3 mt-3">
      <label for="lastname">lastname:</label>
      <input type="lastname" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if($error->has('lastname')){?>
                                                <?= $error->get('lastname');?><?php } ?></h5>
    </div>
    <div class="mb-3 mt-3">
      <label for="username">username:</label>
      <input type="username" class="form-control" id="username" placeholder="Enter username" name="username">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if($error->has('username')){?>
                                                <?= $error->get('username');?><?php } ?></h5>
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if($error->has('password')){?>
                                                <?= $error->get('password');?><?php } ?></h5>
    </div>
    <button style="padding-left:100px; padding-right:100px ;" type="submit" class="btn btn-primary">Submit</button><br>
    <a href="./login.php">You can login here!&#128512;</a>
  </form>
</div>
</body>
</html>