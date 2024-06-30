<?php
@include 'config.php';

// Initialize variables
$name = '';
$email = '';
$password = '';
$confirm_password = '';
$user_type = '';

$error = array(); // Initialize error array

if(isset($_POST['submit'])){
   
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];
   $confirm_password = $_POST['cpassword'];
   $user_type = $_POST['user_type'];

   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists!';
   } else {
      if($password != $confirm_password){
         $error[] = 'Passwords do not match!';
      } else {
         // Inserting password as plain text (not recommended)
         $insert = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register form</title>

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register now</h3>
      <?php
      if(!empty($error)){
         foreach($error as $err){
            echo '<span class="error-msg">'.$err.'</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="Enter your name" value="<?php echo htmlspecialchars($name); ?>">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <select name="user_type">
         <option value="user" <?php if($user_type === 'user') echo 'selected'; ?>>User</option>
         <option value="admin" <?php if($user_type === 'admin') echo 'selected'; ?>>Admin</option>
      </select>
      <input type="submit" name="submit" value="Register now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>

</div>

</body>
</html>
