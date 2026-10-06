<?php
include 'php/db.php';
include 'php/header.php';
?>

<section class="hero">
  <div class="hero-text">
    <h1>The place where beauty blossoms.</h1>
    <p>Unwind with our stylists and therapists, and leave feeling like your best self. Personalised treatments that bring out what's already beautiful about you.</p>
    <a href="book.php" class="btn">Book an appointment</a>
  </div>
  <div class="hero-image">
    <img src="images/hero.jpg" alt="A client enjoying a facial treatment at Bloom Beauty Salon">
  </div>
</section>

<section class="section">
  <h2>Featured services</h2>
  <div class="grid grid-3">
    <?php
    // Grab the first 3 services to show off on the home page
    $result = mysqli_query($conn, "SELECT name, category, price, image_url FROM services ORDER BY service_id LIMIT 3");

    while ($row = mysqli_fetch_assoc($result)) {

        // Only show the photo if the .jpg file really exists
        $has_photo = !empty($row['image_url']) && file_exists(__DIR__ . '/' . $row['image_url']);
    ?>
      <div class="card">
        <?php if ($has_photo) { ?>
          <img src="<?php echo htmlspecialchars($row['image_url']); ?>"
               alt="<?php echo htmlspecialchars($row['name']); ?>" class="card-image">
        <?php } ?>
        <div class="card-body">
          <h3><?php echo htmlspecialchars($row['name']); ?></h3>
          <p><?php echo htmlspecialchars($row['category']); ?></p>
          <span class="price">from $<?php echo number_format($row['price'], 2); ?></span>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
  <p style="margin-top: 24px;"><a href="services.php">See all services &rarr;</a></p>
</section>

<?php include 'php/footer.php'; ?>
