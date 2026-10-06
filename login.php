<?php
include 'php/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT id, name, password_hash FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);

    // Checking the typed password against the saved password_hash
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: book.php");
        exit;
    } else {
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
