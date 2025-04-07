# Tasklib 

## About the Project

**Task Management System** is a web application built with Laravel, designed for efficient task management. It allows users to view, start, and complete tasks, while administrators can create, edit, and delete tasks, as well as view task analytics. The application features a modern design with dark mode support, smooth animations, and intuitive task filtering.

This project is ideal for teams or educational environments where users can take on tasks, track their progress, and submit solutions via GitHub links.

**Repository**: [CodeByAbduqodir/tasklib](https://github.com/CodeByAbduqodir/tasklib.git)

---

## Features

- **Authentication and Roles**:
  - User registration and login.
  - Role-based access: regular users and administrators.
  - Admin-only access to task management features.

- **Task Management**:
  - Users can view available tasks, start them, and complete them by submitting a GitHub link.
  - Admins can create, edit, and delete tasks.
  - Task fields include: title, description, requirements, required knowledge, resources, difficulty, status, deadline, solution, and tags.

- **Filtering and Sorting**:
  - Filter tasks by status (`available`, `in_progress`, `completed`) and difficulty (`easy`, `medium`, `hard`).
  - Sort tasks by title, difficulty, status, and creation date (ascending/descending).

- **Analytics**:
  - Both user and admin dashboards display analytics: total tasks, tasks by status, and tasks by difficulty.
  - Modern card-based analytics design with animations.

- **UI/UX**:
  - Dark mode support (automatic switching).
  - Fade-in animations for page elements.
  - Modern design using Tailwind CSS.
  - Responsive layout for various devices.

- **Additional Features**:
  - Pagination for task lists.
  - Success notifications for actions (e.g., task creation/deletion).
  - Font Awesome icons for enhanced visual design.

---

## Installation

Follow these steps to set up and run the project locally.

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js and npm
- MySQL (or another supported database)
- Git

### Installation Steps

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/CodeByAbduqodir/tasklib.git
   cd tasklib
   ```

2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript/CSS Dependencies**:
   ```bash
   npm install
   ```

4. **Set Up Environment File**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Configure your database settings in `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=task_management
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations**:
   - Create a database named `task_management` in MySQL.
   - Run migrations to set up the database tables:
     ```bash
     php artisan migrate
     ```

7. **Compile Styles and Scripts**:
   ```bash
   npm run dev
   ```

8. **Start the Local Server**:
   ```bash
   php artisan serve
   ```

9. **Create a Test User**:
   - Register a user via the interface (`/register`).
   - To create an admin, manually set the `is_admin` field to `1` in the `users` table for the desired user.

10. **Access the Application**:
    Open `http://localhost:8000` in your browser.

---

## Project Structure

Below is the structure of the project with descriptions of key directories and files:

```
tasklib/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── TaskController.php  # Controller for managing tasks
│   │   └── Middleware/
│   │       └── Admin.php           # Middleware for admin access control
│   ├── Models/
│   │   ├── Task.php                # Task model
│   │   ├── TaskUser.php            # Model for task-user relationship (progress tracking)
│   │   └── User.php                # User model
│   └── Providers/
│       └── AppServiceProvider.php  # Application service provider
├── database/
│   ├── migrations/                 # Migrations for database schema
│   └── seeders/                    # Seeders for populating test data
├── public/                         # Public assets (CSS, JS, images)
├── resources/
│   ├── css/
│   │   └── app.css                 # Main styles (Tailwind CSS)
│   ├── js/
│   │   └── app.js                  # Main scripts (Alpine.js, etc.)
│   └── views/
│       ├── admin/
│       │   └── dashboard.blade.php # Admin dashboard template
│       ├── tasks/
│       │   ├── create.blade.php    # Template for creating tasks
│       │   ├── edit.blade.php      # Template for editing tasks
│       │   ├── index.blade.php     # Template for public task list
│       │   └── show.blade.php      # Template for viewing a task
│       ├── dashboard.blade.php     # User dashboard template
│       ├── layouts/
│       │   ├── app.blade.php       # Main application layout
│       │   └── navigation.blade.php# Navigation bar template
│       └── welcome.blade.php       # Homepage template
├── routes/
│   └── web.php                     # Application routes
├── .env.example                    # Example environment file
├── composer.json                   # PHP dependencies
├── package.json                    # JavaScript dependencies
└── README.md                       # Project documentation
```

---

### Additional Notes

- **Styling**: The project uses Tailwind CSS for styling, with custom styles defined in `resources/css/app.css`.
- **Dark Mode**: Dark mode is implemented using Tailwind’s `dark` variant classes and toggled via JavaScript (likely in `navigation.blade.php`).
- **Future Improvements**:
  - Add Chart.js for visualizing analytics (e.g., task status and difficulty charts).
  - Implement more advanced analytics (e.g., user activity, completed tasks per user).
  - Write tests to ensure functionality (e.g., using PHPUnit for backend tests).
