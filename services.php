<?php
include 'php/db.php';
include 'php/header.php';
?>

<section class="section">
  <h1>Our services</h1>
  <p>Expert care for hair, skin, and nails, because you deserve to feel beautiful.</p>

  <div class="grid grid-3">
    <?php
    // ORDER BY category so similar services sit next to each other
    $result = mysqli_query($conn, "SELECT name, category, price, duration_min, image_url FROM services ORDER BY category, name");

    while ($row = mysqli_fetch_assoc($result)) {

        // Only shows the photo if the .jpg file really exists in the images folder
        $has_photo = !empty($row['image_url']) && file_exists(__DIR__ . '/' . $row['image_url']);
    ?>
      <div class="card">
        <?php if ($has_photo) { ?>
          <img src="<?php echo htmlspecialchars($row['image_url']); ?>"
               alt="<?php echo htmlspecialchars($row['name']); ?>" class="card-image">
        <?php } ?>
        <div class="card-body">
          <h3><?php echo htmlspecialchars($row['name']); ?></h3>
          <p><?php echo htmlspecialchars($row['category']); ?> &middot; <?php echo (int)$row['duration_min']; ?> minutes</p>
          <span class="price">$<?php echo number_format($row['price'], 2); ?></span>
        </div>
      </div>
    <?php
    }
    ?>
  </div>

  <p style="margin-top:24px;"><a href="book.php" class="btn">Book Now</a></p>
</section>

<?php include 'php/footer.php'; ?>