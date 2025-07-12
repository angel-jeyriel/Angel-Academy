# Angel Academy - Computer-Based Test System

**Angel Academy** contains a web-based Computer-Based Test (CBT) system built with Laravel 12, designed for educational institutions to manage and administer online tests. It supports two user roles: **Staff** (who create and manage tests) and **Students** (who take tests and view results). The system features a user-friendly interface, real-time notifications via WebSockets, and PDF result exports.

## Features

- **User Roles**:
  - **Staff**: Create, edit, and delete tests; view student results; download results as PDF.
  - **Students**: Browse available tests, take tests, and view results.
- **Test Management**:
  - Create tests with multiple-choice questions (MCQs).
  - Set test duration and assign to specific subjects and courses.
- **Test-Taking**:
  - Timer-based test sessions.
  - Automatic scoring and result display.
- **Real-Time Notifications**:
  - Staff receive WebSocket notifications when students submit tests.
- **PDF Export**:
  - Generate PDF reports of test results.
- **Authentication**:
  - Secure registration and login with role selection (staff/student) using Laravel Breeze.
- **Responsive Design**:
  - Bootstrap-styled interface for desktop and mobile compatibility.

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade templates, Bootstrap, Vite
- **Database**: MySQL
- **WebSockets**: Laravel Reverb
- **PDF Generation**: barryvdh/laravel-dompdf
- **Authentication**: Laravel Breeze
- **Others**: JavaScript (Echo for WebSockets), CSS

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 16
- MySQL
- Git
- A GitHub account

## Installation

Follow these steps to set up **Angel Academy** locally.

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/your-username/Angel-Academy.git
   cd Angel-Academy
   ```

2. **Install Dependencies**:
   - PHP dependencies:
     ```bash
     composer install
     ```
   - Node.js dependencies:
     ```bash
     npm install
     ```

3. **Configure Environment**:
   - Copy the example environment file:
     ```bash
     cp .env.example .env
     ```
   - Update `.env` with your database and Reverb settings:
     ```env
     APP_NAME="Angel Academy"
     APP_URL=http://localhost
     
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=angel_academy
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     
     REVERB_APP_ID=angel_academy
     REVERB_APP_KEY=your_reverb_key
     REVERB_APP_SECRET=your_reverb_secret
     REVERB_HOST=localhost
     REVERB_PORT=8080
     REVERB_SCHEME=http
     VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
     VITE_REVERB_HOST="${REVERB_HOST}"
     VITE_REVERB_PORT="${REVERB_PORT}"
     VITE_REVERB_SCHEME="${REVERB_SCHEME}"
     ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Set Up Database**:
   - Create a MySQL database (e.g., `angel_academy`).
   - Run migrations and seed the database:
     ```bash
     php artisan migrate
     php artisan db:seed
     ```

6. **Install Frontend Assets**:
   ```bash
   npm run build
   ```

7. **Start Servers**:
   - Laravel development server:
     ```bash
     php artisan serve
     ```
   - Reverb WebSocket server:
     ```bash
     php artisan reverb:start
     ```
   - Vite development server (for hot reloading):
     ```bash
     npm run dev
     ```

8. **Access the Application**:
   - Open `http://localhost:8000` in your browser.
   - Register as a **Staff** or **Student** to explore the system.

## Usage

### Staff
- **Login/Register**: Use `/register` to create a staff account (select "Staff" role).
- **Manage Tests**: Navigate to `/staff/tests` to create, edit, or delete tests.
- **View Results**: Go to `/staff/tests/{id}/results` to see student attempts and download PDF reports.
- **Notifications**: Receive real-time alerts when students submit tests.

### Students
- **Login/Register**: Use `/register` to create a student account (select "Student" role).
- **Dashboard**: Access `/student/dashboard` to browse available tests by course and subject.
- **Take Tests**: Start a test, answer MCQs, and submit. Results are displayed immediately.
- **View Results**: Check scores at `/student/results/{attempt}`.

## Database Schema

Key tables:
- **users**: `id`, `name`, `email`, `password`, `role` (enum: `student`, `staff`), `created_at`, `updated_at`
- **courses**: `id`, `name`, `description`
- **subjects**: `id`, `course_id`, `name`
- **tests**: `id`, `subject_id`, `title`, `duration`
- **questions**: `id`, `test_id`, `text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`
- **test_attempts**: `id`, `user_id`, `test_id`, `score`, `completed_at`
- **answers**: `id`, `test_attempt_id`, `question_id`, `selected_option`

## Seeding

The `DatabaseSeeder` populates:
- 1 staff user: `staff@example.com` / `password`
- 1 student user: `student@example.com` / `password`
- Sample courses, subjects, tests, and questions.

Run:
```bash
php artisan db:seed
```

## WebSocket Notifications

Staff receive real-time notifications via Laravel Reverb when students submit tests. Ensure the Reverb server is running:
```bash
php artisan reverb:start
```

## Deployment

To deploy **Angel Academy** to a production server (e.g., Heroku, AWS, or a VPS):

1. **Set Up Environment**:
   - Configure `.env` with production database and Reverb settings.
   - Set `APP_ENV=production` and `APP_DEBUG=false`.

2. **Optimize Application**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   composer install --optimize-autoloader --no-dev
   npm run build
   ```

3. **Server Requirements**:
   - PHP 8.2+, MySQL, Node.js
   - Web server (e.g., Apache/Nginx)
   - Supervisor for Reverb WebSocket server

4. **Database**:
   - Run migrations:
     ```bash
     php artisan migrate --force
     ```

5. **WebSocket**:
   - Configure Reverb for production (e.g., use Redis or a dedicated host).

Refer to [Laravel Deployment Documentation](https://laravel.com/docs/12.x/deployment) for detailed steps.

## Troubleshooting

- **Migration Errors**:
  - Ensure the database is created and `.env` is configured.
  - Clear caches:
    ```bash
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    ```
- **WebSocket Issues**:
  - Verify Reverb is running and `.env` settings are correct.
  - Check browser console and `storage/logs/laravel.log` for errors.
- **Authentication**:
  - Ensure `role` is set during registration (via `/register`).

## Contributing

Contributions are welcome! To contribute:
1. Fork the repository.
2. Create a feature branch:
   ```bash
   git checkout -b feature/your-feature
   ```
3. Commit changes:
   ```bash
   git commit -m "Add your feature"
   ```
4. Push to your fork:
   ```bash
   git push origin feature/your-feature
   ```
5. Open a Pull Request.

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.

## Contact

For questions or support, contact eberechukwuaustine3@gmail.com or open an issue on GitHub.

---

Built with ❤️ by Ebere Austine.
P.S. 
//I read the job post - hello from Tekfolio!?
