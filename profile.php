<?php
session_start();
include('includes/config.php');

// Initialize variables for alert messages
$alert = '';
$alert_type = '';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_login'])) {
    header("Location: user_login.php");
    exit;
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($con, $query);
$userData = mysqli_fetch_assoc($result);

// Update profile information
if (isset($_POST['update_profile'])) {
    $new_username = mysqli_real_escape_string($con, $_POST['username']);

    // Update username
    $update_query = "UPDATE users SET username = '$new_username' WHERE id = '$user_id'";
    if (mysqli_query($con, $update_query)) {
        $_SESSION['user'] = $new_username; // Update session username
        $alert = "Profile updated successfully!";
        $alert_type = "success";
    } else {
        $alert = "Error updating profile: " . mysqli_error($con);
        $alert_type = "danger";
    }

    // Upload new profile picture
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['avatar']['type'], $allowed_types)) {
            $target_dir = "uploads/";
            // Ensure unique file name
            $file_ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $target_file = $target_dir . 'avatar_' . $user_id . '.' . $file_ext;

            // Validate and move the file to the uploads directory
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                // Update the avatar_url in the database
                $update_avatar_query = "UPDATE users SET avatar_url = '$target_file' WHERE id = '$user_id'";
                if (mysqli_query($con, $update_avatar_query)) {
                    $alert = "Profile picture updated successfully!";
                    $alert_type = "success";
                    $userData['avatar_url'] = $target_file; // Update the local variable to reflect the change
                    $_SESSION['avatar_url'] = $target_file; // Store the avatar URL in the session
                    
                    
                } else {
                    $alert = "Error updating profile picture: " . mysqli_error($con);
                    $alert_type = "danger";
                }
            } else {
                $alert = "Error uploading profile picture.";
                $alert_type = "danger";
            }
        } else {
            $alert = "Invalid file type for profile picture. Allowed types: JPEG, PNG, GIF.";
            $alert_type = "danger";
        }
    }
}

// Change password
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (password_verify($current_password, $userData['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_password_query = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
            if (mysqli_query($con, $update_password_query)) {
                $alert = "Password updated successfully!";
                $alert_type = "success";
            } else {
                $alert = "Error updating password: " . mysqli_error($con);
                $alert_type = "danger";
            }
        } else {
            $alert = "Error: New passwords do not match.";
            $alert_type = "danger";
        }
    } else {
        $alert = "Error: Incorrect current password.";
        $alert_type = "danger";
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .input-group .form-control {
            border-radius: 8px;
            border-right: none;
        }

        button {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            color: white;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            border-radius: 50%;
            margin-bottom: 1em;
            width: 120px;
            height: 120px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .profile-section,
        .password-section {
            margin-bottom: 40px;
        }

        .profile-section h3,
        .password-section h3 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .profile-section .btn-primary,
        .password-section .btn-primary {
            width: auto;
            padding: 10px 30px;
            border-radius: 8px;
        }

        .home-button {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            img {
                width: 100px;
                height: 100px;
            }

            button {
                font-size: 14px;
                padding: 8px 20px;
            }

            .home-button {
                left: 10px;
                top: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Home Button -->
    <a href="index.php" class="btn btn-light home-button">
        <i class="fas fa-home"></i> Home
    </a>

    <div class="container">
        <!-- Alert Section -->
        <?php if ($alert != '') : ?>
            <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $alert; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2><i class="fas fa-user-circle"></i> Profile Page</h2>

        <!-- Update Profile Section -->
        <div class="profile-section">
            <h3><i class="fas fa-user-edit"></i> Update Profile</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <img src="<?php echo $userData['avatar_url']; ?>" alt="Profile Picture">
                    <br>
                    <label for="username">Username:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" id="username" name="username" value="<?php echo $userData['username']; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="avatar">Profile Picture:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-camera"></i></span>
                        <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                    </div>
                </div>

                <button type="submit" name="update_profile" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button>
            </form>
        </div>

        <!-- Change Password Section -->
        <div class="password-section">
            <h3><i class="fas fa-key"></i> Change Password</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                </div>

                <button type="submit" name="change_password" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Change Password</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
