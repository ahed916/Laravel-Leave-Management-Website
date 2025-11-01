Laravel Leave Management System

This is a Laravel-based Leave Management Web Application designed to manage leave requests efficiently.
It supports admin and employee roles and provides a comprehensive dashboard, leave tracking, calendar view, and reporting tools.

🚀 Features
Admin Role

Full user management:

Add, remove, activate/deactivate, and update users

View a list of all users

Leave management:

Approve, reject, or view pending leave requests

Calendar view with pending and approved leaves

Statistics:

Overview of number of users, pending, approved, and rejected leaves

Export functionality:

Export leave information and reports as CSV and PDF files

Dashboard:

Interactive calendar

Quick summary of user leave data

Employee Role

Submit leave requests:

Select start date, end date, and leave type

View leave history:

Track approved, pending, and rejected leaves

Calendar view of accepted leaves

🎨 Technologies Used

Backend: Laravel 12

Frontend: Tailwind CSS, Blade Templates

Authentication: Laravel Breeze

Mail Notifications: For leave submission and status updates

Export Functionality: CSV and PDF

Database: MySQL (or preferred SQL database)

⚙️ Installation

Clone the repository

git clone https://github.com/your-username/laravel-leave-management.git
cd laravel-leave-management


Install dependencies

composer install
npm install
npm run build


Set up environment

Copy .env.example to .env

cp .env.example .env


Configure your database credentials in .env

Generate application key

php artisan key:generate


Run migrations and seed database

php artisan migrate --seed


Run the application

php artisan serve


Open your browser at http://localhost:8000

📧 Email Notifications

Leave submitted to admin: Sends an email notification to the admin when a user submits a leave request.

Leave status updated: Sends an email to the user when their leave request is approved or rejected.
