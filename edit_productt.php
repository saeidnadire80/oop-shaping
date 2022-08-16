<?php
    $conect =mysqli_connect('localhost','root','','saeid');
    if(! $conect){
        echo 'no conect :';
        exit;
    }
    $stmt=mysqli_prepare($conect,"SELECT * FROM products");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
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
        <a class="nav-link" href="./admin.php">HOME</a>
      </li>
    </ul>
  </div>
</nav>
<table style="text-align:center; margin:auto ; margin-top:100px ;" class="table table-dark container">
    <thead>
    <tr>
        <th>id</th>
        <th>name_product</th>
        <th>price</th>
        <th>price_Discount</th>
        <th>image</th>
        <th>edit</th>
        <th>delete</th>
      </tr>
    </thead>
    <?php while($item = mysqli_fetch_assoc($result)) { ?>
    <tbody>
    <tr>
        <td> <?= $item['id']?> </td>
        <td> <?= $item['name_product']?> </td>
        <td> <?= $item['price']?> </td>
        <td> <?= $item['price_Discount']?> </td>
        <td><img style="width:200px;" src="./asset/image/<?= $item['image']?>" alt=""> </td>
        <td><a style="color:black; background-color:green ;" href="./edit_id_product.php?id=<?= $item['id']?>">edit</a></td>
        <td><form action="./delet_id_product.php" method="post"><input type="hidden" value="<?= $item['id']?>" name="id"><input style="background-color:crimson;" type="submit" value="delet"></form></td>
      </tr>
    </tbody>
    <?php } ?>
  </table>
</body>
</html>