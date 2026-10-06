<?php
include 'php/db.php';
include 'php/header.php';

// Banner photo: images/about/salon-interior.jpg (only used if the file exists)
$banner_file  = 'images/about/salon-interior.jpg';
$banner_style = '';
if (file_exists(__DIR__ . '/' . $banner_file)) {
    $banner_style = "background-image: linear-gradient(rgba(36,18,25,0.6), rgba(36,18,25,0.6)), url('" . $banner_file . "');";
}
?>

<section class="section page-banner" style="<?php echo htmlspecialchars($banner_style); ?>">
  <h1>About Bloom Beauty Salon</h1>
  <p>A small, friendly salon where everyone leaves feeling a little more like themselves.</p>
  <p>Bloom started with one small shopfront and a simple belief: a good salon should feel welcoming, not rushed. 
    Word of mouth did the rest, and the team grew to cover hair, nails, skin, waxing, brows and lashes under one roof. 
    Now you can browse our services, meet the team and book online, any time.</p>
</section>

<section class="section">
  <h2>What we value</h2>
  <div class="grid grid-3">
    <div class="card">
      <div class="card-body">
        <h3>Expert Care</h3>
        <p>Each of us master a few treatments, so you get true specialists, not generalists.</p>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h3>Honest Prices</h3>
        <p>Clear prices and times up front. What you see is what you pay.</p>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h3>You Come First</h3>
        <p>We listen before we start, and we're not done until you love it.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <h2>Meet our team</h2>

  <div class="grid grid-3">
    <?php
    // Everything here comes from the staff table
    $staff = mysqli_query($conn, "SELECT name, specialty, bio, photo_url FROM staff ORDER BY staff_id");

    while ($member = mysqli_fetch_assoc($staff)) {

        // Only shows the photo if the .jpg file really exists
        $has_photo = !empty($member['photo_url']) && file_exists(__DIR__ . '/' . $member['photo_url']);
    ?>
      <div class="card">
        <?php if ($has_photo) { ?>
          <img src="<?php echo htmlspecialchars($member['photo_url']); ?>"
               alt="<?php echo htmlspecialchars($member['name']); ?>" class="team-photo">
        <?php } else { ?>
          <div class="team-initial">
            <?php echo htmlspecialchars(strtoupper(substr($member['name'], 0, 1))); ?>
          </div>
        <?php } ?>
        <div class="card-body">
          <h3><?php echo htmlspecialchars($member['name']); ?></h3>
          <p class="team-role"><?php echo htmlspecialchars($member['specialty']); ?></p>
          <p><?php echo htmlspecialchars($member['bio']); ?></p>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</section>

<?php include 'php/footer.php'; ?>
