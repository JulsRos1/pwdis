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
      $_SESSION['user_id'] = $row['id'];
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




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css" />
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
        <input type="text" name="usernameOrEmail" id="email-input" placeholder="Username or Email">
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
          placeholder="Password" />
      </div>
      <button type="submit" name="login">Login</button>
    </form>
    <p>New here? <a href="user_register.php">Create an Account</a></p>
  </div>
</body>

</html>