# PHP MVC Learning Framework

## Introduction

This repository contains a simple PHP MVC (Model-View-Controller) framework designed specifically for students and beginners who want to understand how modern PHP frameworks like Laravel work under the hood. The goal is to provide a clear, minimal, and approachable codebase for learning the core concepts of MVC architecture and framework design.

## Features

- **Custom Router**: Handles dynamic and static routes, including route parameters and patterns.
- **Dispatcher**: Resolves controllers and actions based on routes.
- **Dependency Injection Container**: Manages class dependencies, similar to Laravel's service container.
- **MVC Structure**: Clean separation of Models, Views, and Controllers.
- **Error Handling**: Basic exception handling for routing and dispatching.

## How it Relates to Laravel

While this framework is intentionally simple, it is inspired by how Laravel operates internally:

- **Routing**: The custom router mimics Laravel's approach to route definitions and parameter handling.
- **Controllers & Actions**: Requests are dispatched to controllers and actions in a way similar to Laravel's controller resolution.
- **Dependency Injection**: The container provides a basic version of Laravel's powerful service container, allowing for dependency injection in controllers and other classes.
- **Autoloading**: Uses a PSR-4-like autoloader for class files, similar to Composer's autoloading in Laravel.

> **Note:** This project is a **work in progress**. I am actively updating and improving it, but development may stop soon. Please use it as a learning resource while updates last!

## Getting Started

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd simple-php-mvc-framework
   ```
2. **Set up your web server:**
   - Point your document root to the project directory.
   - Make sure you have PHP 8.0+ installed.
3. **Configure the database:**
   - Update the database credentials in `index.php` if needed.
4. **Access the app:**
   - Open your browser and navigate to `http://localhost/` (or your configured domain).

## Project Structure

```
simple-php-mvc-framework/
├── index.php                # Front controller
├── src/
│   ├── App/
│   │   ├── Controllers/     # Application controllers
│   │   ├── Models/          # Application models
│   │   └── Database.php     # Database connection
│   └── Framework/           # Core framework classes
│       ├── Router.php
│       ├── Dispatcher.php
│       ├── Container.php
│       └── Viewer.php
├── views/                   # View templates
└── composer.json            # Composer dependencies (if any)
```

## Disclaimer

This framework is **not** intended for production use. It is a learning tool to help you understand the basics of how MVC frameworks like Laravel are structured and operate internally. For real-world applications, always use a mature framework such as [Laravel](https://laravel.com/).

## Contributing

Contributions are welcome, especially if you want to help improve the learning experience for others! If you have suggestions, bug fixes, or want to add simple features that align with the educational purpose of this project, feel free to open an issue or submit a pull request.

**Guidelines:**
- Keep code and features simple and easy to understand.
- Add comments and documentation where helpful.
- Ensure any new code fits the educational focus of the project.

Thank you for helping make this a better resource for learners!

## PHP MVC Concepts Covered

This project demonstrates several foundational concepts in PHP MVC framework development:

- **Front Controller Pattern**: All requests are routed through a single entry point (`index.php`).
- **Routing**: Mapping URLs to controllers and actions, including dynamic route parameters.
- **Controllers**: Classes that handle user requests and coordinate responses.
- **Models**: Classes that represent and interact with data (e.g., `Product.php`).
- **Views**: Templates for rendering HTML output.
- **Dependency Injection**: Using a container to manage and inject dependencies.
- **Autoloading**: Dynamically loading classes as needed.
- **Namespaces**: Organizing code into logical groups.
- **Error Handling**: Basic exception handling for routing and dispatching.
- **Separation of Concerns**: Keeping business logic, presentation, and routing separate.

### Useful Resources

- [PHP: The Right Way](https://phptherightway.com/)
- [MVC Pattern Explained](https://www.geeksforgeeks.org/mvc-design-pattern/)
- [Laravel Documentation - The Basics](https://laravel.com/docs/10.x)
- [Symfony Routing Component](https://symfony.com/doc/current/components/routing.html)
- [PSR-4: Autoloader Standard](https://www.php-fig.org/psr/psr-4/)
- [Dependency Injection in PHP](https://php-di.org/doc/)

---

Happy learning! 🚀