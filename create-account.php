<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <title>Create Account</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<?php
session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

// Set the new timezone
date_default_timezone_set('Africa/Addis_Ababa');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

// Import database and validation classes
include("connection.php");
include("Validation.php");

$validator = new Validation();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $email = $validator->sanitizeInput($_POST['newemail']);
    $tele = $validator->sanitizeInput($_POST['tele']);
    $newpassword = $validator->sanitizeInput($_POST['newpassword']);
    $cpassword = $validator->sanitizeInput($_POST['cpassword']);
    
    // Validate inputs
    $emailValidation = $validator->validateEmail($email);
    $phoneValidation = $validator->validatePhoneNumber($tele);
    $passwordValidation = $validator->validatePassword($newpassword);
    $passwordMatchValidation = $validator->passwordsMatch($newpassword, $cpassword);

    // Check for validation errors
    if ($emailValidation !== true) {
        $error = $emailValidation;
    } elseif ($phoneValidation !== true) {
        $error = $phoneValidation;
    } elseif ($passwordValidation !== true) {
        $error = $passwordValidation;
    } elseif ($passwordMatchValidation !== true) {
        $error = $passwordMatchValidation;
    } else {
        // Proceed with database operations
        $result = $database->query("SELECT * FROM user WHERE email='$email'");
        
        if ($result->num_rows == 1) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        } else {
            $fname = $_SESSION['personal']['fname'];
            $lname = $_SESSION['personal']['lname'];
            $name = $fname . " " . $lname;
            $address = $_SESSION['personal']['address'];
            $nic = $_SESSION['personal']['nic'];
            $dob = $_SESSION['personal']['dob'];

            $database->query("INSERT INTO patient(pemail, pname, ppassword, paddress, pnic, pdob, ptel) VALUES('$email', '$name', '$newpassword', '$address', '$nic', '$dob', '$tele')");
            $database->query("INSERT INTO user(email, usertype) VALUES('$email', 'p')");

            $_SESSION["user"] = $email;
            $_SESSION["usertype"] = "p";
            $_SESSION["username"] = $fname;

            header('Location: patient/index.php');
            exit();
        }
    }
}
?>
<center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <p class="header-text">Let's Get Started</p>
                    <p class="sub-text">It's Okey, Now Create User Account.</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST">
                <td class="label-td" colspan="2">
                    <label for="newemail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="newemail" class="input-text" placeholder="Email Address" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="tele" class="form-label">Mobile Number: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="tel" name="tele" class="input-text" placeholder="ex: 0712345678" pattern="[0]{1}[0-9]{9}" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="newpassword" class="form-label">Create New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Confirm Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <span style="color: red;"><?php echo $error; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                </td>
                <td>
                    <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>
                </form>
            </tr>
        </table>
    </div>
</center>
</body>
</html>
