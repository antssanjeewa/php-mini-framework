# PHP Mini Framework

A small, opinionated MVC PHP framework inspired by Laravel's core architecture. It provides a lightweight set of building blocks for learning and simple projects: a service container, dependency injection, middleware support, a tiny router, view helpers, and a basic CLI (`artisan`).

Key features:
- Service Container & Dependency Injection
- Middleware pipeline and CSRF protection
- Simple routing and controllers
- PDO-based database helper
- Small, readable codebase for learning and prototyping

Requirements
- PHP 7.4+ with PDO extension

Quick start
1. Clone the repository:

```bash
git clone <repo-url>
cd mini-framework
```

2. Install dependencies (if you use Composer for any packages):

```bash
composer install
```

3. Configure the database in `config/database.php` and point your web server document root to the `public/` directory.

Usage
- Routes are defined in `routes/web.php`.
- Controllers live in `app/Controllers`.
- Views are in `views/` and layouts in `views/layouts`.

CLI
- Run `php artisan` for available commands (migration helpers or custom tasks).

Directory structure

```text
├── app/                    # Application controllers and models
├── bootstrap/              # Bootstrapping and container binding
├── config/                 # Configuration files
├── core/                   # Framework core (Router, Container, DB, Middleware)
├── public/                 # Front controller (index.php)
├── routes/                 # Route definitions
├── views/                  # Templates and layouts
└── artisan                 # Simple CLI entrypoint
```

Contributing
- Open issues or submit pull requests. Keep changes small and focused.

License
- MIT

---

## සිංහල විස්තරය

මෙය Laravel Framework එකෙහි මූලික ආකෘතිය (Core Architecture) පදනම් කර ගනිමින් PHP මඟින් නිර්මාණය කරන ලද සරල එහෙත් ඉතාමත් බලගතු MVC වෙබ් ෆ්‍රේම්වර්ක් එකකි. මෙහි Service Container, Dependency Injection, Middleware, Custom CLI (Artisan) සහ CSRF Protection වැනි ප්‍රධාන සංකල්ප අන්තර්ගත වේ.

### ෆෝල්ඩර් ව්‍යුහය

```text
├── app/
│   └── Controllers/        # Business Logic සහ Request හැසිරවීම
├── bootstrap/
│   └── app.php             # Service Container සහ Core Services bind කරන තැන
├── config/
│   └── database.php        # දත්ත ගබඩා වින්‍යාස
├── core/
│   ├── App.php
│   ├── Container.php
│   ├── Database/
│   ├── Http/
│   └── Middleware/
├── public/
│   └── index.php
├── routes/
│   └── web.php
└── artisan
```

