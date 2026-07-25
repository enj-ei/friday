# Tive Travels — Setup Instructions (Windows)

A PHP + MySQL trekking booking website with a customer-facing site and an
admin panel.

## Features
- Browse trekking packages, destinations, and a photo gallery
- Register / log in as a customer
- Book a trekking package (choose from a dropdown or click "Book Now" on a
  specific package)
- View your booking history and leave a review from your Profile page
- Public testimonials section showing customer reviews with star ratings
- Contact form (messages are saved and viewable by the admin)
- Admin panel to manage packages, bookings, users, reviews, gallery images,
  and contact messages

## What you need
Download and install **XAMPP** (includes PHP, MySQL, and phpMyAdmin all in one):
https://www.apachefriends.org/download.html

Choose the Windows installer, run it, and accept the default options
(default install location: `C:\xampp`).

## 1. Get the project files into XAMPP's folder

After cloning or downloading this repository as a ZIP, copy the entire
project folder into:

```
C:\xampp\htdocs\
```

So the path looks like:
```
C:\xampp\htdocs\friday\index.php
```
(rename the folder to `friday` if it's called something else after cloning)

## 2. Start Apache and MySQL

1. Open the **XAMPP Control Panel** (search for it in the Start menu)
2. Click **Start** next to both **Apache** and **MySQL**
3. Both should turn green — if either shows red/fails to start, another
   program (like Skype or an existing MySQL install) may be using the same
   port; close it and try again

## 3. Create the database and import the data

1. Open your browser and go to: **http://localhost/phpmyadmin**
2. Click **New** in the left sidebar
3. Enter database name: `trekking_db`, then click **Create**
4. Click on `trekking_db` in the left sidebar, then click the **Import** tab
5. Click **Choose File**, and select `database/trekking_db.sql` from the
   project folder (e.g. `C:\xampp\htdocs\friday\database\trekking_db.sql`)
6. Scroll down and click **Import** (leave all other settings as default)

You should see a success message, and 6 tables should now appear in the
left sidebar: `users`, `packages`, `bookings`, `reviews`, `gallery`, `messages`.

## 4. Run the website

Open your browser and go to:

```
http://localhost/friday/index.php
```

(replace `friday` with whatever you named the folder in `htdocs`)

Admin panel:
```
http://localhost/friday/admin/login.php
```

## Accounts

**Admin** (manage packages, bookings, users, reviews, gallery, messages):

| Field    | Value                     |
|----------|---------------------------|
| Email    | admin@tivetravels.com     |
| Password | Admin@123                 |

**Customer account:** register your own at
`http://localhost/friday/register.php` to test booking a package and
leaving a review.

## Notes

- XAMPP's MySQL uses username `root` with **no password** by default, which
  matches what `includes/connection.php` expects — no changes needed there.
- If Apache won't start because port 80 is already in use, open the XAMPP
  Control Panel → click **Config** next to Apache → **Apache (httpd.conf)**
  → change `Listen 80` to `Listen 8080`, then visit
  `http://localhost:8080/friday/index.php` instead.
- To stop the site, just click **Stop** on Apache and MySQL in the Control
  Panel — no terminal commands needed.