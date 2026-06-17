# 🐾 Animal Adoption Website

A full-stack web application built using PHP, MySQL, and PDO that helps connect animals in shelters with potential adopters. Users can browse animals, schedule shelter visits, make donations, and manage their profiles through an intuitive and user-friendly interface.

---

## ✨ Features

### 👤 User Features

* Secure Registration & Login
* User Profile Management
* Browse Available Animals
* Search & Filter Animals
* View Detailed Animal Information
* Book Shelter Visit Appointments
* Make Donations

### 🛠️ Admin Features

* Add New Animals
* Create Appointment Time Slots
* View Donation Records
* Manage Appointment Data
* Generate Reports

---

## 🛠️ Tech Stack

* PHP
* MySQL
* PDO
* HTML
* CSS
* WAMP / XAMPP

---

## 📂 Project Structure

```text
animal-adoption-website/
│
├── README.md
├── database.sql
├── config.php
│
├── User Features
│   ├── register.php
│   ├── login.php
│   ├── logout.php
│   ├── profile.php
│   └── appointments.php
│
├── Animal Management
│   ├── animals.php
│   ├── shelters.php
│   └── detail.php
│
├── Admin Features
│   ├── add.php
│   ├── addslot.php
│   └── reports.php
│
├── Layout
│   ├── head.php
│   └── foot.php
│
└── index.php
```

---

## 🗄️ Database Tables

* users
* shelters
* animals
* time_slots
* appointments
* donations

---

## 🚀 Getting Started

1. Clone Repository

```bash
git clone https://github.com/anshhchauhan62/animal-adoption-website.git
```

2. Import Database

Import:

`database.sql`

using phpMyAdmin.

3. Configure Database

Update credentials inside:

`config.php`

4. Start Server

Run WAMP/XAMPP and open:

```text
http://localhost/animal-adoption-website/
```

---

## 🔐 Demo Admin Account

**Email:** `admin@adoption.com`

**Password:** `password`

---

## 📈 Future Improvements

* Animal Image Uploads
* Email Notifications
* Adoption Tracking Workflow
* Advanced Search Filters
* Mobile Responsive UI
* Analytics Dashboard

---

## 📚 What I Learned

* PHP CRUD Operations
* Session-Based Authentication
* PDO Database Connectivity
* Relational Database Design
* SQL Queries & Joins
* Form Validation

---

## 👨‍💻 Author

Aadity Darji

Aspiring Software Developer interested in Python, Data Analytics, AI/ML, and Motorsport Technology.
