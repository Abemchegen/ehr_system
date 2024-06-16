<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Image Upload</title>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         .upload-form {
            display: flex;
            align-items: center;
        }

        .custom-file-label {
            display: inline-block;
            cursor: pointer;
            color: white;
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 5px;
            text-align: center;
            font-size: 12px; /* Adjust font size */
        }

        .custom-file-label i {
            margin-right: 5px;
            font-size: 14px; /* Adjust icon size */
        }

        .custom-file-input {
            display: none;
        }
    </style>
</head>
<body>

<div class="menu">
    <table class="menu-container" border="0">
        <tr>
            <td style="padding:10px" colspan="2">
                <table border="0" class="profile-container">
                    <tr>
                        <td width="30%" style="padding-left:20px">
                            <?php
                            // Assuming $useremail and $username are set somewhere in your code
                            $userEmail = $_SESSION['user']; // Retrieve user's email from session
                            $tableName = '';
                            $imageColumnName = 'image'; // Column name where image path is stored

                            // Determine table name based on usertype
                            if ($_SESSION['usertype'] == 'a') {
                                $tableName = 'admin';
                                $emailColumnName = 'aemail';
                            } elseif ($_SESSION['usertype'] == 'd') {
                                $tableName = 'doctor';
                                $emailColumnName = 'docemail';
                            } elseif ($_SESSION['usertype'] == 'p') {
                                $tableName = 'patient';
                                $emailColumnName = 'pemail';
                            }

                            // Fetch image path from database
                            $selectSql = "SELECT $imageColumnName FROM $tableName WHERE $emailColumnName = ?";
                            $stmt = $database->prepare($selectSql);
                            $stmt->bind_param("s", $userEmail);
                            $stmt->execute();
                            $stmt->bind_result($imagePath);
                            $stmt->fetch();
                            $stmt->close();

                            // Construct the image path
                            $imagePath = !empty($imagePath) ? '../' . $imagePath : '../img/user.png';

                            // Display profile image
                            echo '<img src="' . htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8') . '" alt="Profile Image" style="width:50px; height:50px; border-radius:50%;">';
                            ?>
                        </td>
                        <td style="padding:0px;margin:0px;">
                            <p class="profile-title"><?php echo substr($username, 0, 13); ?>..</p>
                            <p class="profile-subtitle"><?php echo substr($useremail, 0, 22); ?></p>

                            <!-- Form for image upload -->
                            <form action="../upload.php" method="post" enctype="multipart/form-data" class="upload-form">
                                <label for="profile_image" class="custom-file-label">
                                    <i class="fas fa-image"></i> Choose Image
                                </label>
                                <input type="file" name="profile_image" id="profile_image" class="custom-file-input" accept="image/*">
                                <label for="submit" class="custom-file-label">
                                    <i class="fas fa-upload"></i> Upload
                                </label>
                                <input type="submit" id="submit" class="custom-file-input" value="Upload Image" name="submit">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-home ">
                <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></div></a>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                <a href="doctors.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">All Doctors</p></div></a>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-session">
                <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-appoinment">
                <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
            </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-settings">
                <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
