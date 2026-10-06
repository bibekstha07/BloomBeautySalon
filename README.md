# Bloom Beauty Salon — Online Booking & Information System

MIT122 Assignment 02: the working version of the system proposed in Assignment 01.

Clients can browse the salon's services, meet the team, create an account and
book an appointment with the staff member they choose.

## Tech stack
- HTML5 / CSS3 / JavaScript (client side)
- PHP with **mysqli** (server side)
- MySQL (database)
- Runs locally on WampServer

## Pages (7)
| # | Page | File(s) |
|---|------|---------|
| 1 | Home | `index.php` |
| 2 | About Us | `about.php` |
| 3 | Services | `services.php` |
| 4 | Gallery | `gallery.php` |
| 5 | Contact Us | `contact.php` |
| 6 | Register / Login | `register.php`, `login.php` |
| 7 | Book Now | `book.php` (login required) |

Clicking **Book Now** in the menu sends visitors to the login page. After they
log in or register, they land on the booking form. (`logout.php` ends the session.)

## Database (5 tables)
`sql/schema.sql` creates the `BloomBeautySalon` database:

| Table | What it stores |
|-------|----------------|
| `users` | Registered clients (passwords are hashed) |
| `services` | Services, categories, prices, durations and photo paths |
| `staff` | Team members: name, specialty, bio, photo path |
| `bookings` | Appointments, linked to a user, a service and a staff member |
| `contact_messages` | Messages from the Contact Us form |

## Local setup (WampServer)
1. Copy this project folder into `C:\wamp64\www\`
2. Start WampServer and wait for the tray icon to turn green
3. Open `http://localhost/phpmyadmin`, click **Import**, choose `sql/schema.sql`, click **Go**
   > **Warning:** this file deletes and rebuilds the `BloomBeautySalon` database,
   > so any accounts, bookings and messages already saved are lost.
4. Check `php/db.php` matches your MySQL login (WampServer default: user `root`, empty password)
5. Open `http://localhost/<your-folder-name>/`

## Try it out
1. Click **Book Now**, then **Create an account** and fill in the form
2. You are taken to the booking form: pick a service, a staff member, a date and a time
3. Submit, then check the `bookings` table in phpMyAdmin to see the saved row
4. Send a message from **Contact Us** and check `contact_messages`

## Project structure
```
├── php/        shared PHP: database connection, header, footer
├── css/        stylesheet
├── js/         client-side form checks (main.js)
├── sql/        schema.sql (run this first)
├── images/     photos used on the site (about, gallery, services, staff)
└── *.php       the pages, plus logout.php
```

## How it works
- Every page connects to the database through `php/db.php` using `mysqli_connect()`.
- Services, staff and bookings are read with `mysqli_query()` and shown with a `while` loop.
- Text typed into forms goes through `mysqli_real_escape_string()` before it
  reaches a SQL query, and ID values are cast with `(int)`. This helps stop SQL injection.
- Passwords are never stored as plain text: `password_hash()` when registering,
  `password_verify()` when logging in.
- `book.php` checks `$_SESSION['user_id']` first and redirects to `login.php` if nobody is logged in.
- Photos are only displayed when the `.jpg` file exists, so a missing image never shows a broken icon.
- `js/main.js` checks required fields and matching passwords before a form submits.
  The same checks run again in PHP, because JavaScript can be switched off.

## Possible improvements
- A page for the salon to view and manage bookings
- Email confirmations for new bookings
- Prepared statements (`mysqli_prepare`) in place of escaping
- Blocking double-bookings for the same staff member and time

## Team
Bibek Shrestha, Sagar Bhattarai, Ujwal Bhattarai