<?php
session_start();
include("connection.php"); // Adjust the path as per your actual file structure

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_image'])) {
    $userEmail = $_SESSION['user']; // Assuming you store user's email in session
    $uploadDir = "uploads/"; // Directory where uploaded files will be stored
    $uploadFile = $uploadDir . basename($_FILES['profile_image']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Allow certain file formats
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Only JPG, JPEG, PNG, GIF files are allowed.";
        exit;
    }

    // Check file size (max 5MB)
    if ($_FILES['profile_image']['size'] > 5 * 1024 * 1024) {
        echo "File size exceeds maximum limit (5MB).";
        exit;
    }

    // Generate unique file name to prevent overwriting existing files
    $uniqueFileName = uniqid() . '_' . $_FILES['profile_image']['name'];
    $targetFilePath = $uploadDir . $uniqueFileName;

    // Upload file
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
        // Determine table name based on usertype
        $tableName = '';
        $imageColumnName = 'image'; // Column name where image path is stored

        switch ($_SESSION['usertype']) {
            case 'a':
                $tableName = 'admin';
                $emailColumnName = 'email';
                $redirectPage = 'admin/index.php';
                break;
            case 'd':
                $tableName = 'doctor';
                $emailColumnName = 'docemail';
                $redirectPage = 'doctor/index.php';
                break;
            case 'p':
                $tableName = 'patient';
                $emailColumnName = 'pemail';
                $redirectPage = 'patient/index.php';
                break;
            default:
                // Handle default case if needed
                break;
        }
        // Update image path in the database
        $updateSql = "UPDATE $tableName SET $imageColumnName = ? WHERE $emailColumnName = ?";
        $stmt = $database->prepare($updateSql);
        $stmt->bind_param("ss", $targetFilePath, $userEmail);
        $stmt->execute();
        $stmt->close();

        // Redirect or refresh the page to reflect changes
        header("Location: $redirectPage");
        exit;   
    } else {
        echo "Error uploading file.";
    }
}
?>
