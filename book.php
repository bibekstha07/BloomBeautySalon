<?php
include 'php/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Must be logged in to see this page — send them to login if not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$booked = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Read the form values.
    // Cast IDs to (int) since they should only ever be whole numbers
    $service_id = (int)$_POST['service_id'];
    $staff_id   = (int)$_POST['staff_id'];
    // mysqli_real_escape_string makes text safe to put inside an SQL query
    // (it stops SQL injection, where someone types SQL code into a form)
    $date       = mysqli_real_escape_string($conn, $_POST['date']);
    $time       = mysqli_real_escape_string($conn, $_POST['time']);
    $user_id    = (int)$_SESSION['user_id'];

    if ($service_id == 0 || $staff_id == 0 || $date == '' || $time == '') {
        $error = "Please fill in every field.";
    } else {
        // MySQL's DATETIME format is "YYYY-MM-DD HH:MM:SS",
        // so join the date and time and add ":00" for the seconds
        $date_time = $date . " " . $time . ":00";

        // SQL: add one new row to the bookings table.
        // - user_id, service_id and staff_id are foreign keys: they link this
        //   booking to a row in the users, services and staff tables.
        // - status starts as 'pending' until the salon confirms the booking.
        // - id and created_at are filled in by MySQL automatically.
        $sql = "INSERT INTO bookings (user_id, service_id, staff_id, date_time, status)
                VALUES ('$user_id', '$service_id', '$staff_id', '$date_time', 'pending')";
        // Send the INSERT to the database, then show the success message
        mysqli_query($conn, $sql);
        $booked = true;
    }
}

include 'php/header.php';
?>

<section class="section">
  <h1>Book an appointment</h1>
  <p>Hi <?php echo htmlspecialchars($_SESSION['user_name']); ?>, pick a service, a staff member, and a time.</p>

  <?php if ($booked) { ?>
    <div class="form-message success">Your appointment request has been sent. The salon will confirm it soon.</div>
  <?php } elseif ($error != '') { ?>
    <div class="form-message error"><?php echo htmlspecialchars($error); ?></div>
  <?php } ?>

  <form method="post" class="stack validate">
    <div class="field">
      <label for="service_id">Service</label>
      <select id="service_id" name="service_id" required>
        <option value="">Choose a service...</option>
        <?php
        // SQL: read every service (id, name, price) in A-Z order.
        // Each row becomes one <option>; the id is what gets saved in bookings.
        $services = mysqli_query($conn, "SELECT service_id, name, price FROM services ORDER BY name");
        while ($s = mysqli_fetch_assoc($services)) {
        ?>
          <option value="<?php echo $s['service_id']; ?>">
            <?php echo htmlspecialchars($s['name']); ?> — $<?php echo number_format($s['price'], 2); ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="field">
      <label for="staff_id">Staff member</label>
      <select id="staff_id" name="staff_id" required>
        <option value="">Choose a staff member...</option>
        <?php
        // SQL: read every staff member so the client can choose who they want.
        // The chosen id is saved as staff_id in the bookings table.
        $staff = mysqli_query($conn, "SELECT staff_id, name, specialty FROM staff ORDER BY name");
        while ($st = mysqli_fetch_assoc($staff)) {
        ?>
          <option value="<?php echo $st['staff_id']; ?>">
            <?php echo htmlspecialchars($st['name']); ?> — <?php echo htmlspecialchars($st['specialty']); ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="field">
      <label for="date">Date</label>
      <input type="date" id="date" name="date" required>
    </div>

    <div class="field">
      <label for="time">Time</label>
      <input type="time" id="time" name="time" required>
    </div>

    <button type="submit" class="btn">Confirm booking</button>
  </form>
</section>

<?php include 'php/footer.php'; ?>
