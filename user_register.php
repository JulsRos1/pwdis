<?php
include('includes/config.php');
session_start();

if (isset($_POST['register'])) {
  $FirstName = $_POST['FirstName'];
  $LastName = $_POST['LastName'];
  $Barangay = $_POST['Barangay'];
  $Email = $_POST['Email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $disability_type = $_POST['disability_type'];
  $Gender = $_POST['Gender'];

  // Check if the email or username already exists in the database
  $check_query = "SELECT * FROM users WHERE Email = ? OR username = ?";
  $stmt = $con->prepare($check_query);
  $stmt->bind_param("ss", $Email, $username);
  $stmt->execute();
  $check_result = $stmt->get_result();

  if ($check_result->num_rows > 0) {
    $_SESSION['registration_error'] = "The username or email is already taken.";
    header("Location: user_register.php");
    exit;
  }

  if ($password !== $confirm_password) {
    $_SESSION['registration_error'] = "Passwords do not match.";
    header("Location: user_register.php");
    exit;
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert data into the database
  $insert_query = "INSERT INTO users (FirstName, LastName, Barangay, Email, username, password, disability_type, Gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $con->prepare($insert_query);
  $stmt->bind_param("ssssssss", $FirstName, $LastName, $Barangay, $Email, $username, $hashed_password, $disability_type, $Gender);
  $result = $stmt->execute();

  if ($result) {
    $_SESSION['registration_success'] = "Registration successful! You can now log in.";
    header("Location: user_register.php");
    exit();
  } else {
    $_SESSION['registration_error'] = "Something went wrong. Please try again.";
    header("Location: user_register.php");
    exit();
  }

  $stmt->close();
  $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/login_validation.js" defer></script>
</head>

<body>
  <div class="wrapper">
    <h1 class="mb-4">Signup</h1>

    <div class="mb-3">
      <?php if (isset($_SESSION['registration_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
          <strong>Error:</strong> <?= htmlspecialchars($_SESSION['registration_error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['registration_error']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['registration_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
          <strong>Success!</strong> <?= htmlspecialchars($_SESSION['registration_success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['registration_success']); ?>
      <?php endif; ?>
    </div>

    <!-- Signup Form -->
    <form id="form" action="user_register.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
      <!-- First Name and Last Name -->
      <div class="mb-1">
        <input type="text" class="form-control" name="FirstName" id="firstname-input" placeholder="Firstname" required>
      </div>

      <div class="mb-1">
        <input type="text" class="form-control" name="LastName" id="lastname-input" placeholder="Lastname" required>
      </div>

      <!-- Email and Username -->
      <div class="mb-1">
        <input type="email" class="form-control" name="Email" id="email-input" placeholder="Email" required>
      </div>

      <div class="mb-1">
        <input type="text" class="form-control" name="username" id="username-input" placeholder="Username" required>
      </div>

      <!-- Password and Confirm Password -->
      <div class="mb-1">
        <input type="password" class="form-control" name="password" id="password-input" placeholder="Password" required>
      </div>

      <div class="mb-1">
        <input type="password" class="form-control" name="confirm_password" id="repeat-password-input" placeholder="Repeat Password" required>
      </div>

      <!-- Barangay -->
      <div class="mb-1">
        <select name="Barangay" class="form-select" required>
          <option value="" disabled selected>Select Barangay</option>
          <option value="Anos">Anos</option>
          <option value="Bagong Silang">Bagong Silang</option>
          <option value="Bambang">Bambang</option>
          <option value="Batong Malake">Batong Malake</option>
          <option value="Baybayin">Baybayin</option>
          <option value="Bayog">Bayog</option>
          <option value="Lalakay">Lalakay</option>
          <option value="Maahas">Maahas</option>
          <option value="Malinta">Malinta</option>
          <option value="Mayondon">Mayondon</option>
          <option value="Tuntungin-Putho">Tuntungin-Putho</option>
          <option value="San Antonio">San Antonio</option>
          <option value="Tadlac">Tadlac</option>
          <option value="Timugan">Timugan</option>
        </select>
      </div>

      <!-- Disability Type -->
      <div class="mb-1">
        <select name="disability_type" class="form-select" required>
          <option value="" disabled selected>Disability Type</option>
          <option value="Deaf or Hard of Hearing">Deaf or Hard of Hearing</option>
          <option value="Intellectual Disability">Intellectual Disability</option>
          <option value="Learning Disability">Learning Disability</option>
          <option value="Physical Disability">Physical Disability</option>
          <option value="Psychosocial Disability">Psychosocial Disability</option>
          <option value="Speech and Language Impairment">Speech and Language Impairment</option>
          <option value="Visual Disability">Visual Disability</option>
          <option value="Cancer(RA 11215)">Cancer (RA 11215)</option>
          <option value="Rare Disease(RA 10747)">Rare Disease (RA 10747)</option>
        </select>
      </div>

      <!-- Gender -->
      <div class="mb-1">
        <select name="Gender" class="form-select" required>
          <option value="" disabled selected>Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Others">Others</option>
        </select>
      </div>

      <button type="submit" name="register" class="btn btn-primary w-100">Signup</button>
    </form>

    <p class="already">Already have an Account? <a href="user_login.php">Login</a></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
