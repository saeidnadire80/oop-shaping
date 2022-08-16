
<?php
 session_start();

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

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username=request('username');
    $password=request('password');
    
    
    if(is_null($username)){
        $errors['username'] = 'فیلد نام کاربری نمیتواند خالی باشد';
    }
    

    if(is_null($password)){
        $errors['password'] = 'فیلد پسورد نمیتواند خالی باشد';
    }
    
    
    if(strlen($password) > 100 ){
        $errors['password'] = 'تعداد کاراکتر پسورد نمیتواند بیشتر از 10 کاراکتر باشد';
    }



    if(! is_null($username) && ! is_null($password) && strlen($password) <= 100 ){
            $conect =mysqli_connect('localhost','root','','saeid');
            if(! $conect){
                echo 'no conect :';
                exit;
            }
            if($username == 'sase' && $password == 'sase80'){
                $_SESSION['admin'] =[
                    'password' => 'sase80'
                ];
                header('location:admin.php');
            }else{
                $stmt=mysqli_prepare($conect,"SELECT * FROM users where username ='{$username}' ");
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($result->num_rows == 0){
                    $errors['login'] = 'نام کاربری و رمز ورود با هم همخوانی ندارند';
                }
                else{
                    $item = mysqli_fetch_assoc($result);
                    if($username == $item['username'] && password_verify($password,$item['password'])){
                        $_SESSION['user']=[
                            'id' => $item['id']
                        ];
                        header('location:./dashbord.php');
                }
            }
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
  <h2 style="text-align:center;">LOGIN</h2>
  <form action="./login.php" method="post">
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
                                                <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('login')){?>
                                                <?= get_error('login');?><?php } ?></h5>
    </div>
    <button style="padding-left:100px; padding-right:100px ;" type="submit" class="btn btn-primary">Submit</button><br>
    <a href="./rigster.php">You can register here!&#128512;</a>
  </form>
</div>
</body>
</html>