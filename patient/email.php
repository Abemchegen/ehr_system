<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Path to PHPMailer autoload.php
require '../connection.php'; // Assuming this file includes your database connection

// Check if action parameter is set and equals 'booking-added'
if(isset($_GET['action']) && $_GET['action'] == 'booking-added') {
    // Get booking ID from URL parameter
    if(isset($_GET['id'])) {
        $apponum = $_GET['id'];

        // Fetch booking details from database
        $sql = "SELECT * FROM appointment WHERE apponum=?";
        $stmt = $database->prepare($sql);
        $stmt->bind_param("i", $apponum);
        $stmt->execute();
        $booking = $stmt->get_result()->fetch_assoc();

        if($booking) {
            // Retrieve patient details for email content
            $sql_patient = "SELECT * FROM patient WHERE pid=?";
            $stmt_patient = $database->prepare($sql_patient);
            $stmt_patient->bind_param("i", $booking['pid']);
            $stmt_patient->execute();
            $patient = $stmt_patient->get_result()->fetch_assoc();

            if($patient) {
                $patientName = $patient['pname'];
                $patientEmail = $patient['pemail'];
                $appointmentDate = $booking['appodate'];


                // Email sending using PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Gmail SMTP configuration
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'bigidovi@gmail.com'; // Your Gmail email address
                    $mail->Password = 'rlwn yyaa npnw boog'; // Your Gmail password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Sender and recipient details
                    $mail->setFrom('bigidovi@gmail.com', 'Your Name'); // Sender's email and name
                    $mail->addAddress($patientEmail, $patientName); // Recipient's email and name

                    // Email content
                    $mail->isHTML(true);
                    $mail->Subject = 'Appointment Confirmation';
                    $mail->Body    = '
                        Dear ' . $patientName . ',<br><br>
                        Your appointment has been successfully booked for ' . $appointmentDate . '.<br><br>
                        Appointment Number: ' . $apponum . '<br><br>
                        If you have any questions or need to reschedule, please contact us at <a href="mailto:help@ehr.com">help@ehr.com</a>.<br><br>
                        Thank you for choosing our service. We look forward to seeing you.<br><br>
                        Sincerely,<br>
                        EHR Management Team<br><br>
                        <img src="../img/EthiopianDoctors.jpeg" alt="EHR Logo" width="150">
                    ';
                $mail->isHTML(true);
                    // Send email
                    $mail->send();
                    header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");
                } catch (Exception $e) {
                    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";

                }
            } else {
            }
        }
    }
}
?>
