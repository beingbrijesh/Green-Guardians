# Bin Buddy - Smart Waste Tracking and Reporting System

## 📋 Project Overview
The QR-Based Smart Bin System is a smart waste management solution designed to enable quick and efficient reporting of waste bin status through QR codes. Users can simply scan the QR code on a bin to report if it is full, damaged, or needs attention, helping authorities take faster action and maintain cleaner environments.

## 🧩 Features
- **QR Code Integration**: Unique QR codes assigned to each bin for easy identification.
- **User-Friendly Reporting**: Scan-and-report system — no need for app installation.
- **Real-Time Notifications**: Immediate alerts to waste management teams after a report.
- **Backend Management**: Admin panel to monitor, manage, and track bin statuses.
- **Scalable Design**: Easy to add new bins and manage multiple locations.
- **Data Insights**: Collects reporting data for optimizing collection schedules.

## ⚙️ Technology Stack
- **Frontend**: HTML, CSS (Bootstrap), JavaScript
- **Backend**: Firebase
- **Database**: MySQL / Firebase
- **QR Code Generation**: Dynamic QR codes linked to unique bin IDs

## Installation

To set up the project locally:

### Clone the Repository
```bash
# Start: Clone repository
git clone https://github.com/beingbrijesh/Green-Guardians
cd Green-Guardians
# End: Clone repository
```
### Install Dependencies
```bash
npm install
```
### Setup Instructions

### Step 1: Setup Environment Variables
1. Copy `.env.example` to `.env`.
2. Configure the following in the `.env` file:
   - **Database settings**
   - **JWT secret**

### Step 2: Setup the Database
1. Create a new database named `my_db`.
2. Run the SQL commands from `src/database/schema.sql` to set up the tables.
3. Ensure your `.env` configuration matches your database setup.

You're all set! 🚀

### Run the Project
```bash
npm start
```
The server should start on http://localhost:3306 by default.

## 🧠 How It Works
- **QR Generation**: Each bin is registered and assigned a QR code linked to its unique ID.
- **User Scan**: When a bin is full, users scan the QR code using any smartphone camera.
- **Status Reporting**: After scanning, users are redirected to a simple form to submit bin status.
- **Backend Logging**: The system logs the report, updates the bin status, and alerts the admin panel.
- **Action Trigger**: Cleaning staff are notified for timely bin collection.

## 🚀 Future Enhancements
- **Sensor Integration**: Automatic bin status detection using IoT sensors.
- **Mobile App**: Android/iOS app for smoother user experience and reporting.
- **Gamification**: Reward users for genuine and frequent reporting.
- **AI-Based Validation**: Image analysis to verify bin fullness from uploaded photos.
- **Smart Routing**: AI-optimized collection routes based on real-time data.

## ⚡ Drawbacks and Mitigation

### Drawback
- User-dependent reporting
- False reporting
- QR code damage
- Internet issues

### Solution
- Incentivize users and combine with sensor data
- Use verification steps like photo uploads and admin approval
- Use durable, weatherproof QR stickers
- Create a lightweight, offline-capable reporting page

## 🙌 Contributors
- **Brijesh Yadav** (Frontend Developer)
- **Amit Patel** (Full Stack Developer)
- **Shivam Sharma** (Backend Developer)

## 📄 License
This project is open-source and available under the MIT License.

## 🌟 Acknowledgments
- Inspiration from Smart City Initiatives
- Bootstrap for UI Components
- Open-Source QR Code Libraries

