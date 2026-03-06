# 🎫 Event Ticketing & Merchandise Store

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Stripe](https://img.shields.io/badge/Stripe-626CD9?style=for-the-badge&logo=stripe&logoColor=white)](https://stripe.com)
[![Spotify](https://img.shields.io/badge/Spotify-1DB954?style=for-the-badge&logo=spotify&logoColor=white)](https://spotify.com)

A high-performance Full-Stack event ticketing platform built with **Laravel**, **Tailwind CSS**, and **Alpine.js**. This application streamlines event discovery, performer engagement, and secure ticket purchasing with automated delivery.

## 🌟 Key Features

*   **Secure Payments:** Integrated **Stripe Checkout** with 3D-secure support and real-time order tracking.
*   **Spotify Integration:** Dynamically fetches and displays performer top tracks and previews using the **Spotify API**.
*   **Performance Optimized:** leveraged **Laravel Queues** (Database/Redis) for background tasks like automated ticket emails.
*   **Smart Promo Engine:** Advanced discount code system with percentage-based logic, expiration dates, and usage limits.
*   **Responsive UI:** Premium interface built with **Blade Components**, **Tailwind CSS**, and **Bootstrap 5**.
*   **Real-time Interaction:** Live countdown timers for events and dynamic pricing updates during checkout.

## 🛠️ Tech Stack

*   **Backend:** Laravel 8.x, PHP 7.4/8.x
*   **Frontend:** Blade, Tailwind CSS, Alpine.js, Bootstrap 5
*   **Database:** MySQL
*   **Services:** Stripe API, Spotify Web API
*   **Infrastructure:** Laravel Queues (Job Processing), Mailtrap/SMTP (Email)

## 🚀 Quick Start

### 1. Prerequisites
*   PHP >= 7.3
*   Composer
*   Node.js & NPM
*   MySQL

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/vipultikhe234/Event-Ticketing-and-Merchandise-Store.git
cd Event-Ticketing-and-Merchandise-Store

# Install PHP dependencies
composer install

# Install JS dependencies
npm install && npm run dev

# Generate Encryption Key
php artisan key:generate
```

### 3. Environment Setup
Copy `.env.example` to `.env` and configure:
*   **Database:** `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
*   **Stripe:** `STRIPE_KEY`, `STRIPE_SECRET`
*   **Spotify:** `SPOTIFY_CLIENT_ID`, `SPOTIFY_CLIENT_SECRET`
*   **Queue:** `QUEUE_CONNECTION=database`

### 4. Database & Queues
```bash
# Run migrations and seeders
php artisan migrate --seed

# Start the queue worker (for emails)
php artisan queue:work
```

### 5. Launch
```bash
php artisan serve
```

## 📂 Project Structure Highlights
*   `app/Http/Controllers/CheckoutController.php`: Handles core Stripe logic and order fulfillment.
*   `app/Http/Controllers/EventController.php`: Manages event data and Spotify API integration.
*   `app/Jobs/SendTicketEmail.php`: Asynchronous job for high-speed ticket delivery.
*   `resources/views/components/`: Reusable Blade components for UI consistency.

## 🛡️ License
Distributed under the MIT License. See `LICENSE` for more information.

---
*Created by [Vipul Tikhe](https://github.com/vipultikhe234)*
