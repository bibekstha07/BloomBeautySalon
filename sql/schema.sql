-- Bloom Beauty Salon — Database Schema
-- MIT122 - Interactive Web Design and Development - Assignment 02

DROP DATABASE IF EXISTS BloomBeautySalon;
-- Create the new database
CREATE DATABASE BloomBeautySalon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE BloomBeautySalon;

-- 1. Users — Registered clients (created via the Register page)
CREATE TABLE users (
    user_id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone         VARCHAR(20),
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Services — Services the salon offers
CREATE TABLE services (
    service_id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    category      VARCHAR(50)  NOT NULL,
    price         DECIMAL(6,2) NOT NULL,
    duration_min  INT NOT NULL,
    image_url     VARCHAR(255)
);

-- 3. Staff — Staff members a client can choose when booking
CREATE TABLE staff (
    staff_id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    specialty  VARCHAR(100),
    bio        TEXT,
    photo_url  VARCHAR(255)
);

-- 4. Bookings — Appointment requests; links a user, a service, and a staff member
CREATE TABLE bookings (
    booking_id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    service_id  INT NOT NULL,
    staff_id    INT NOT NULL,
    date_time   DATETIME NOT NULL,
    status      VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id)   REFERENCES staff(id)    ON DELETE CASCADE
);

-- 5. Contact_messages — Enquiries submitted through the Contact Us form
CREATE TABLE contact_messages (
    message_id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL,
    message       TEXT NOT NULL,
    submitted_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. Inserting sample data 

INSERT INTO services (service_id, name, category, price, duration_min, image_url) VALUES
('S001', 'Haircut & Style',      'Hair',             55.00,  45, 'images/services/haircut-style.jpg'),
('S002', 'Hair Colour',          'Hair',            120.00,  90, 'images/services/hair-colour.jpg'),
('S003', 'Classic Manicure',     'Nails',            35.00,  30, 'images/services/classic-manicure.jpg'),
('S004', 'Gel Manicure',         'Nails',            45.00,  40, 'images/services/gel-manicure.jpg'),
('S005', 'Deep Cleanse Facial',  'Skin',             80.00,  60, 'images/services/deep-cleanse-facial.jpg'),
('S005', 'Waxing/Hair Removal',  'Waxing',           55.00,  45, 'images/services/waxing.jpg'),
('S006', 'Brows and Lashes',     'Brows and Lashes', 20.00,  25, 'images/services/brows-lashes.jpg');

INSERT INTO staff (staff_id, name, specialty, bio, photo_url) VALUES
('E001', 'Aria Chen',  'Hair & Colour, Hair Removal/Waxing', 'Specialist in colour correction, modern cuts, and hair removal/waxing.',                 'images/staff/aria-chen.jpg'),
('E002', 'Marcus Lee', 'Brows & Lashes, Nails',              'Specialist in brows, lashes, and gel & nail art with a steady, precise hand.',          'images/staff/marcus-lee.jpg'),
('E003', 'Priya Nair', 'Facials & Skin',                     'Certified skin therapist focused on gentle, effective facial/skin treatments.',         'images/staff/priya-nair.jpg');
