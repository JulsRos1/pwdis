<?php
session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
if (isset($_SESSION['login'])) {
  header("Location:Dashboard.php");
}
if (isset($_POST['login'])) {

  // Getting username/ email and password
  $uname = $_POST['username'];
  $password = $_POST['password'];
  // Fetch data from database on the basis of username/email and password
  $sql = mysqli_query($con, "SELECT AdminUserName,AdminEmailId,AdminPassword FROM tbladmin WHERE (AdminUserName='$uname' || AdminEmailId='$uname')");
  $num = mysqli_fetch_array($sql);
  if ($num > 0) {
    $hashpassword = $num['AdminPassword']; // Hashed password fething from database
    //verifying Password
    if (password_verify($password, $hashpassword)) {
      $_SESSION['login'] = $_POST['username'];
      echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else {
      echo "<script>alert('Wrong Password');</script>";
    }
  }
  //if username or email not found in database
  else {
    echo "<script>alert('User not registered with us');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script type="text/javascript" src="js/login_validation.js" defer></script>
</head>

<body>
  <div class="wrapper">
    <h1>Login</h1>
    <p id="error-message"></p>
    <form id="form" method="POST">
      <div>
        <label for="email-input">
          <span>@</span>
        </label>
        <input type="text" name="username" id="email-input" placeholder="username">
      </div>
      <div>
        <label for="password-input">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="24"
            viewBox="0 -960 960 960"
            width="24">
            <path
              d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
          </svg>
        </label>
        <input
          type="password"
          name="password"
          id="password-input"
          placeholder="password" />
      </div>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</body>

</html>