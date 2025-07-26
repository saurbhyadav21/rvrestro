<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize function
    function clean($s){ return htmlspecialchars(trim($s), ENT_QUOTES, 'UTF-8'); }

    // Fetch and sanitize form values
    $name         = clean($_POST['form_fields']['name'] ?? '');
    $mobile       = clean($_POST['form_fields']['field_3fb54d4'] ?? '');
    $gathering    = clean($_POST['form_fields']['email'] ?? '');
    $functionDate = clean($_POST['form_fields']['field_5f3d8a4'] ?? '');
    $message      = clean($_POST['form_fields']['message'] ?? '');

    // Basic validation
    if (!$name || !$gathering || !$mobile || !$message || !$functionDate) {
        die('All fields are required.');
    }

    // Send Email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'demoacrishabh80@gmail.com';
        $mail->Password   = 'dvkmhjtfnmhkepdf'; // CHANGE IMMEDIATELY!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('demoacrishabh80@gmail.com', 'RvResttro Quote Form');
        $mail->addAddress('demoacrishabh80@gmail.com'); // Receiver email
        $mail->addReplyTo('demoacrishabh80@gmail.com', $name); // Or use $mobile if needed

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Quote Request from $name";
        $mail->Body    = "
            <h3>New Quote Request</h3>
            <b>Name:</b> $name<br>
            <b>Mobile:</b> $mobile<br>
            <b>Number of Gathering:</b> $gathering<br>
            <b>Date of Function:</b> $functionDate<br><br>
            <b>Message:</b><br>" . nl2br($message);
        $mail->AltBody = "Name: $name\nMobile: $mobile\nGathering: $gathering\nDate: $functionDate\n\nMessage:\n$message";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo 'Mail sending failed. Error: ' . $mail->ErrorInfo;
    }
}
?>
