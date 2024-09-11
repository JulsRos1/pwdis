<?php
session_start();
include('includes/config.php');

if (isset($_SESSION['user_login'])) {
    // Redirect the user to another page, for example, index.php
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    $usernameOrEmail = ($_POST['usernameOrEmail']);
    $password = ($_POST['password']);

    // Fetch user data from the database by username or email
    $query = "SELECT * FROM users WHERE username = '$usernameOrEmail' OR Email = '$usernameOrEmail'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Check the user's approval status
        $approvalStatus = $row['status'];
        if ($approvalStatus != 'Approved') {
            echo "Error: Your account is not yet approved. Please wait for approval.";
            exit;
        }

        $hashed_password = $row['password'];

        // Verify the entered password
        if (password_verify($password, $hashed_password)) {
            echo "Login successful!";
            $_SESSION['user_login'] = true;
            $_SESSION['user'] = ($row['username']);
            $_SESSION['name'] = ($row['FirstName']);
            $_SESSION['lname'] = ($row['LastName']);
            $_SESSION['Email'] = ($row['Email']);

            header("Location: index.php");
            die;
            // You can redirect the user to the dashboard or any other page here
        } else {
            echo "Error: Incorrect password.";
        }
    } else {
        echo "Error: User not found.";
    }
}

$con->close();
?>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="css/login.scss">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ffffff">

</head>

<body>
    <form class="login-form" method="POST">
        <p class="login-text">
            <span class="fa-stack fa-lg">
                <i class="fa fa-circle fa-stack-2x"></i>
                <i class="fa fa-lock fa-stack-1x"></i>
            </span>
        </p>
        <input type="text" class="login-username" autofocus="true" required="true" placeholder="Username or Email" name="usernameOrEmail" />
        <input type="password" class="login-password" required="true" placeholder="Password" name="password" />
        <input type="submit" name="login" class="login-submit" />
    </form>
    <a href="#" class="login-forgot-pass">forgot password?</a>
    <div class="underlay-photo"></div>
    <div class="underlay-black"></div>


</body>

</html>