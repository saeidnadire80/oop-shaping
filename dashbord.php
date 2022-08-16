<?php
session_start();
if(!$_SESSION['user']){
  header('location:./index.php');
}
$conect =mysqli_connect('localhost','root','');
if(! $conect){
    echo 'no conect :';
    exit;
}
mysqli_select_db($conect,'saeid');
$stmt="SELECT * FROM products";
$qure=mysqli_query($conect,$stmt);
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
        <a class="nav-link" href="./cart.php">CAR</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./getout.php">GET_OUT</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./edit_user.php">EDIT_PROFAIL</a>
      </li>
    </ul>
  </div>
</nav>
<section class="py-5" >
              <div class="container px-4 px-lg-8 mt-5">
                  <div class="row justify-content-center">
                      <?php while($i = mysqli_fetch_assoc($qure)){?>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mt-3 col-6" >
                          <div class="card h-100">
                              <!-- Product image-->
                              <img class="card-img-top" src="./asset/image/<?=$i['image'];?>" alt="..." />
                              <!-- Product details-->
                              <div class="card-body p-0">
                                  <div class="text-center">
                                      <!-- Product name-->
                                      <h5 class="fw-bolder"><?= $i['name_product'] ?></h5>
                                      <!-- Product price-->
                                      <h5><?= $i['price'] .'$';?> :قیمت اصلی </h5>
                              <?php if(isset($i['price_Discount'])) { ?>
                                      <h5 class="fw-bolder">درصد تخفیف:%<?php 
                                      $asle = 100 * $i['price_Discount'];
                                      $avarage = $asle /$i['price']; 
                                      $a =100 - $avarage; 
                                      echo round($a); ?></h5>
                                      <?php } ?>
                                      <?php if(isset($i['price_Discount'])) { ?>
                                      <h5 style="color:springgreen;" class="fw-bolder"><?= $i['price_Discount'] ?>$  :قیمت با تخفیف</h5>
                                      <?php } ?>
                                  </div>
                                  
                                  
                              </div>
                              <!-- Product actions-->
                              <div style="text-align:center ;" class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <form action="./cart.php" method="post">
                                  <input type="hidden" name="id" value="<?= $i['id']?>">
                                  <input type="submit" value="افزودن به سبد خرید">
                                </form>
                              </div>
                          </div>
                      </div>
                      <?php } ?>

              </div>
            </div>
        </section>
</body>
<script>
  function message(){
    alert('اعتماد از شما کیفیت از ما');
  }
  setInterval(message,10000);
</script>
</html>