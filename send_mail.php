<?php
if (isset($_POST['send'])) {
    // 1. Collect and clean data
    $name = strip_tags(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // 2. Set Email Parameters
    $to = "echanjwok@gmail.com"; // Replace with your actual email
    $subject = "KWA DWAI MEDIA: New Inquiry from $name";
    
    // 3. Create the Email Body
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // 4. Set Email Headers
    $headers = "From: webmaster@kwadwai.com\r\n"; // Use an email from your domain
    $headers .= "Reply-To: $email\r\n";

    // 5. Send the Mail
    if (mail($to, $subject, $email_content, $headers)) {
        // Redirect back with success message
        header("Location: contact.php?status=success");
    } else {
        // Redirect back with error message
        header("Location: contact.php?status=error");
    }
} else {
    header("Location: contact.php");
}
?>