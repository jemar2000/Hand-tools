<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo"><img src="images/logos.png"></a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About</a>
         <a href="products_c.php">Products</a>
         <a href="orders.php">Orders</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php">Cartz</i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         
         <style>
            .profile {
             display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            margin-top: -10%;
            left: 80%;
            
            font-family: Arial, sans-serif;
            }


            .profile .name {
                font-size: 2rem;
                color: var(--black);
                margin-right: 1rem;
                text-decoration: underline;
                margin-bottom: 10%;
            }

            .profile .flex {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-top: 1rem;
               
            }

            .profile .btn {
                text-decoration: none;
                color: var(--black);
                padding: 0.5rem 1rem;
                margin-bottom: 0.5rem;
            }

            .profile .btn:hover {
                background-color: #ddd;
            }
        </style>


         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="history.php" class="btn">History</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         <p class="account">
            <a href="login.php">login</a> or
            <a href="register.php">register</a>
         </p> 
         <?php
            }else{
         ?>
            <p class="name">You need to login!</p>
            <a href="login.php" class="btn">Login</a>
         <?php
          }
         ?>
         <style>
            .profile {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            margin-top: -10%;
            left: 85%;
            
            font-family: Arial, sans-serif;
            }
         </style>
      </div>

   </section>

</header>

