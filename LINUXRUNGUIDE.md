# How to Run Tive Travels on Linux (Step-by-Step Guide)

This guide walks you through running this project on Ubuntu (or a similar
Debian-based Linux distribution) using the terminal. Follow every step in
order.

---

## Step 1: Install PHP and MySQL

Open a terminal and run:

```bash
sudo apt update
sudo apt install php php-mysqli php-cli mysql-server -y
```

Check PHP installed correctly:
```bash
php -v
```

---

## Step 2: Start MySQL

```bash
sudo systemctl start mysql
sudo systemctl enable mysql
```

The second command makes MySQL start automatically every time you turn on
your computer, so you won't need to repeat this step later.

---

## Step 3: Set Up MySQL's Root User

Ubuntu's MySQL uses a login method called `auth_socket` for the `root`
user by default, which only works through `sudo mysql`. This project's
code expects to log in as `root` with **no password**, so we need to
switch it.

```bash
sudo mysql
```

Once inside the MySQL prompt, run:
```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';
FLUSH PRIVILEGES;
EXIT;
```

Test that it worked:
```bash
mysql -u root
```
If this logs you in without asking for a password, it worked — type
`EXIT;` to leave.

---

## Step 4: Get the Project Files

If you received this as a **ZIP file**, extract it to a folder of your
choice, for example:
```bash
cd ~/Documents
unzip friday.zip
cd friday
```

If you're cloning with **Git**:
```bash
git clone <the repository URL>
cd <the folder name that was created>
```

---

## Step 5: Create the Database and Import the Data

From inside the project folder:

```bash
mysql -u root -e "CREATE DATABASE trekking_db;"
mysql -u root trekking_db < database/trekking_db.sql
```

Confirm it worked — you should see 7 tables:
```bash
mysql -u root trekking_db -e "SHOW TABLES;"
```

Expected output:
```
bookings
gallery
hotels
messages
packages
reviews
users
```

---

## Step 6: Run the Website

From inside the project folder, start PHP's built-in server:

```bash
php -S localhost:8000
```

This will keep running in your terminal (showing request logs) — leave
this terminal window open while you use the site. To stop it later,
press `Ctrl+C`.

Open your browser and go to:
```
http://localhost:8000/index.php
```

Admin panel:
```
http://localhost:8000/admin/login.php
```

---

## Login Details

**Admin account** (can manage packages, bookings, gallery, reviews, users,
and messages):

| Field    | Value                  |
|----------|------------------------|
| Email    | admin@tivetravels.com  |
| Password | Admin@123              |

**Customer account:** Register your own at
`http://localhost:8000/register.php`, then try booking a package and
leaving a review.

---

## Alternative: Using Apache Instead of `php -S`

If you'd rather run this through a proper web server instead of the
built-in one:

```bash
sudo apt install apache2 libapache2-mod-php -y
sudo cp -r ~/Documents/friday /var/www/html/friday
sudo systemctl restart apache2
```

Then visit `http://localhost/friday/index.php` instead. With this method
you don't need to keep a terminal window open — Apache runs in the
background permanently.

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

**"Database Connection Failed" when opening the site:**
Check MySQL is running:
```bash
sudo systemctl status mysql
```
If it's not running, go back to Step 2. If it is running, double check
the database exists:
```bash
mysql -u root -e "SHOW DATABASES;"
```
You should see `trekking_db` in the list. If not, repeat Step 5.

**`mysql -u root` still asks for a password:**
The root user switch in Step 3 didn't take effect. Repeat it exactly, and
make sure you ran `FLUSH PRIVILEGES;` afterward.

**Uploaded gallery images don't show up on the site:**
Make sure the `images/` folder is writable:
```bash
chmod -R 775 images/
```

**"Address already in use" when running `php -S localhost:8000`:**
Something else is already using port 8000. Either close that program, or
run the server on a different port instead:
```bash
php -S localhost:8080
```
Then visit `http://localhost:8080/index.php` (note the `:8080`).

**Check a specific file for errors:**
If a page shows a blank screen or an error, check the file for PHP syntax
issues:
```bash
php -l path/to/the/file.php
```

