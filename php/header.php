<?php
// Start the session on every page, so we can check if someone is logged in.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bloom Beauty Salon</title>
<link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
</head>
<body>

<header class="site-header">
  <div class="container header-inner">
    <a href="index.php" class="logo">
  <img src="images/logo.jpg" alt="Bloom Beauty Salon logo" class="logo-icon">
  Bloom Beauty Salon
  </a>

    <nav class="main-nav">
      <a href="index.php">Home</a>
      <a href="about.php">About Us</a>
      <a href="services.php">Services</a>
      <a href="gallery.php">Gallery</a>
      <a href="contact.php">Contact Us</a>

      <?php if (isset($_SESSION['user_id'])) { ?>
        <a href="book.php" class="btn-book">Book Now</a>
        <span class="user-pill">
          Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
          &middot; <a href="logout.php">Log out</a>
        </span>
      <?php } else { ?>
        <a href="login.php" class="btn-book">Book Now</a>
      <?php } ?>
    </nav>
  </div>
</header>

<main class="container">
