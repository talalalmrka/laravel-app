# Fadgram Laravel Starter Kit

Welcome to the **Fadgram Laravel Starter Kit**! This starter kit is designed to help you kickstart your Laravel projects with a pre-configured setup and essential features.

## Tech Stack

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)

## Features

-   **Laravel Framework**: Built on the latest version of Laravel.
-   **Authentication**: Pre-configured authentication system.
-   **API Ready**: Includes basic API scaffolding.
-   **Responsive UI**: Starter templates with responsive design.
-   **Database Migrations**: Predefined migrations for common use cases.
-   **Environment Configuration**: `.env.example` file for easy setup.

## Requirements

-   PHP >= 8.1
-   Composer
-   Node.js & npm
-   MySQL or any supported database

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/talalalmrka/laravel-fadgram.git
    cd laravel-fadgram
    ```

2. Install dependencies:

    ```bash
    composer install
    npm install
    ```

3. Set up the environment:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Configure your `.env` file with database and other settings.

5. Run migrations:

    ```bash
    php artisan migrate
    ```

6. Start the development server:
    ```bash
    php artisan serve
    npm run dev
    ```

## Usage

-   Access the application at `http://localhost:8000`.
-   Customize the starter kit to fit your project requirements.

## Contributing

Contributions are welcome! Feel free to fork the repository and submit a pull request.

## License

This project is open-source and available under the [MIT License](LICENSE).

Happy coding with **Fadgram Laravel Starter Kit**!
