<?php
@include 'config.php';

session_start();

// Redirect to login if admin session is not set
if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- Custom CSS file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Inline styles */
        .user-list {
            margin-top: 20px;
        }

        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-list th,
        .user-list td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .user-list th {
            background-color: #f2f2f2;
        }

        .user-list td a {
            margin-right: 10px;
        }

        .success-msg {
            color: green;
        }

        .error-msg {
            color: red;
        }
 
      
    </style>
</head>

<body>

    <div class="container">

        <div class="content">
            <h3>Hi, <span>Admin</span></h3>
            <h1>Welcome <span style="color:#94002e;"><?php echo $_SESSION['admin_name'] ?></span></h1>
            <p>This is the admin page.</p>
            
            <a href="user_list.php" class="btn" style="background-color:#cf9d4e; transition: background-color 0.3s ease;"
            onmouseover="this.style.backgroundColor='#94002e'"
            onmouseout="this.style.backgroundColor='#04aa6d'">User Page</a>

            <a href="register_form.php" class="btn" style="background-color:#cf9d4e; transition: background-color 0.3s ease;"
            onmouseover="this.style.backgroundColor='#94002e'"
            onmouseout="this.style.backgroundColor='#04aa6d'">Register</a>
           
            
            <a href="logout.php" class="btn" style="background-color:#cf9d4e; transition: background-color 0.3s ease;"
            onmouseover="this.style.backgroundColor='#94002e'"
            onmouseout="this.style.backgroundColor='#04aa6d'">Logout</a>
           
          
        </div>

    </div>

</body>

</html>
