# How to Run Tive Travels on Windows (Step-by-Step Guide)

This guide is written for someone who has never set up a website like this
before. Follow every step in order — don't skip any.

---

## Step 1: Download and Install XAMPP

XAMPP is a free program that gives your computer everything needed to run
this website (a web server, PHP, and a MySQL database) in one install.

1. Go to: https://www.apachefriends.org/download.html
2. Click the **Download** button for the **Windows** version
3. Once downloaded, double-click the installer file
4. If Windows shows a security warning, click **Yes** or **Run anyway**
5. Click through the installer using all the **default options** — you
   don't need to change anything. Just keep clicking **Next**
6. When it finishes, click **Finish**

The install location will be `C:\xampp` — remember this, you'll need it.

---

## Step 2: Get the Project Files

If you received this project as a **ZIP file**:
1. Right-click the ZIP file
2. Click **Extract All...**
3. Choose to extract it somewhere you'll remember (like your Desktop)

If you're using **Git** to clone the repository:
1. Open Command Prompt
2. Run: `git clone <the repository URL>`

Either way, you should now have a folder containing files like `index.php`,
`login.php`, a `css` folder, an `admin` folder, and so on.

---

## Step 3: Move the Project Into XAMPP's Folder

1. Open **File Explorer**
2. Navigate to `C:\xampp\htdocs`
3. Copy your entire project folder into `C:\xampp\htdocs`
4. Make sure the folder is directly inside `htdocs` — for example:
   ```
   C:\xampp\htdocs\friday\index.php
   ```
   (if your folder has a different name than "friday", that's fine — just
   remember what it's called, you'll need it in Step 6)

---

## Step 4: Start the Server

1. Open the **Start Menu** and search for **XAMPP Control Panel**
2. Open it
3. You'll see a list including **Apache** and **MySQL**, each with a
   **Start** button next to them
4. Click **Start** next to **Apache**
5. Click **Start** next to **MySQL**
6. Both should turn **green** with a status showing "Running"

**If Apache won't start (stays red):** something else on your computer
(like Skype) might be using the same port. Close other programs and try
again, or see the "Troubleshooting" section at the bottom of this guide.

---

## Step 5: Create the Database

1. Open your web browser (Chrome, Firefox, Edge — any is fine)
2. Go to this address: `http://localhost/phpmyadmin`
3. You'll see a page called **phpMyAdmin**
4. On the left sidebar, click **New**
5. In the box that appears, type: `trekking_db`
6. Click the **Create** button

You should now see `trekking_db` appear in the left sidebar.

---

## Step 6: Import the Website's Data

1. Still in phpMyAdmin, click on `trekking_db` in the left sidebar (if you're
   not already viewing it)
2. Click the **Import** tab at the top
3. Click **Choose File**
4. Navigate to your project folder, then into the `database` folder, and
   select the file named `trekking_db.sql`
   (full path example: `C:\xampp\htdocs\friday\database\trekking_db.sql`)
5. Scroll to the bottom of the page and click the **Import** button
6. Wait a few seconds — you should see a green success message

You should now see **7 tables** listed on the left: `bookings`, `gallery`,
`hotels`, `messages`, `packages`, `reviews`, `users`.

---

## Step 7: Open the Website

1. Open your web browser
2. Go to: `http://localhost/friday/index.php`
   (replace "friday" with whatever your folder is actually called)

You should see the Tive Travels homepage!

**Admin panel:** `http://localhost/friday/admin/login.php`

---

## Login Details

**Admin account** (can manage packages, bookings, gallery, reviews, users,
and messages):

| Field    | Value                  |
|----------|------------------------|
| Email    | admin@tivetravels.com  |
| Password | Admin@123              |

**Customer account:** You don't have one yet — create your own by going to
`http://localhost/friday/register.php` and filling in the form. Then you
can try booking a package and leaving a review.

---

## What You Can Try

- Browse trekking packages and click "View & Book" on one
- Register an account, then book a package (you can add a hotel too)
- Leave a review for a package you've booked (from your Profile page)
- Log in as admin and check out the Bookings, Packages, Gallery, Reviews,
  Messages, and Users pages in the sidebar
- Try confirming or cancelling a booking as admin

---

## Troubleshooting

**"This site can't be reached" or blank page:**
Make sure both Apache and MySQL show green/"Running" in the XAMPP Control
Panel (Step 4). If they're not running, the website can't work.

**Apache won't turn green / shows an error about port 80:**
Another program on your computer is using the same port. In the XAMPP
Control Panel, click **Config** next to Apache → **Apache (httpd.conf)**.
A text file will open — find the line that says `Listen 80` and change it
to `Listen 8080`. Save the file, restart Apache, then visit
`http://localhost:8080/friday/index.php` instead (note the `:8080`).

**"Database Connection Failed" error when opening the site:**
This means MySQL isn't running, or the database wasn't created/imported
correctly. Go back to Step 4 (make sure MySQL is green) and Step 5-6
(make sure `trekking_db` exists and has 7 tables).

**Uploaded gallery images don't show up:**
Make sure you're logged in as admin when uploading, and that the file is
a JPG, PNG, or WEBP under 2MB.

