<?php
session_start();
if(!$_SESSION['admin']){
    header('location:./login.php');
}else{
        $conect =mysqli_connect('localhost','root','','saeid');
        if(! $conect){
            echo 'no conect :';
            exit;
        }
            $stmt=mysqli_prepare($conect,"SELECT * FROM users");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
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
        <a class="nav-link" href="./index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./dashbord.php">SHOPING</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./edit_productt.php">EDIT_PRODUCT</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./add_product.php">ADD_PRODUCT</a>
      </li>
    </ul>
  </div>
</nav>
</body>
</html>
