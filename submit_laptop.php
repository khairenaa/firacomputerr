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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data
    $name      = $_POST['name'];
    $phone     = $_POST['phone'];
    $budget    = $_POST['budget'];
    $condition = $_POST['condition'];
    $type      = $_POST['type'];
    $spec      = $_POST['spec'];
    $email     = $_POST['email'];

    // SQL query to insert form data into the database
    $sql = "INSERT INTO laptop_requests (name, phone, budget, `condition`, type, spec, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $phone, $budget, $condition, $type, $spec, $email);

    $response = [];

    if ($stmt->execute()) {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'abkhairena@gmail.com';
            $mail->Password = 'arfviwuwctujhgnw';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('abkhairena@gmail.com', 'Laptop Request');
            $mail->addAddress('abkhairena@gmail.com');
            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "New Laptop Request from " . $name;
            $mail->Body = "You have received a new laptop request:<br><br>" .
                          "Name: {$name}<br>" .
                          "Phone: {$phone}<br>" .
                          "Budget: RM {$budget}<br>" .
                          "Condition: {$condition}<br>" .
                          "Type: {$type}<br>" .
                          "Specifications: {$spec}<br>" .
                          "Email: {$email}<br>" .
                          "Submitted At: " . date('Y-m-d H:i:s');

            if ($mail->send()) {
                $response['success'] = true;
                $response['message'] = 'Thank you! We\'ll contact you about your laptop request.';
            } else {
                throw new Exception('Error sending email.');
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
