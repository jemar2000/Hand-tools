<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
         $insert_product->execute([$name, $category, $price, $image]);

         $message[] = 'new product added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <style>
      body {
         font-family: Arial, sans-serif;
         size: 8;
         margin: 0;
         padding: 0;
         background-color: #f2f2f2;
      }

      .add-products,
      .show-products {
         display: flex;
         flex-direction: column;
         align-items: center;
         padding: 20px;
      }

      .box-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: space-evenly;
      }

      .box {
         background-color: #fff;
         border: 1px solid #ddd;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         margin: 10px;
         padding: 20px;
         width: 250px;
         font-size: 1.5rem; /* Adjusted font size */
      }

      .box img {
         max-width: 100%;
         height: auto;
      }

      .box .flex {
         display: flex;
         justify-content: space-between;
         margin-top: 10px;
      }

      .box .price {
         font-size: 1.2rem;
         color: #333;
      }

      .box .category {
         font-size: 1rem;
         color: #555;
      }

      .box .name {
         font-size: 1.2rem;
         color: #333;
         margin-top: 10px;
      }

      .flex-btn {
         display: flex;
         justify-content: space-between;
         margin-top: 10px;
      }

      .btn,
      .option-btn,
      .delete-btn {
         padding: 8px 15px;
         border-radius: 5px;
         cursor: pointer;
         text-decoration: none;
         font-size: 1rem;
         color: #fff;
      }

      .btn {
         background-color: #333;
      }

      .option-btn {
         background-color: #555;
      }

      .delete-btn {
         background-color: #ff0000;
      }

      .empty {
         text-align: center;
         font-size: rem;
         color: #555;
      }
   </style>

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add product</h3>
      <input type="text" required placeholder="Name of the product" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="Product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>select category --</option>
         <option value="Hammer">Hammer</option>
         <option value="Saw">Saw</option>
         <option value="Drivers">Drivers</option>
         <option value="Drills">Drills</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="Add" name="add_product" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">
   <style>
   .box-container {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
   }

   .box {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin: 10px;
      padding: 20px;
      width: 300px;
   }

   .box img {
      max-width: 100%;
      height: auto;
   }

   .box .flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
   }

   .box .price {
      font-size: 1.2rem;
      color: #333;
   }

   .box .category {
      font-size: 1rem;
      color: #555;
   }

   .box .name {
      font-size: 1.2rem;
      color: #333;
      margin-top: 10px;
   }

   .flex-btn {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
   }

   .btn,
   .option-btn,
   .delete-btn {
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 1rem;
      color: #fff;
   }

   .btn {
      background-color: #333;
   }

   .option-btn {
      background-color: #555;
   }

   .delete-btn {
      background-color: #ff0000;
   }

   .empty {
      text-align: center;
      font-size: 1.5rem;
      color: #555;
   }
</style>

   <?php
      $show_products = $conn->prepare("SELECT * FROM `products`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_products['price']; ?><span>/-</span></div>
         <div class="category"><?= $fetch_products['category']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>



