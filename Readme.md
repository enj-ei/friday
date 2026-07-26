# Tive Travels

A full-stack trekking and travel booking web application built with PHP
and MySQL. The platform allows visitors to browse trekking packages and
destinations, register for an account, book packages with optional hotel
accommodation, leave reviews, and send inquiries through a contact form.
A full admin panel is included for managing the site's content and
customer activity.

## Academic Information

This project was developed as a group assignment for the **Bachelor of Computer Systems and Information Technology.** programme at **Quest International College, Lalitpur, Nepal**, affiliated to **Pokhara University**

## Group Members

- Anjee Tamang
- Anjila Shrestha
- Alisha Thapa
- Rajiv Maharjan

## Getting Started

This file describes what the project is and how it's built. To actually
run it on your machine, see:

- **Windows:** [`RUNNING_README.md`](./RUNNING_README.md)
- **Linux:** [`LINUXRUNGUIDE.md`](./LINUXRUNGUIDE.md)

## Project Overview

Tive Travels is a browser-based trekking agency platform for customers
looking to explore and book guided trekking packages in Nepal. The system
supports two types of users — regular customers and administrators — each
with a distinct set of permissions and views.

## Features

### Customer-Facing Site
- Single-page layout with smooth-scrolling navigation across Home, About,
  Destinations, Packages, Gallery, Reviews, and Contact sections
- Searchable and filterable trekking package listings, with category
  badges, featured tags, price, location, duration, and group size
- Dedicated package detail page for each trek, with a full description,
  highlights, and a live-updating booking form
- Optional hotel/accommodation add-on when booking, with automatic total
  price calculation (package cost + accommodation cost × nights)
- User registration and secure login (passwords hashed with bcrypt)
- Personal booking history and account details on a Profile page
- Submit a star-rated review tied to a specific booked package, after
  logging in
- Public testimonials section displaying customer reviews with star
  ratings and the associated package
- Contact form for general inquiries, stored for admin follow-up
- Compact account dropdown menu (My Bookings / My Profile / Logout) in
  the navbar

### Admin Panel
- Secure admin-only login and session-based access control
- Dashboard overview of bookings, packages, and registered users
- Manage trekking packages — add, view, and delete, including category,
  location, description, group size, price, and featured status
- View customer bookings with full details (people count, hotel,
  accommodation cost, total price) and confirm or cancel pending bookings
- Manage the photo gallery — upload new images with captions (validated
  by file type and size), and delete existing ones
- View and moderate customer reviews, including which package each
  review is about
- View submitted contact messages
- Manage registered user accounts

## Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript (vanilla — live price calculation,
  search/filter, smooth scrolling, dropdown menus)
- **Backend:** PHP (procedural, with `mysqli` and prepared statements)
- **Database:** MySQL
- **Version Control:** Git & GitHub

## Project Structure

```
├── admin/              # Admin panel (dashboard, bookings, packages, gallery, reviews, messages, users)
├── css/                 # Stylesheets
├── images/              # Uploaded gallery images
├── includes/            # Shared PHP includes (navbar, footer, DB connection, helper functions)
├── js/                  # JavaScript (slider, package search/filter, nav scrolling, account dropdown)
├── database/            # SQL schema and sample data (trekking_db.sql)
├── index.php            # Homepage (Home, About, Destinations, Packages, Gallery, Reviews, Contact)
├── booking.php          # Package detail + booking page (with hotel add-on)
├── login.php / register.php / profile.php / logout.php
├── RUNNING_README.md    # Windows setup guide
├── LINUXRUNGUIDE.md     # Linux setup guide
```

## Database Overview

The application uses 7 tables:

| Table      | Purpose                                                         |
|------------|------------------------------------------------------------------|
| `users`    | Customer and admin accounts (role-based access)                 |
| `packages` | Trekking packages (name, category, location, price, etc.)       |
| `bookings` | Customer bookings, linked to a package and optionally a hotel   |
| `hotels`   | Accommodation options offered as a booking add-on               |
| `reviews`  | Customer reviews, linked to a user and the package reviewed     |
| `gallery`  | Photos shown in the public gallery, manageable by admin         |
| `messages` | Contact form submissions                                         |

## Security Considerations

- Passwords are hashed using PHP's `password_hash()` (bcrypt)
- Database queries use prepared statements to prevent SQL injection
- User input is sanitized and escaped before output using `htmlspecialchars()`
- Session-based access control restricts admin pages to authenticated
  administrators only
- Uploaded gallery images are validated by file type, extension, and
  size, and saved under system-generated filenames to avoid overwrites
  and path-based attacks

## Acknowledgements

This project was completed as part of coursework requirements and is
intended for educational purposes only.
