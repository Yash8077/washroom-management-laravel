# 🚻 Washroom Management System (WMS)

## 📘 Overview

The **Washroom Management System (WMS)** is a web-based platform designed to improve hygiene standards, streamline cleaning operations, and optimize maintenance workflows within facilities. By offering real-time monitoring, task management, issue reporting, and analytics, WMS helps facility managers ensure cleanliness and functionality across all washrooms.

Replacing manual tracking (e.g., logbooks, checklists) with a digital solution, WMS enhances operational efficiency and provides actionable insights.


## ✅ Key Features

* **🟢 Real-Time Washroom Monitoring**
  View live status indicators such as cleanliness, occupancy (if available), supply levels, last cleaned timestamps, and open issues.

* **🧹 Task Management**
  Create, assign, schedule, and track routine cleaning or urgent maintenance tasks. Staff can view, update, and complete tasks from any device.

* **🚨 Issue Reporting & Resolution**
  Users or staff can report problems like spills, broken fixtures, or empty dispensers. Admins can assign these reports as tasks and track resolution progress.

* **🏢 Location & User Management**
  Manage hierarchical locations (e.g., buildings, floors, specific washrooms) and assign roles to admin or cleaning staff users.

* **📊 Analytics & Reporting**
  Access dashboards showing usage trends, cleaning frequencies, issue resolution times, resource consumption, and more.

* **🔐 Role-Based Access Control**

  * **Administrators**: Full system access for managing locations, users, tasks, and reports.
  * **Staff**: Limited access to assigned tasks, issue reporting, and supply updates via a mobile-friendly interface.
  * **Facility Users** (optional): Can report issues via a simple interface—optionally QR code-linked, no login required.

* **🔔 Notifications & Alerts**
  Get automatic alerts for urgent tasks, critical maintenance, or low supplies.

* **📱 Responsive Design**
  Fully optimized for desktop, tablet, and mobile devices.

## 🛠️ Technology Stack

| Layer          | Tech Used       |
| -------------- | --------------- |
| Backend        | Laravel (PHP)   |
| Database       | MySQL           |
| Frontend       | Blade Templates |
| Styling        | Tailwind CSS    |
| Asset Bundling | Vite            |


## 👤 User Roles

* **Admin** – Manages users, tasks, locations, and generates reports.
* **Staff** – Handles assigned cleaning and maintenance tasks.
* **Facility User** *(optional)* – Reports issues anonymously or via QR code.


## 🚀 Installation & Setup

1. **Clone the Repository**

   ```bash
   git clone [https://github.com/Yash8077/washroom-management-laravel/]
   cd washroom-management-laravel
   ```

2. **Install Dependencies**

   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edit `.env` and set your database credentials and app settings.

4. **Run Migrations**

   ```bash
   php artisan migrate
   ```

5. **Seed the Database (Optional)**

   ```bash
   php artisan db:seed
   ```

6. **Compile Frontend Assets**

   * For development:

     ```bash
     npm run dev
     ```
   * For production:

     ```bash
     npm run build
     ```

7. **Serve the Application**

   ```bash
   php artisan serve
   ```

   Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)


## 📄 License

This project is licensed under the [MIT License](LICENSE).


