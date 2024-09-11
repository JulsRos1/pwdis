<?php
include('includes/config.php');



if (isset($_POST['register'])) {
    $FirstName = ($_POST['FirstName']);
    $LastName = ($_POST['LastName']);
    $Barangay = ($_POST['Barangay']);
    $blk_lot = ($_POST['blk_lot']);
    $Email = ($_POST['Email']);
    $username = ($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email or username already exists in the database
    $check_query = "SELECT * FROM users WHERE Email = '$Email' OR username = '$username'";
    $check_result = mysqli_query($con, $check_query);
    // Retrieve the confirm password and verify it
    $confirm_password = $_POST['confirm_password'];
    if (!password_verify($confirm_password, $password)) {
        echo "Error: Passwords do not match.";
        exit;
    } else {
        // Insert data into the database
        $query = "INSERT INTO users (FirstName, LastName, Barangay, blk_lot, Email, username, password) VALUES ('$FirstName', '$LastName',  '$Barangay', '$blk_lot', '$Email', '$username',  '$password')";
        $result = mysqli_query($con, $query);

        if ($result === TRUE) {
            echo "Registration successful! Your account is Pending for Approval, We will notify you if your account is Approved.";
        } else {
            echo "Error: " . $query . "<br>" . $con->error;
        }
    }
}

$con->close();

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-Register</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #3498db, #2c3e50);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            align-content: center;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            transition: background-color 0.3s ease;
            margin-top: 20em;
            margin-left: 5em;
            margin-right: 5em;

        }

        .container:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        .form-control {
            margin-bottom: 5px;
        }

        h4 {
            color: #3498db;
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }

        button.btn-primary {
            background-color: #3498db;
            border: none;
            width: 100%;
        }

        button.btn-primary:hover {
            background-color: #2980b9;
        }

        .row {
            margin-bottom: 15px;
        }

        .fa-user-plus {
            margin-right: 8px;
        }
    </style>

</head>


<body>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h4>Information</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="First Name" name="FirstName">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Last Name" name="LastName">
                </div>
            </div>



            <h4>Address</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <select class="form-select form-control" name="Barangay">
                        <option selected>Barangay</option>
                        <option value="Lalakay">Lalakay</option>
                        <option value="Mayondon">Mayondon</option>
                        <option value="Bayog">Bayog</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Blk & Lot" name="blk_lot">
                </div>
            </div>

            <h4>Login Credentials</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="email" class="form-control" placeholder="Email" name="Email">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Username" name="username">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
                <div class="col-md-6">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                </div>
            </div>


            <button type="submit" class="btn btn-primary" name="register"><i class="fas fa-user-plus"></i> Register</button>
        </form>
    </div>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>