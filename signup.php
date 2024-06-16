<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign Up</title>
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

// Import Validation class
include("Validation.php");

$validator = new Validation();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $fname = $validator->sanitizeInput($_POST['fname']);
    $lname = $validator->sanitizeInput($_POST['lname']);
    $address = $validator->sanitizeInput($_POST['address']);
    $nic = $validator->sanitizeInput($_POST['nic']);
    $dob = $validator->sanitizeInput($_POST['dob']);

    // Validate inputs
    $fnameValidation = $validator->validateUsername($fname); // Assuming first name should be alphanumeric
    $lnameValidation = $validator->validateUsername($lname); // Assuming last name should be alphanumeric
    $addressValidation = $validator->sanitizeInput($address); // Assuming address can contain any characters
    $nicValidation = $validator->validateUsername($nic); // Assuming NIC should be alphanumeric
    $dobValidation = $validator->validateDate($dob, 'Y-m-d'); // Assuming date of birth should be in YYYY-MM-DD format

    // Check for errors
    if ($fnameValidation !== true) {
        $error = $fnameValidation;
    } elseif ($lnameValidation !== true) {
        $error = $lnameValidation;
    } elseif ($addressValidation !== true) {
        $error = "Invalid address"; // Customize as per your validation rules
    } elseif ($nicValidation !== true) {
        $error = "Invalid NIC"; // Customize as per your validation rules
    } elseif ($dobValidation !== true) {
        $error = $dobValidation;
    } else {
        // Store personal details in session and redirect
        $_SESSION["personal"] = array(
            'fname' => $fname,
            'lname' => $lname,
            'address' => $address,
            'nic' => $nic,
            'dob' => $dob
        );

        header("location: create-account.php");
        exit();
    }
}
?>
<center>
<div class="container">
    <table border="0">
        <tr>
            <td colspan="2">
                <p class="header-text">Let's Get Started</p>
                <p class="sub-text">Add Your Personal Details to Continue</p>
            </td>
        </tr>
        <tr>
            <form action="" method="POST">
            <td class="label-td" colspan="2">
                <label for="name" class="form-label">Name: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td">
                <input type="text" name="fname" class="input-text" placeholder="First Name" required>
            </td>
            <td class="label-td">
                <input type="text" name="lname" class="input-text" placeholder="Last Name" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="address" class="form-label">Address: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="text" name="address" class="input-text" placeholder="Address" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="nic" class="form-label">NIC: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="text" name="nic" class="input-text" placeholder="NIC Number" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="dob" class="form-label">Date of Birth: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="date" name="dob" class="input-text" required>
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
                <input type="submit" value="Next" class="login-btn btn-primary btn">
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
    </table>
</div>
</center>
</body>
</html>
