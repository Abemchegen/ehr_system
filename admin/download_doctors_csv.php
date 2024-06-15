<?php
// Start session and include database connection
session_start();
include("../connection.php");

// Ensure user is authenticated and authorized
if (isset($_SESSION["user"]) && $_SESSION["user"] != "" && $_SESSION['usertype'] == 'a') {
    // Set headers for CSV file download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=doctors.csv');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Write CSV headers
    fputcsv($output, array('Doctor ID', 'Doctor Name', 'Email', 'Telephone', 'Specialties'));

    // Query to fetch doctors data
    $sql = "SELECT docid, docname, docemail, doctel, specialties FROM doctor";
    $result = $database->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Loop through each row and write to CSV
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }

    // Close output stream
    fclose($output);

    // Close database connection
    $database->close();

    // Exit script after download
    exit();
} else {
    // Redirect to login page if not authenticated or authorized
    header("Location: ../login.php");
    exit();
}
?>
