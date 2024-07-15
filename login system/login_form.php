<?php
@include 'config.php';

session_start();

$error = array(); // Initialize error array

if(isset($_POST['submit'])){
   
   // Check if the required fields are set
   if(isset($_POST['email'], $_POST['password'])){
      
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = $_POST['password']; // Assuming password stored in plain text in the database for this example

      // Query to fetch user based on email and password (assuming plain text storage for demo)
      $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$password'";
      $result = mysqli_query($conn, $select);

      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);

         // Start session and set session variables
         $_SESSION['user_id'] = $row['user_id']; // Assuming 'user_id' is a primary key or unique identifier
         $_SESSION['user_type'] = $row['user_type']; // Assuming 'user_type' determines admin or user role

         // Set cookie for remembering user (optional)
         if(isset($_POST['remember']) && $_POST['remember'] == 'on'){
            setcookie('remember_user', $email, time() + (30 * 24 * 3600), '/'); // Cookie valid for 30 days
         } else {
            if(isset($_COOKIE['remember_user'])){
               setcookie('remember_user', '', time() - 3600, '/'); // Expire cookie if 'remember' unchecked
            }
         }

         // Redirect based on user_type
         if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = isset($row['name']) ? $row['name'] : '';
            header('Location: admin_page.php');
            exit(); // Terminate script after redirection
         } elseif($row['user_type'] == 'user'){
            $_SESSION['user_name'] = isset($row['name']) ? $row['name'] : '';
            header('Location: user_page.php');
            exit(); // Terminate script after redirection
         }
      } else {
         $error[] = 'Incorrect email or password!';
      }
   } else {
      $error[] = 'Email and password are required!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Login now</h3>
      <?php
      if(!empty($error)){
         foreach($error as $error_msg){
            echo '<span class="error-msg">'.$error_msg.'</span>';
         }
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <label><input type="checkbox" name="remember"> Remember me</label>
      <input type="submit" name="submit" value="Login now" class="form-btn">
      <p>Don't have an account? <a href="register_form.php">Register now</a></p>
   </form>

</div>

</body>
</html>
