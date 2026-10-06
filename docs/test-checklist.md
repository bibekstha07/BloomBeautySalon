# Test Checklist — Bloom Beauty Salon

This checklist covers the tests we ran on the finished site before submitting it.
Run each test on WampServer at `http://localhost/<your-folder-name>/`, then fill in
the **Result** column with Pass or Fail, plus a short note if something went wrong.

Tested by: ______________  Date: ______________  Browser: ______________

---

## 1. Pages and navigation

| # | Test | Steps | Expected result | Result |
|---|------|-------|-----------------|--------|
| 1.1 | Home page loads | Open the site address | Hero image, 3 featured services and the footer appear | |
| 1.2 | Every menu link works | Click Home, About Us, Services, Gallery and Contact Us | Each page opens with no error | |
| 1.3 | Footer links work | Click each link in the footer | Each one opens the right page | |
| 1.4 | Services come from the database | Open Services | All services in the `services` table show, with photo, price and duration | |
| 1.5 | Missing photo does not break | Rename one service photo, then refresh | The card shows text only, with no broken-image icon (rename it back afterwards) | |

## 2. Register and log in

| # | Test | Steps | Expected result | Result |
|---|------|-------|-----------------|--------|
| 2.1 | Book Now needs a login | While logged out, click Book Now | You are sent to the login page | |
| 2.2 | Empty form is blocked | Click Register with all fields empty | A message asks you to fill in the required fields | |
| 2.3 | Passwords must match | Enter two different passwords | A message says the passwords do not match | |
| 2.4 | Register a new client | Fill in the form correctly | You are taken to the booking form | |
| 2.5 | Duplicate email is rejected | Register again with the same email | A message says the email is already registered | |
| 2.6 | Wrong password is rejected | Log in with the right email and a wrong password | An error message, and you stay logged out | |
| 2.7 | Correct login works | Log in with the right details | You are taken to the booking form | |
| 2.8 | Log out | Click Log out, then click Book Now | You are sent back to the login page | |

## 3. Booking an appointment

| # | Test | Steps | Expected result | Result |
|---|------|-------|-----------------|--------|
| 3.1 | Dropdowns are filled | Open the booking form | The service and staff lists come from the database | |
| 3.2 | Missing fields are blocked | Submit without a date or time | A message asks for the missing field | |
| 3.3 | Booking is saved | Pick a service, staff member, date and time, then submit | A success message appears | |
| 3.4 | Correct row in database | In phpMyAdmin, open `bookings` → Browse | A new row with the right `user_id`, `service_id`, `staff_id` and date/time | |
| 3.5 | Double booking (known limit) | Book the same staff member at the same time twice | Currently both are saved. Listed under "Known issues" below | |

## 4. Contact form

| # | Test | Steps | Expected result | Result |
|---|------|-------|-----------------|--------|
| 4.1 | Empty form is blocked | Submit with empty fields | A message asks for the missing fields | |
| 4.2 | Message is saved | Fill in name, email and message, then submit | A success message, and a new row in `contact_messages` | |

## 5. Security

| # | Test | Steps | Expected result | Result |
|---|------|-------|-----------------|--------|
| 5.1 | Passwords are hashed | In phpMyAdmin, open `users` → Browse | `password_hash` starts with `$2y$`, never the real password | |
| 5.2 | Apostrophes do not break SQL | Send a contact message with the name `O'Brien` | The message saves with no SQL error | |
| 5.3 | HTML is not run | Register with the name `<b>Test</b>` and open the booking page | The greeting shows the text `<b>Test</b>`, not bold text | |
| 5.4 | JavaScript switched off | Turn off JavaScript in the browser and submit an empty form | The PHP checks still block it | |

## 6. Usability and accessibility

| # | Test | Steps | Expected result | Result |
|---|------|-------|-----------------|--------|
| 6.1 | Phone-sized screen | Make the browser narrow (or use F12 → device toolbar) | Content stacks into one column with no sideways scrolling | |
| 6.2 | Images have alt text | Hover over or inspect the main images | Each one has a short description | |
| 6.3 | Keyboard only | Use Tab and Enter to move through the menu and a form | Every link and field can be reached and used | |
| 6.4 | Readable text | Check the text on the About banner and the footer | Text stands out clearly from the background | |

---

## Known issues and future improvements

- **Double bookings:** the same staff member can be booked twice for the same time.
- **No admin page:** salon staff have to check bookings in phpMyAdmin.
- **No email confirmation** is sent after a booking.
- **Prepared statements:** the code escapes input with `mysqli_real_escape_string()`. `mysqli_prepare()` would be a stronger option.
