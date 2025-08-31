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
    echo "Error: The username or email is already taken.";
    exit;
  }

  if ($password !== $confirm_password) {
    echo "Error: Passwords do not match.";
    exit;
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert data into the database
  $insert_query = "INSERT INTO users (FirstName, LastName, Barangay, Email, username, password, disability_type, Gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $con->prepare($insert_query);
  $stmt->bind_param("ssssssss", $FirstName, $LastName, $Barangay, $Email, $username, $hashed_password, $disability_type, $Gender);
  $result = $stmt->execute();

  if ($result) {
    $_SESSION['registration_success'] = true;
    header("Location: user_login.php");
    exit();
  } else {
    $_SESSION['registration_error'] = $stmt->error;
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
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/login_validation.js" defer></script>
</head>

<body>
  <div class="wrapper">
    <h1>Signup</h1>
    <?php
    if (isset($_SESSION['registration_error'])) {
      echo '<div class="alert alert-danger">' . $_SESSION['registration_error'] . '</div>';
      unset($_SESSION['registration_error']);
    }
    ?>
    <p id="error-message"></p>

    <!-- Send data to user_register.php for processing -->
    <form id="form" action="user_register.php" method="POST" enctype="multipart/form-data">
      <!-- First Name and Last Name -->
      <div>
        <label for="firstname-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z" />
          </svg>
        </label>
        <input type="text" name="FirstName" id="firstname-input" placeholder="Firstname" required>
      </div>

      <div>
        <label for="lastname-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z" />
          </svg>
        </label>
        <input type="text" name="LastName" id="lastname-input" placeholder="Lastname" required>
      </div>

      <!-- Email and Username -->
      <div>
        <label for="email-input"><span>@</span></label>
        <input type="email" name="Email" id="email-input" placeholder="Email" required>
      </div>

      <div>
        <label for="username-input"><span>@</span></label>
        <input type="text" name="username" id="username-input" placeholder="Username" required>
      </div>

      <!-- Password and Confirm Password -->
      <div>
        <label for="password-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Z" />
          </svg>
        </label>
        <input type="password" name="password" id="password-input" placeholder="Password" required>
      </div>

      <div>
        <label for="repeat-password-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Z" />
          </svg>
        </label>
        <input type="password" name="confirm_password" id="repeat-password-input" placeholder="Repeat Password" required>
      </div>

      <!-- Barangay -->
      <div class="column">
        <div>
          <label for="barangay" class="sr-only">Barangay</label>
          <select name="Barangay" id="select-input" required>
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
        <!-- Barangay -->
        <div>
          <label for="disability_type" class="sr-only">Barangay</label>
          <select name="disability_type" id="select-input" required>
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
      </div>
      <!-- Barangay -->
      <div class="column">
        <div>
          <label for="Gender" class="sr-only">Barangay</label>
          <select name="Gender" id="select-input" required>
            <option value="" disabled selected>Gender</option>
            <option value="Anos">Male</option>
            <option value="Anos">Female</option>
            <option value="Anos">Others</option>

          </select>
        </div>

      </div>

      <button type="submit" name="register">Signup</button>
    </form>

    <p class="already">Already have an Account? <a href="user_login.php">Login</a></p>
  </div>
</body>

</html>