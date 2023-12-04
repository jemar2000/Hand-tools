
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
      body {
         font-family: Arial, sans-serif;
         margin: 0;
         background-color: #f2f2f2;
      }

      .header {
         background-color: #fff;
         padding: 10px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .flex {
         display: flex;
         align-items: center;
         justify-content: space-between;
      }

      .logo {
         font-size: 1.5rem;
         color: #333;
         text-decoration: none;
      }

      .logo span {
         color: #666;
      }

      .navbar {
         display: flex;
      }

      .navbar a {
         text-decoration: none;
         color: #555;
         margin: 0 15px;
         font-size: 1rem;
      }

      .icons {
         display: flex;
         align-items: center;
      }

      .icons i {
         cursor: pointer;
         font-size: 1.5rem;
         margin-left: 10px;
      }

      .profile {
         position: relative;
         display: flex;
         align-items: center;
      }

      .profile p {
         margin-right: 10px;
         font-size: 1rem;
         color: #333;
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

   </style>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-8t7aH0S++CvHR0fFGQzhUavE8wFGbbuL4QdAcRr/Jt4Whdu0Gl2U/CA5e9D0WuvU7BZpZUm3I3iSKS1F5rgRvA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <title>Simple Header</title>
</head>

<body>

   <header class="header">

      <section class="flex">

         <a href="dashboard.php" class="logo">Hi Admin<span>,</span></a>

         <nav class="navbar">
            <a href="dashboard.php">Home</a>
            <a href="products.php">Products</a>
            <a href="placed_orders.php">Orders</a>
            <a href="admin_accounts.php">Odmins</a>
            <a href="users_accounts.php">Users</a>
            <a href="messages.php">Messages</a>
         </nav>

        

         <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><?= $fetch_profile['name']; ?></p>
            <a href="update_profile.php" class="btn">update profile</a>
            <div class="flex-btn">
               <a href="admin_login.php" class="option-btn">login</a>
               <a href="register_admin.php" class="option-btn">register</a>
            </div>
            <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>

      </section>

   </header>

</body>

</html>
