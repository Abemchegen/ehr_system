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

        .menu-container {
            width: 100%;
        }

        .menu-row {
            width: 100%;
        }

        .menu-btn {
            padding: 10px;
        }

        .menu-text {
            margin: 0;
        }

        .menu-active {
            border-left: 5px solid #007bff;
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

        <?php
        $currentPage = basename($_SERVER['SCRIPT_NAME']);
        $menuItems = [
            'index.php' => 'Home',
            'doctors.php' => 'All Doctors',
            'schedule.php' => 'Scheduled Sessions',
            'appointment.php' => 'My Bookings',
            'settings.php' => 'Settings'
        ];
        $menuIcons = [
            'index.php' => 'home',
            'doctors.php' => 'doctor',
            'schedule.php' => 'session',
            'appointment.php' => 'appoinment',
            'settings.php' => 'settings'
        ];

        foreach ($menuItems as $page => $label) {
            $activeClass = ($currentPage == $page) ? 'menu-active' : '';
            echo "<tr class='menu-row'>";
            echo "<td class='menu-btn menu-icon-$menuIcons[$page] $activeClass'>";
            echo "<a href='$page' class='non-style-link-menu'><div><p class='menu-text'>$label</p></div></a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>

    </table>
</div>

</body>
</html>
