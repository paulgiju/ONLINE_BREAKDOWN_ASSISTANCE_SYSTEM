# ONLINE_BREAKDOWN_ASSISTANCE_SYSTEM
A web-based platform to connect users with nearby workshops during vehicle breakdowns.


Purpose: A web-based platform to connect users with nearby workshops during vehicle breakdowns.

Technologies Used: PHP, MySQL, Bootstrap, FontAwesome, Chart.js, XAMPP, Visual Studio Code.

Modules Included:

Homepage (public landing page with testimonials and navigation)

User Dashboard (booking requests, service history, invoices, reviews, notifications, account management)

Workshop Owner Dashboard (service requests, earnings summary, feedback, notifications, profile management)

Admin Panel (system monitoring, workshop approval, revenue tracking, customer management)

Database: MySQL relational schema with tables for users, workshops, bookings, notifications, and reviews.

Features: Real-time notifications, booking management, QR code integration, earnings visualization with Chart.js.


Project Overview
The Online Breakdown Assistance System is a web-based platform designed to connect users with nearby workshops during vehicle breakdowns. It provides separate dashboards for Users, Workshop Owners, and Administrators, ensuring smooth booking, service tracking, earnings management, and feedback collection.

📂 Project Directory
The project was originally developed and tested locally in the following directory:

Code
D:\XboxGames\htdocs\project
All PHP files are included in this repository. Supporting files such as CSS stylesheets, JavaScript libraries, and images are located in subdirectories (hb/, uhb/, wshb/, ahb/, etc.) and will be uploaded progressively.

⚙️ Technologies Used
Frontend: HTML5, CSS3, Bootstrap, FontAwesome

Backend: PHP (procedural)

Database: MySQL

Visualization: Chart.js

Development Tools: Visual Studio Code, XAMPP

🚀 Features
Homepage with hero video background and testimonials

User Dashboard: booking requests, service history, invoices, reviews, notifications, account management

Workshop Owner Dashboard: service requests, earnings summary, feedback, notifications, profile management

Admin Panel: system monitoring, workshop approval, revenue tracking, customer management

Database: normalized schema with tables for users, workshops, bookings, notifications, and reviews

🔧 Installation & Setup
Clone the repository into your local server directory (e.g., htdocs in XAMPP).

bash
git clone https://github.com/your-username/online-breakdown-assistance.git
Place the project inside:

Code
D:\XboxGames\htdocs\project
Import the provided MySQL database schema into phpMyAdmin.

Start Apache and MySQL from XAMPP Control Panel.

Access the system in your browser:

Code
http://localhost/project/homepage.php
📌 Notes
Some CSS, JS, and image files are still pending upload. Ensure you copy the hb/, uhb/, wshb/, and ahb/ directories from your local machine into the repository for full styling and functionality.

Update database connection settings in connection.php as per your local server configuration.

📖 Documentation
System Design: ER Diagram, DFDs, and database schema included in project report.

Testing: Unit, integration, and system testing performed locally.

Implementation: Deployed and tested via XAMPP environment.
