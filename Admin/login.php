<?php
session_start(); // Start the session
include '../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hasPassword = md5($password);

    $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$hasPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();

        // Store user data in session
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['createdDate'] = $row['createdDate'];

        // Redirect to index.php
        header('Location: index.php');
        exit();
    } else {
        echo "Invalid email or password";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      max-width: 400px;
      margin: 100px auto;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="login-container">
    <h2 class="text-center mb-4">Login</h2>
    <form method="post" action="login.php">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Login</button>
</form>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
