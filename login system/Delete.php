
<?php
// Include database connection
include 'config.php';

if(isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    
    // Prepare and execute the DELETE statement
    $delete_query = "DELETE FROM user_form WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    
    // Check if deletion was successful
    if(mysqli_stmt_affected_rows($stmt) > 0) {
        echo "User deleted successfully.";
    } else {
        echo "Error: User could not be deleted.";
    }
    
    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Handle case where no user ID is provided
    echo "Error: User ID not provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Delete Successful</title>
  
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .message {
         margin: 20px;
         padding: 20px;
         border: 1px solid #ccc;
         background-color:#04aa6d;
         text-align: center;
         color:white;

      }
   </style>
</head>
<body>

<div class="container">
   <div class="content">
      <div class="message">
         <h2>Delete Successful</h2>
         <p>The user has been deleted successfully.</p>
         <a href="user_list.php" class="btn" style="background-color:#cf9d4e; transition: background-color 0.3s ease;"
            onmouseover="this.style.backgroundColor='#cf9d4e'"
            onmouseout="this.style.backgroundColor='#94002e'">Back to User List</a>
         
      </div>
   </div>
</div>

</body>
</html>
