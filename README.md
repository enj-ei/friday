# Tive Travels — Setup Instructions

## Requirements
- PHP 8+ with the `mysqli` extension
- MySQL

## 1. Install PHP and MySQL (Ubuntu)
sudo apt update
sudo apt install php php-mysqli php-cli mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql

## 2. Set up MySQL root login (skip if already blank-password root)
sudo mysql
Then inside the prompt:
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';
FLUSH PRIVILEGES;
EXIT;

## 3. Create the database and import everything
mysql -u root -e "CREATE DATABASE trekking_db;"
mysql -u root trekking_db < database/trekking_db.sql

This one command creates all 6 tables and loads existing data — no manual setup needed.

## 4. Run the site
php -S localhost:8000

Visit:
- Public site: http://localhost:8000/index.php
- Admin panel: http://localhost:8000/admin/login.php

## Default admin login
Email: admin@tivetravels.com
Password: Admin@123
