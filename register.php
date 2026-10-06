<?php
include 'php/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($name == '' || $email == '' || $password == '') {
        $error = "Please fill in all required fields.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password != $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Checking whether a user with a particular email already exists
        $check_result = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");

        if (mysqli_num_rows($check_result) > 0) {
            $error = "This email already exists. Try logging in instead.";
        } else {
            // Securely hashing a user's password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password_hash, phone)
                    VALUES ('$name', '$email', '$hashed_password', '$phone')";
            mysqli_query($conn, $sql);

            // Logging the new user in straight away and sending them to book an appointment
            $_SESSION['user_id']   = mysqli_insert_id($conn);
            $_SESSION['user_name'] = $name;
            header("Location: book.php");
            exit;
        }
    }
}

include 'php/header.php';
?>

<section class="section">
  <h1>Create an account</h1>
  <p>You'll need an account to book an appointment. Already have one?
     <a href="login.php">Log in here</a>.</p>

  <?php if ($error != '') { ?>
    <div class="form-message error"><?php echo htmlspecialchars($error); ?></div>
  <?php } ?>

  <form method="post" class="stack validate">
    <div class="field">
      <label for="name">Full name</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="field">
      <label for="phone">Phone</label>
      <input type="tel" id="phone" name="phone">
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="field">
      <label for="confirm_password">Confirm password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn">Create account</button>
  </form>
</section>

<?php include 'php/footer.php'; ?>
