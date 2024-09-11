<?php
session_start();
include('includes/config.php');

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
    $new_username = $_POST['username'];

    // Update username
    $update_query = "UPDATE users SET username = '$new_username' WHERE id = '$user_id'";
    if (mysqli_query($con, $update_query)) {
        $_SESSION['user'] = $new_username; // Update session username
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }

    // Upload new profile picture
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);

        // Validate and move the file to the uploads directory
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            // Update the avatar_url in the database
            $update_avatar_query = "UPDATE users SET avatar_url = '$target_file' WHERE id = '$user_id'";
            if (mysqli_query($con, $update_avatar_query)) {
                echo "Profile picture updated successfully!";
            } else {
                echo "Error updating profile picture: " . mysqli_error($con);
            }
        } else {
            echo "Error uploading profile picture.";
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
        if ($new_password == $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_password_query = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
            if (mysqli_query($con, $update_password_query)) {
                echo "Password updated successfully!";
            } else {
                echo "Error updating password: " . mysqli_error($con);
            }
        } else {
            echo "Error: New passwords do not match.";
        }
    } else {
        echo "Error: Incorrect current password.";
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
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>

    <h2>Profile Page</h2>

    <div class="profile-section">
        <h3>Update Profile</h3>
        <form method="POST" enctype="multipart/form-data">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $userData['username']; ?>" required>
            </div>

            <div>
                <label for="avatar">Profile Picture:</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
                <br>
                <img src="<?php echo $userData['avatar_url']; ?>" alt="Profile Picture" width="100" height="100">
            </div>

            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </div>

    <div class="password-section">
        <h3>Change Password</h3>
        <form method="POST">
            <div>
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password">Change Password</button>
        </form>
    </div>

</body>

</html>