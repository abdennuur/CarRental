# 🚗 CarBNB - Online Car Rental System

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blueviolet)
![MySQL Version](https://img.shields.io/badge/MySQL-5.7%2B-orange)
![License](https://img.shields.io/badge/License-MIT-green)

A full-featured online car rental platform enabling users to book vehicles and administrators to manage fleet operations, bookings, and website content efficiently.

![CarBNB Interface](https://via.placeholder.com/800x400.png?text=CarBNB+Screenshots)

## Table of Contents
- [Features](#-features)
- [Installation](#-installation)
- [Usage](#-usage)
- [Customization](#-customization)
- [Security](#-security)
- [Technologies](#-technologies)
- [License](#-license)
- [Contributing](#-contributing)
- [Troubleshooting](#-troubleshooting)
- [Contact](#-contact)

## ✨ Features

### **Admin Panel**
📊 Dashboard Analytics  
🚗 Vehicle & Brand Management  
📅 Booking Management System  
✉️ Testimonial & Message Moderation  
🌐 Dynamic Content Management  
👥 User & Subscriber Management  
🔒 Password & Security Settings  

### **User Features**
🔍 Vehicle Catalog with Filters  
📅 Online Booking System  
📝 Testimonial Submission  
💌 Contact Form  
👤 Profile Management  
📋 Booking History Tracking  

## 🛠️ Installation

### Prerequisites
- Web Server (XAMPP/WAMP)
- PHP ≥ 7.4
- MySQL ≥ 5.7

### Setup Guide
1. **Start Services**
   ```bash
   # Start Apache and MySQL
   sudo service apache2 start && sudo service mysql start

### Deploy Project
 # Extract to server directory:
XAMPP: htdocs/CarRental
WAMP: www/CarRental

### Database Setup
CREATE DATABASE carrental;
USE carrental;
SOURCE path/to/carrental.sql;

### Access Application
    Frontend: http://localhost/CarRental
    Admin Panel: http://localhost/CarRental/admin
Default Admin Credentials:
Username: admin
Password: admin

### Usage
For Administrators
Manage vehicles through Brands > Vehicles

Monitor bookings in real-time

Update website content via Pages Manager

Handle user testimonials and messages

For Users
Register/Login to account

Browse and book vehicles

Manage bookings in dashboard

Submit testimonials post-rental

### Customization
    // config.php
    $host = "localhost";
    $user = "root"; 
    $pass = "";
    $database = "carrental";

## 🤝 Contributing
    Fork repository

    Create feature branch (git checkout -b feature/NewFeature)

    Commit changes (git commit -m 'Add NewFeature')

    Push to branch (git push origin feature/NewFeature)

    Open Pull Request