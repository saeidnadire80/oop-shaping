
<?php
session_start();
if(! $_SESSION['user']){
    header('location:./ind.php');
}

function request($fild){
    return isset($_REQUEST[$fild]) && $_REQUEST[$fild] != "" ? trim($_REQUEST[$fild]) : null;
}
function has_errors($fild){
    global $errors;
    return isset($errors[$fild]);
}

function get_error($fild){
    global $errors;
    return has_errors($fild) ? $errors[$fild] : null;
}

$errors = [];
$message = false;
$conect =mysqli_connect('localhost','root','','saeid');
if(! $conect){
    echo 'no conect :';
    exit;
}
$_SESSION['user'];
foreach($_SESSION as $a)
$id_user = $a['id'];
$stmt="SELECT * FROM users WHERE id = '{$id_user}'";
$qure=mysqli_query($conect,$stmt);
$item = mysqli_fetch_assoc($qure);
$id=$item['id'];
$name=$item['name'];
$lastname=$item['lastname'];
$username=$item['username'];
$passwordd=$item['password'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username=request('username');
    $password=request('password');
    $password1=request('password1');
    $name=request('name');
    $lastname=request('lastname');
    
    
    if(is_null($username)){
        $errors['username'] = 'فیلد ایمیل نمیتواند خالی باشد';
    }
    

    if(is_null($password)){
        $errors['password'] = 'فیلد پسورد نمیتواند خالی باشد';
    }
    
    
    if(strlen($password) > 100 ){
        $errors['password'] = 'تعداد کاراکتر پسورد نمیتواند بیشتر از 10 کاراکتر باشد';
    }

    if(!password_verify($password,$passwordd)){
        $errors['password'] = 'رمز عبور قبلی صحیح نمیباشد';
    }

    if(is_null($password1)){
        $errors['password1'] = 'فیلد پسورد نمیتواند خالی باشد';
    }
    
    
    if(strlen($password1) > 100 ){
        $errors['password1'] = 'تعداد کاراکتر پسورد نمیتواند بیشتر از 10 کاراکتر باشد';
    }


    if(is_null($name)){
        $errors['name'] ='فیلد نام نمیتواند خالی باشد';
    }



    if(is_null($lastname)){
        $errors['lastname'] = 'فیلد نام خانوادگی نمی تواند خالی باشد';
    }



    $hash = password_hash($password1,PASSWORD_DEFAULT);
    if(! is_null($username) && ! is_null($password) && strlen($password) <= 100 && ! is_null($name) && ! is_null($lastname) && password_verify($password,$passwordd)){
        $stitmat = mysqli_prepare($conect ,"UPDATE users set name = ?, lastname = ? , username = ? , password = ?  where id = ?");
        mysqli_stmt_bind_param($stitmat,'ssssi',$_REQUEST['name'],$_REQUEST['lastname'],$_REQUEST['username'] , $hash , $id );
        mysqli_stmt_execute($stitmat);
        mysqli_affected_rows($conect);
        $message = 'اطلاعات شما با موفقیت ثبت شد';
       
            
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
        <a class="nav-link" href="./dashbord.php">HOMI</a>
      </li>
    </ul>
  </div>
</nav>
</div>
<div style="color:white;" class="container mt-3">
  <h2 style="text-align:center;">EDIT_PROFAIL</h2>
  <form action="./edit_user.php" method="post">
    <div class="mb-3 mt-3">
      <label for="name">name:</label>
      <input type="name" class="form-control" id="name" placeholder="Enter name" name="name" value="<?= $name ?>">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('name')){?>
                                                <?= get_error('name');?><?php } ?></h5>
    </div>
    <div class="mb-3 mt-3">
      <label for="lastname">lastname:</label>
      <input type="lastname" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname" value="<?= $lastname ?>">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('lastname')){?>
                                                <?= get_error('lastname');?><?php } ?></h5>
    </div>
    <div class="mb-3 mt-3">
      <label for="username">username:</label>
      <input type="username" class="form-control" id="username" placeholder="Enter username" name="username">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('username')){?>
                                                <?= get_error('username');?><?php } ?></h5>
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('password')){?>
                                                <?= get_error('password');?><?php } ?></h5>
    </div>
    <div class="mb-3">
      <label for="pwd">Password1:</label>
      <input type="password1" class="form-control" id="pwd" placeholder="Enter password new" name="password1">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('password1')){?>
                                                <?= get_error('password1');?><?php } ?></h5>
    </div>
    <button style="padding-left:100px; padding-right:100px ;" type="submit" class="btn btn-primary">Submit</button><br>
    <h4 style="background-color:greenyellow; text-align: center;"><?= $message ?></h4>
  </form>
</div>
</body>
</html>