<?php
include 'php/header.php';

// Photos must be saved as .jpg inside the images/gallery/ folder
$photos = [
    ['bridal-makeup', 'Bridal makeup'],
    ['manicure',      'Manicure'],
    ['facial',        'Facial'],
    ['lashes',        'Lashes'],
    ['brows',         'Brows'],
    ['waxing',        'Waxing & Hair Removal'],
];
?>

<section class="section">
  <h1>Gallery</h1>
  <p>A look at some of our finished work.</p>

  <div class="grid grid-3">
    <?php
    foreach ($photos as $photo) {
        $file    = 'images/gallery/' . $photo[0] . '.jpg';
        $caption = $photo[1];
    ?>
      <div class="gallery-item">
        <?php if (file_exists(__DIR__ . '/' . $file)) { ?>
          <img src="<?php echo htmlspecialchars($file); ?>"
               alt="<?php echo htmlspecialchars($caption); ?>">
          <span class="gallery-caption"><?php echo htmlspecialchars($caption); ?></span>
        <?php } else { ?>
          <?php echo htmlspecialchars($caption); ?>
        <?php } ?>
      </div>
    <?php
    }
    ?>
  </div>
</section>

<?php include 'php/footer.php'; ?>