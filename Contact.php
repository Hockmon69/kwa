<?php
if (isset($_POST['submit_contact'])) {
    $to = "your-echanjwok@gmail.com"; // Your professional email
    $subject = "New Inquiry from KWA DWAI MEDIA";
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: webmaster@kwadwai.com"; // Must be an email from your domain later

    if (mail($to, $subject, $body, $headers)) {
        $feedback = "Your message has been sent successfully!";
    } else {
        $feedback = "There was an error. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact | PhotoStudio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('nav.php'); ?>

    <section style="padding: 100px 10%; text-align: center;">
        <h1>Get In Touch</h1>
        <form action="contact.php" method="POST">
    <?php if(isset($feedback)) echo "<p style='color:green;'>$feedback</p>"; ?>
    
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <textarea name="message" placeholder="How can I help you?" required></textarea>
    
    <button type="submit" name="submit_contact" class="btn">Send Message</button>
</form>
    </section>
    <?php include('footer.html'); ?> 
</body>
</html>