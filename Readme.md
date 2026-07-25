# Tive Travels

A full-stack trekking and travel booking web application built with PHP
and MySQL. The platform allows visitors to explore trekking packages and
destinations, register for an account, book packages, leave reviews, and
send inquiries through a contact form. An admin panel is included for
managing the site's content and customer activity.

## Academic Information

This project was developed as a group assignment for the **BSc (Hons)
Computer Science with Artificial Intelligence** programme at **Quest
College, Kathmandu, Nepal**, delivered in partnership with **Coventry
University, UK**.

## Group Members

- Anjee Tamang
- Anjila Shrestha
- Alisha Thapa
- Rajiv Shrestha

## Project Overview

Tive Travels is a browser-based trekking agency platform aimed at
customers looking to explore and book guided trekking packages in Nepal.
The system supports two types of users — regular customers and
administrators — each with a distinct set of permissions and views.

## Features

### Customer-Facing Site
- Single-page layout with smooth-scrolling navigation across Home, About,
  Destinations, Packages, Gallery, and Contact sections
- Browse featured trekking packages with duration, difficulty, and price
- View popular trekking destinations with descriptions and imagery
- Photo gallery showcasing past treks
- User registration and secure login (passwords hashed with bcrypt)
- Book a trekking package through a guided booking form
- View personal booking history from a Profile page
- Submit a star-rated review after logging in
- Public testimonials section displaying customer reviews
- Contact form for general inquiries, stored for admin follow-up

### Admin Panel
- Secure admin-only login and session-based access control
- Dashboard overview of bookings, packages, and registered users
- Manage trekking packages (add, view, delete)
- View and track customer bookings
- Manage the photo gallery (upload new images with captions)
- View and moderate customer reviews
- View submitted contact messages
- Manage registered user accounts

## Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP (procedural, with `mysqli` for database access)
- **Database:** MySQL
- **Version Control:** Git & GitHub

## Project Structure

```
├── admin/              # Admin panel (dashboard, bookings, packages, users, reviews, gallery, messages)
├── css/                # Stylesheets
├── images/             # Uploaded gallery images
├── includes/           # Shared PHP includes (navbar, footer, DB connection, helper functions)
├── js/                 # JavaScript (slider, form validation, smooth scrolling)
├── database/           # SQL schema and sample data
├── index.php           # Homepage (Home, About, Destinations, Packages, Gallery, Reviews, Contact)
├── booking.php          # Package booking form
├── login.php / register.php / profile.php / logout.php
```

## Security Considerations

- Passwords are hashed using PHP's `password_hash()` (bcrypt)
- Database queries use prepared statements to prevent SQL injection
- User input is sanitized and escaped before output using `htmlspecialchars()`
- Session-based access control restricts admin pages to authenticated
  administrators only
- Uploaded gallery images are validated by file type and given
  system-generated filenames

## Acknowledgements

This project was completed as part of coursework requirements and is
intended for educational purposes only.