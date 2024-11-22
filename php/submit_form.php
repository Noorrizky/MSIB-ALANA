<?php
require 'vendor/autoload.php'; // Ensure you have installed the required libraries using Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use TCPDF;

// Capture form data
$name = $_POST['name'] ?? '';
$dateRequest = $_POST['date-request'] ?? '';
$email = $_POST['email'] ?? '';
$mobilePhone = $_POST['mobile-phone'] ?? '';
$position = $_POST['position'] ?? '';
$department = $_POST['department'] ?? '';
$actions = isset($_POST['action']) ? implode(', ', $_POST['action']) : '';
$reason = $_POST['reason'] ?? '';

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Title
$pdf->Cell(0, 10, 'System Access Authorization - PMS Request Form', 0, 1, 'C');

// General Information
$pdf->Ln(10);
$pdf->Cell(0, 10, 'General Information', 0, 1, 'L');
$pdf->Cell(0, 10, 'Name: ' . $name, 0, 1, 'L');
$pdf->Cell(0, 10, 'Date Request: ' . $dateRequest, 0, 1, 'L');
$pdf->Cell(0, 10, 'Email: ' . $email, 0, 1, 'L');
$pdf->Cell(0, 10, 'Mobile Phone: ' . $mobilePhone, 0, 1, 'L');
$pdf->Cell(0, 10, 'Position: ' . $position, 0, 1, 'L');
$pdf->Cell(0, 10, 'Department: ' . $department, 0, 1, 'L');

// Action Requested
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Action Requested: ' . $actions, 0, 1, 'L');

// Reason for Access Modification
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Reason: ' . $reason, 0, 1, 'L');

// Output PDF to file
$pdfFileName = 'pms_request_form.pdf';
$pdf->Output($pdfFileName, 'F');

// Send Email with Attachment
$mail = new PHPMailer(true);

try {
    // Set up email server
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Use your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@example.com'; // Your SMTP username
    $mail->Password = 'your-email-password'; // Your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set email sender and recipient
    $mail->setFrom('your-email@example.com', 'Your Name');
    $mail->addAddress($email); // Recipient's email address

    // Attach the generated PDF
    $mail->addAttachment($pdfFileName);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'PMS Request Form';
    $mail->Body = 'Please find the attached PMS Request Form PDF.';

    // Send the email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
