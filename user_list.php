<?php
@include 'config.php';

$select_users = "SELECT * FROM user_form";
$result_users = mysqli_query($conn, $select_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User List</title>

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <style>
   .user-list {
      margin-top: 20px;
   }

   .user-list table {
      width: 100%;
      border-collapse: collapse;
   }

   .user-list th, .user-list td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
   }

   .user-list th {
      background-color: #065535;
      color: white;
   }

   .user-list td a {
      margin-right: 10px;
   }

   .btn-custom {
      margin-left: 20px; /* Adjust as needed */
      color: white;
   }

   .btn-custom a {
      text-decoration: none;
      color: white;
   }

   .btn-custom a:hover {
      color: white;
   }
   </style>
</head>
<body>

<div class="container">
   <div class="content">
      <div class="user-list">
         <div class="btn-custom">
            <a href="admin_page.php" class="btn btn-danger">Admin</a>
         </div>

         <h2 style="text-align: center;">User List</h2>
         <?php if(mysqli_num_rows($result_users) > 0): ?>
            <table>
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>User Type</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php while($row = mysqli_fetch_assoc($result_users)): ?>
                     <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_type']); ?></td>
                        <td>
                           <a href="register_form.php?edit_user=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                           <a href="delete.php?delete_user=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                     </tr>
                  <?php endwhile; ?>
               </tbody>
            </table>
         <?php else: ?>
            <p>No users found.</p>
         <?php endif; ?>
      </div>
   </div>
</div>

<!-- Bootstrap JS Bundle (Bootstrap JS + Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
