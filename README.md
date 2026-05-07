# DailyBlog – Full Stack Blogging Platform

## Overview

DailyBlog is a full-stack web application developed for dynamic blog publishing and content management. The system provides a complete blogging platform where users can create and manage blog posts, while administrators can monitor, approve, reject, and control content through a dedicated admin dashboard.

The application was developed using PHP and MySQL for backend development and HTML, CSS, JavaScript, and Bootstrap for frontend implementation. The platform focuses on responsive design, secure authentication, dynamic data rendering, and efficient database management.

---

## Features

### User Module
- User registration and login
- Secure authentication system
- Create and submit blog posts
- View approved blogs dynamically
- Search blogs by title and author
- Pagination support for blog listings

### Blog Management
- Dynamic blog rendering from database
- Modal-based detailed blog view
- Real-time blog search functionality
- Status-based blog filtering
- Efficient data loading using pagination

### Admin Module
- Separate admin login system
- Approve, reject, and delete blog posts
- Manage blog workflow dynamically
- Add remarks for rejected blogs
- Search and pagination in admin panel
- Dynamic blog status handling

---

## Technology Stack

### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap

### Backend
- PHP

### Database
- MySQL

### Additional Technologies
- AJAX
- SQL Queries
- Session Management

---

## System Functionality

The homepage dynamically displays platform statistics such as total visitors, published blogs, and active writers by fetching data from the MySQL database. Additional sections like About and Contact were included to provide a complete blogging platform structure.

The blog listing module retrieves approved blog posts dynamically using SQL SELECT queries with filtering conditions based on blog status. Advanced features like search and pagination were implemented to improve system performance and user experience.

The search functionality allows users to filter blogs using blog title and author name, while pagination ensures efficient handling of large datasets.

A modal-based blog detail system was implemented using JavaScript. When users click on the “Read More” button, the complete blog information including title, image, description, author name, and publish date is displayed dynamically without reloading the page.

The project also includes a secure authentication system for users and administrators. Password hashing and validation techniques were implemented for secure login and registration functionality.

AJAX-based validation was used during registration to check username and email availability in real time, improving user experience and reducing duplicate records.

An admin panel was developed for complete blog management. Administrators can approve, reject, or delete blog posts using SQL UPDATE and DELETE operations. A remark system was also implemented for rejected blogs to provide feedback to writers.

The admin interface supports:
- Dynamic blog status handling
- Search functionality
- Pagination
- Workflow management

---

## Database Operations

The project uses MySQL as the database management system. The following SQL operations were implemented:

- INSERT – Store user and blog data
- SELECT – Fetch blog and user records
- UPDATE – Modify blog status and remarks
- DELETE – Remove blog records

---

## Security Features

- Password hashing for secure authentication
- Session-based login management
- Role-based access control
- AJAX validation for duplicate checking
- Input validation and verification

---

## Development Environment

The project was developed using Visual Studio Code as the primary code editor for frontend and backend development.

### Tools and Software Used

- Visual Studio Code – Source code editor
- XAMPP – Local server environment
- phpMyAdmin – Database management
- Bootstrap – Responsive UI framework

---

## Installation and Setup

1. Install XAMPP on your system.
2. Start Apache and MySQL services from XAMPP Control Panel.
3. Copy the project folder into the `htdocs` directory.
4. Import the database file into phpMyAdmin.
5. Open the project in Visual Studio Code.
6. Run the project in browser using:

```bash
http://localhost/dailyblog