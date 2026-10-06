<?php
include 'php/db.php';

$message_sent = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handling a contact form submission
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if ($name == '' || $email == '' || $message == '') {
        $error = "Please fill in all fields.";
    } else {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        mysqli_query($conn, $sql);
        $message_sent = true;
    }
}

include 'php/header.php';
?>

<section class="section">
  <h1>Contact us</h1>
  <p>Have a question before you book? Send us a message and we'll get back to you.</p>

  <?php if ($message_sent) { ?>
    <div class="form-message success">Thanks — your message has been sent.</div>
  <?php } elseif ($error != '') { ?>
    <div class="form-message error"><?php echo htmlspecialchars($error); ?></div>
  <?php } ?>

  <form method="post" class="stack validate">
    <div class="field">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="field">
      <label for="message">Message</label>
      <textarea id="message" name="message" required></textarea>
    </div>
    <button type="submit" class="btn">Send message</button>
  </form>
</section>

<?php include 'php/footer.php'; ?>
