
<?php
session_start();
if(!$_SESSION['admin']){
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

    if(isset($_GET['id'])){
        $_SESSION['id'] = $_GET['id'];
    }
    $id_product = $_SESSION['id'];
    $stmt=mysqli_prepare($conect ,"SELECT * FROM products WHERE id = '{$id_product}'");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result);
    $id=$item['id'];
    $name_product=$item['name_product'];
    $image=$item['image'];
    $price=$item['price'];
    $price_Discount=$item['price_Discount']; 


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name_product = request('name_product');
        $image =$_FILES['image']['name'];
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $folder ="./asset/image/$image_name";
        $price = request('price');
        $price_Discount = request('price_Discount');
        
        
        
        if(is_null($name_product)){
            $errors['name_product'] ='نام محصول را وارد کنید';
        }
        

        if(is_null($price)){
            $errors['price'] ='فیلد قیمت نمیتواند خالی باشد';
        }


        if(! is_null($name_product) &&! is_null($price) ){
            $stitmat = mysqli_prepare($conect,"UPDATE products set name_product = ?, image = ? , price = ? , price_Discount = ?  where id = ?");
            mysqli_stmt_bind_param($stitmat,'ssssi',$name_product,$image_name,$price ,$price_Discount,$item['id']);
            if(mysqli_stmt_execute($stitmat)){
                move_uploaded_file($image_tmp_name,$folder);
                $message = 'محصول با موفقیت اضافه شد';
            }else{
                echo 'no save data' ;
                exit;
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
        <a class="nav-link" href="./admin.php">HOMI</a>
      </li>
    </ul>
  </div>
</nav>
</div>
<div style="color:white;" class="container mt-3">
  <h2 style="text-align:center;">Add product</h2>
  <form action="./edit_id_product.php" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
      <label for="name_product">name_product:</label>
      <input type="text" class="form-control" id="name_product" placeholder="Enter name_product" name_product="name_product" name="name_product">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('name_product')){?>
                                                <?= get_error('name_product');?><?php } ?></h5>
    </div>
    <div class="mb-3 mt-3">
      <label for="image">image:</label>
      <input type="file" class="form-control" name="image" id="image" placeholder="Enter image" required>
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('image')){?>
                                                <?= get_error('image');?><?php } ?></h5>
    </div>
    <div class="mb-3 mt-3">
      <label for="price">price:</label>
      <input type="number" class="form-control" id="price" placeholder="Enter price" name="price">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('price')){?>
                                                <?= get_error('price');?><?php } ?></h5>
    </div>
    <div class="mb-3">
      <label for="price_Discount">price_Discount:</label>
      <input type="number" class="form-control" id="price_Discount" placeholder="Enter price_Discount" name="price_Discount">
      <span style="color:white; text-align:center; background-color:brown;"><h5 style="color:white; text-align:center; background-color:brown;" ><?php if(has_errors('price_Discount')){?>
                                                <?= get_error('price_Discount');?><?php } ?></h5>
    </div>
    <button style="padding-left:100px; padding-right:100px ;" type="submit" class="btn btn-primary">Submit</button><br>
    <h4 style="background-color:greenyellow; text-align: center;"><?= $message ?></h4>
  </form>
</div>
<table style="text-align:center; margin:auto ;" class="table table-dark container">
    <thead>
    <tr>
        <th>id</th>
        <th>name_product</th>
        <th>price</th>
        <th>price_Discount</th>
        <th>image</th>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td> <?= $id?> </td>
        <td> <?= $name_product?> </td>
        <td> <?= $price?> </td>
        <td> <?= $price_Discount?> </td>
        <td><img style="width:200px;" src="./asset/image/<?= $image ?>" alt=""> </td>
      </tr>
    </tbody>
  </table>
</body>
</html>