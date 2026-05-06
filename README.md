# Website CV ATS Maker 🚀

A modern, web-based CV builder with a striking **Neo-Brutalist** aesthetic. Built for speed, responsiveness, and unique visual identity.

![Neo-Brutalist Design](https://img.shields.io/badge/Design-Neo--Brutalist-yellow?style=for-the-badge)
![Laravel 13](https://img.shields.io/badge/Laravel-13-red?style=for-the-badge&logo=laravel)
![Vue 3](https://img.shields.io/badge/Vue.js-3-green?style=for-the-badge&logo=vuedotjs)
![Inertia.js](https://img.shields.io/badge/Inertia.js-Latest-purple?style=for-the-badge)

## ✨ Features

- **Unique Neo-Brutalist UI**: High-contrast colors, thick black borders, and hard shadows.
- **1:1 Live Preview**: See your CV exactly as it will appear in the final PDF.
- **Seamless Editing**: Fast and responsive editor powered by Inertia.js and Vue 3.
- **PDF Export**: Download your CV in high-quality PDF format.
- **No Login Required**: Jump straight into building your CV without any friction.

## 🛠 Tech Stack

- **Backend**: Laravel 13
- **Frontend**: Vue 3 with Inertia.js
- **Styling**: Tailwind CSS
- **PDF Engine**: DomPDF
- **Database**: SQLite/MySQL (JSON-based CV structure)

## 🚀 Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/rahadyadaffa-glitch/website-cv-ats-maker.git
   cd website-cv-ats-maker
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install JS dependencies**:
   ```bash
   npm install
   ```

4. **Setup environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run migrations and seeders**:
   ```bash
   php artisan migrate --seed
   ```

6. **Compile assets**:
   ```bash
   npm run dev
   ```

7. **Start the server**:
   ```bash
   php artisan serve
   ```

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
