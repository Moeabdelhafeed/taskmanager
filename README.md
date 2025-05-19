# Task Manager (Laravel MVC)

**Task Manager** is a simple Laravel-based application designed with a pure MVC structure (no Vue or Blade views). It enables a manager to create and assign projects, users, and tasks. The application supports user submissions, feedback, and administrative oversight.

## 🎯 Features

- 🔐 Manager authentication (via login)
- 📁 Project creation and assignment to users
- ✅ Task assignment to users within projects
- 📎 Users can submit proof/evidence of task completion
- 📝 Managers can review submissions and give feedback
- ⌛ Late submission detection
- 🛠️ Admin users must be added manually via MySQL/phpMyAdmin

## 🚀 Quick Start

1. **Clone the repository** or download the source code:

   ```bash
   git clone https://github.com/your-username/task-manager.git
   cd task-manager
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Configure your `.env` file**:

   ```bash
   cp .env.example .env
   ```

   Update your database credentials and other environment variables in `.env`.

4. **Generate app key and run migrations**:

   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Run the Laravel development server**:

   ```bash
   php artisan serve
   ```

6. Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) and log in as a manager to start managing tasks!

## 🛠️ Admin Setup (Optional)

If you wish to create an admin user, you must do so manually through your MySQL database using phpMyAdmin or a database client of your choice. Set the user’s role to `admin` in the `users` table.

## 📚 Tech Stack

- Laravel (PHP Framework)
- MySQL (Database)

## 📄 License

This project is open-source and available under the MIT License.
