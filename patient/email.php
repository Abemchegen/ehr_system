<?php
require 'vendor/autoload.php'; // Include the Mailjet library

use \Mailjet\Resources;

function sendEmail($recipientEmail, $recipientName, $appointmentDetails) {
    $mj = new \Mailjet\Client('YOUR_API_KEY', 'YOUR_API_SECRET', true, ['version' => 'v3.1']);
    
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "your-email@example.com",
                    'Name' => "Your Name"
                ],
                'To' => [
                    [
                        'Email' => $recipientEmail,
                        'Name' => $recipientName
                    ]
                ],
                'Subject' => "Appointment Confirmation",
                'TextPart' => "Dear $recipientName, here are your appointment details: $appointmentDetails",
                'HTMLPart' => "<h3>Dear $recipientName,</h3><p>Here are your appointment details: $appointmentDetails</p>"
            ]
        ]
    ];
    
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    
    if ($response->success()) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email: " . $response->getReasonPhrase();
    }
}

// Usage example
sendEmail('patient-email@example.com', 'Patient Name', 'Appointment on June 20, 2024 at 10:00 AM');
?>
