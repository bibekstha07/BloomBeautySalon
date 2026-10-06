<?php
include 'php/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Make the email safe to use inside the SQL query (stops SQL injection).
    // The password is NOT put into the query, so it is not escaped.
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // SQL: find the user with this email in the users table.
    // email is UNIQUE in the database, so this returns one row or none.
    // We only need id and name (to remember the user) and password_hash
    // (to check the password). The real password is never stored.
    $result = mysqli_query($conn, "SELECT id, name, password_hash FROM users WHERE email = '$email'");
    // Turn the result into an array, e.g. $user['name'].
    // If no user has this email, $user will be null.
    $user = mysqli_fetch_assoc($result);

    // Checking the typed password against the saved password_hash
    if ($user && password_verify($password, $user['password_hash'])) {
        // Correct password: save the user in the session so other pages
        // (like book.php) know who is logged in, then go to the booking form
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: book.php");
        exit;
    } else {
        // Same message for a wrong email or a wrong password,
        // so nobody can use this form to find out which emails are registered
        $error = "Email or password is incorrect.";
    }
}

include 'php/header.php';
?>

<section class="section">
  <h1>Log in</h1>
  <p>New here? <a href="register.php">Create an account</a> first.</p>

  <?php if ($error != '') { ?>
    <div class="form-message error"><?php echo htmlspecialchars($error); ?></div>
  <?php } ?>

  <form method="post" class="stack validate">
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Log in</button>
  </form>
</section>

<?php include 'php/footer.php'; ?>
