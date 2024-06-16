<?php
// Include database connection script
include("../connection.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form submission is for adding a report
    if (isset($_POST["addreport"])) {
        // Retrieve form data
        $id = $_POST["pid"];
        $report = $_POST["report"];

        // Prepare SQL statement
        $sql = "INSERT INTO reports (pid, report) VALUES (?, ?)";
        $stmt = $database->prepare($sql);

        // Bind parameters and execute query
        if ($stmt) {
            $stmt->bind_param("is", $id, $report);

            if ($stmt->execute()) {
                // Report added successfully
                echo '<script>window.location.href="patient.php";</script>';
                exit(); // Exit to prevent further execution
            } else {
                // Error executing SQL
                echo '<script>alert("Failed to add report. Please try again.");</script>';
            }
        } else {
            // Error preparing SQL statement
            echo "Prepare statement failed: " . $database->error;
        }
    }
}
?>
