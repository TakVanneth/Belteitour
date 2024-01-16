<?php
session_start();
include '../Connection/conn.php';
if (!isset($_SESSION['userID']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'Manager')) {
    header('Location: login.php');
    exit();
}
$errorMsg = ""; // Initialize error message

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lastname = $_POST["lastname"];
        $firstname = $_POST["firstname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $mainRole = $_POST["mainRole"];

        // Hash the password using a secure hashing algorithm (e.g., bcrypt)
        // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $hashedPassword = md5($password);

        // Concatenate first name and last name to create the full name
        $fullName = $firstname . ' ' . $lastname;

        // Insert user data into the 'user' table
        $insertSql = "INSERT INTO `user` (`name`, `username`, `email`, `password`, `role`)
                      VALUES ('$fullName', '$username', '$email', '$hashedPassword', '$mainRole')";

        $insertResult = $conn->query($insertSql);

        if ($insertResult === false) {
            throw new Exception("Database query error: " . $conn->error);
        }

        // Fetch user data
        $userID = $conn->insert_id;
        $createdDate = date("Y-m-d H:i:s");

        // Store user data in session
        $_SESSION['userID'] = $userID;
        $_SESSION['name'] = $fullName;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $mainRole;
        $_SESSION['createdDate'] = $createdDate;

        // Redirect to index.php
        header('Location: index.php');
        exit();
    }
} catch (Exception $e) {
    $errorMsg = "An error occurred: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/util.css">
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
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title"
                 style="background-image: url(https://www.beltei.edu.kh/biue/images/homepics/document/beltei_international_university_in_cambodia_building.jpg);">
                <span class="login100-form-title-1">
                    Sign Up
                </span>
            </div>

            <form class="login100-form validate-form" method="post" action="signup.php">
                <div class="wrap-input100 validate-input m-b-26" data-validate="Lastname is required">
                    <span class="label-input100">Last Name</span>
                    <input class="input100" type="text" name="lastname" placeholder="Enter Last Name">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Firstname is required">
                    <span class="label-input100">First Name</span>
                    <input class="input100" type="text" name="firstname" placeholder="Enter First Name">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Username</span>
                    <input class="input100" type="text" name="username" placeholder="Enter username">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="email" name="email" placeholder="Enter email">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password" placeholder="Enter password">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Select a main role">
                    <span class="label-input100">Main Role</span>
                    <select class="input100" name="mainRole">
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                    <span class="focus-input100"></span>
                </div>

                <!-- Display error message under the password input -->
                <?php if ($errorMsg !== "") : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMsg; ?>
                    </div>
                <?php endif; ?>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../public/js/login.js"></script>
</body>
</html>
