<?php
	session_start();
	if(! $_SESSION['user']){
		header('location:./ind.php');
	}

		$conect =mysqli_connect('localhost','root','','saeid');
		if(!$conect){
			echo 'no conect :' . mysqli_connect_error();
			exit;
		}
        $id_user = $_SESSION['user']['id'];
        if(isset($_POST['id'])){
			$id_product = $_POST['id'];
			$stitmat=mysqli_prepare($conect,"INSERT INTO bascts(id_user,id_product) values (?,?)");
			mysqli_stmt_bind_param($stitmat,'ii',$id_user,$id_product);
			mysqli_stmt_execute($stitmat);
            header('location:./dashbord.php');
        }
        $stm =mysqli_prepare($conect,"SELECT bascts.id , products.price_Discount , products.price , products.image , products.name_product FROM bascts RIGHT JOIN products ON bascts.id_product = products.id WHERE id_user = '{$id_user}' ");
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        if($result->num_rows == 0){
            echo 'no';
        }
        
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <a class="nav-link" href="./dashbord.php">HOME</a>
      </li>
    </ul>
  </div>
</nav>
<div class="container mt-3">
    <table class="table table-dark">
        <thead>
        <tr>
            <th>name_product</th>
            <th>price</th>
            <th>price_Discount</th>
            <th>image</th>
            <th>edit</th>
        </tr>
        </thead>
        <tbody>
        <?php while($item = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td> <?= $item['name_product']?> </td>
            <td> <?= $item['price']?> </td>
            <td> <?= $item['price_Discount']?> </td>
            <td><img class="col-lg-3 col-sm-12 " style="width:50%; height:50px;" src="./asset/image/<?= $item['image']?>" alt=""> </td>
            <td><a style="color:black; background-color:green ;" href="#">to purchase</a>				<form action="./delet.php" method="post">
                        <input type="hidden" value="<?=$item['id']?>" name="id">
                        <input style="background-color:brown;" type="submit" class="cta" value="حذف" class="remove"></input>
                        </form><br></td>
        </tr>
        </tbody>
        <?php } ?>
    </table>
    
</div>
</body>
<script>
  function message(){
    alert("برای سلامتی آقا امام زمان صلوات محمدی ختم بفرمایید");
  }
  setTimeout(message,5000);
</script>
</html>