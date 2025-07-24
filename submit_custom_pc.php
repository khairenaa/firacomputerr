<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Required files for PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "firacomputer";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$name   = $_POST['name'];
$phone  = $_POST['phone'];
$budget = $_POST['budget'];
$email  = $_POST['email']; // New email field

// SQL query to insert form data into the database (including email)
$sql = "INSERT INTO custom_pc_requests (name, phone, budget, email) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $phone, $budget, $email);

// Response array
$response = [];

if ($stmt->execute()) {
    // Send email using PHPMailer
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Ensure form is submitted via POST method
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                              // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';         // SMTP server
            $mail->SMTPAuth   = true;                     // Enable SMTP authentication
            $mail->Username   = 'abkhairena@gmail.com';   // SMTP email address
            $mail->Password   = 'qqzfwwyqlxdclvyb';      // SMTP password or app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable STARTTLS encryption
            $mail->Port       = 587;                      // SMTP port

            // Recipients
            $mail->setFrom('abkhairena@gmail.com', 'Custom PC Request');  // Sender email and name
            $mail->addAddress('abkhairena@gmail.com');                  // Recipient email
            $mail->addReplyTo($email, $name);                            // Reply-to email

            // Content
            $mail->isHTML(true);               // Set email format to HTML
            $mail->Subject = "New Custom PC Request from " . $name;   // Email subject
            $mail->Body    = "You have received a new custom PC request:<br><br>" . 
                             "Name: {$name}<br>" . 
                             "Phone: {$phone}<br>" . 
                             "Budget: {$budget}<br>" . 
                             "Email: {$email}<br>" . 
                             "Submitted At: " . date('Y-m-d H:i:s');

            // Send the email
            if ($mail->send()) {
                $response['success'] = true;
                $response['message'] = 'Thank you! We\'ll contact you about your custom PC.';
            } else {
                throw new Exception('Error sending email.');
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = "Error sending email: {$mail->ErrorInfo}";
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Error: " . $stmt->error; // Display SQL execution error
}

$stmt->close();
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
