<?php
@include 'config.php';

// Initialize variables
$name = '';
$email = '';
$password = '';
$confirm_password = '';
$user_type = '';

$errors = array(); // Initialize error array

// Check if editing a user
if(isset($_GET['edit_user'])) {
   $user_id = mysqli_real_escape_string($conn, $_GET['edit_user']);
   $select_user = "SELECT * FROM user_form WHERE id = '$user_id'";
   $result_user = mysqli_query($conn, $select_user);

   if(mysqli_num_rows($result_user) > 0) {
      $user = mysqli_fetch_assoc($result_user);
      $name = $user['name'];
      $email = $user['email'];
      $user_type = $user['user_type'];
   } else {
      // Handle if user with specified ID is not found
      $errors[] = 'User not found.';
   }
}

// Handle form submission
if(isset($_POST['submit'])) {
   // Process form data
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $user_type = $_POST['user_type'];

   // Perform basic validation
   if(empty($name) || empty($email) || empty($user_type)) {
      $errors[] = 'Name, Email, and User Type are required fields.';
   }

   if(!isset($_GET['edit_user']) && (empty($_POST['password']) || empty($_POST['cpassword']))) {
      $errors[] = 'Password and Confirm Password are required for new registrations.';
   }

   if(isset($_GET['edit_user']) && (!empty($_POST['password']) || !empty($_POST['cpassword']))) {
      $password = $_POST['password'];
      $confirm_password = $_POST['cpassword'];

      if($password !== $confirm_password) {
         $errors[] = 'Passwords do not match.';
      }
   }

   // Check if email already exists (excluding current user for updates)
   if(isset($_GET['edit_user'])) {
      $check_email = "SELECT * FROM user_form WHERE email = '$email' AND id != '$user_id'";
   } else {
      $check_email = "SELECT * FROM user_form WHERE email = '$email'";
   }

   $result_email = mysqli_query($conn, $check_email);

   if(mysqli_num_rows($result_email) > 0) {
      $errors[] = 'Email already exists.';
   }

   // If no errors, proceed to update or insert into database
   if(empty($errors)) {
      if(isset($_GET['edit_user'])) {
         // Update user details
         $update_query = "UPDATE user_form SET name = '$name', email = '$email', user_type = '$user_type'";
         if(!empty($password)) {
            $update_query .= ", password = '$password'";
         }
         $update_query .= " WHERE id = '$user_id'";

         if(mysqli_query($conn, $update_query)) {
            header('location: successupdate.php'); // Redirect to successupdate.php after successful update
            exit();
         } else {
            $errors[] = 'Error updating user: ' . mysqli_error($conn);
         }
      } else {
         // Insert new user
         $password = $_POST['password']; // Assuming you want to store plain text password
         $insert_query = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')";
         if(mysqli_query($conn, $insert_query)) {
            header('location: login_form.php'); // Redirect to login_form.php after successful registration
            exit();
         } else {
            $errors[] = 'Error inserting user: ' . mysqli_error($conn);
         }
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
   <title><?php echo isset($_GET['edit_user']) ? 'Edit User' : 'Register form'; ?></title>

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3><?php echo isset($_GET['edit_user']) ? 'Edit User' : 'Register Now'; ?></h3>
      <?php
      if(!empty($errors)){
         foreach($errors as $err){
            echo '<span class="error-msg">'.$err.'</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="Enter your name" value="<?php echo htmlspecialchars($name); ?>">
      <input type="email" name="email" required placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
      <?php if(!isset($_GET['edit_user'])): ?>
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <?php endif; ?>
      <select name="user_type">
         <option value="user" <?php if($user_type === 'user') echo 'selected'; ?>>User</option>
         <option value="admin" <?php if($user_type === 'admin') echo 'selected'; ?>>Admin</option>
      </select>
      <input type="submit" name="submit" value="<?php echo isset($_GET['edit_user']) ? 'Update' : 'Register Now'; ?>" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>

</div>

</body>
</html>
