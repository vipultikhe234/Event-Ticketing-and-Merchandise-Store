# 🎵 Event Ticketing & Merchandise Store

A full-featured Laravel web application for a fictional music festival — allowing users to browse events, purchase tickets, buy merchandise, and discover performer music via Spotify integration.

---

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Database Schema](#-database-schema)
- [API Endpoints](#-api-endpoints)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Environment Configuration](#-environment-configuration)
- [Running the Application](#-running-the-application)
- [Running Tests](#-running-tests)
- [Third-Party Integrations](#-third-party-integrations)
- [Ngrok Setup (for Stripe Webhooks)](#-ngrok-setup-for-stripe-webhooks)
- [Caching Strategy](#-caching-strategy)
- [PHP Extensions Required](#-php-extensions-required)

---

## ✨ Features

- 🎟️ **Event Ticketing** — Browse events, view performer details, and purchase tickets via Stripe Checkout
- 🛍️ **Merchandise Store** — Browse and buy official festival merchandise
- 🎧 **Spotify Integration** — View top tracks for performers using the Spotify Web API
- 💸 **Discount Codes** — Apply coupon codes for percentage-based discounts at checkout
- ⏱️ **Countdown Timer** — Live countdown to each event via a custom Blade component
- 🔌 **RESTful API** — JSON API for events and merchandise with proper resource formatting
- ⚡ **Caching** — Spotify responses, event listings, and merchandise cached for performance
- 🧪 **Automated Tests** — Feature tests for dashboard rendering and RESTful API
- 🔐 **Authentication** — Session-based login/register for users

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.x, Laravel 8 |
| Frontend | Bootstrap 5, Alpine.js, SCSS via Laravel Mix |
| Database | MySQL |
| Payments | Stripe Checkout |
| Music API | Spotify Web API |
| Caching | File-based Cache (configurable to Redis) |
| Queue | Database / Sync driver |
| Icons | Font Awesome 6 (CDN) |
| Testing | PHPUnit 9 |

---

## 🗄 Database Schema

```
users               — Registered users
performers          — Artists/performers (with Spotify ID, bio, image, category)
events              — Festival events (linked to performer + category)
event_performer     — Pivot table for many-to-many event ↔ performer relationship
categories          — Categories for events and performers (e.g. Rock, Jazz)
merchandises        — Festival merchandise (name, price, stock, image)
discount_codes      — Coupon codes with percentage discount and expiry
orders              — Ticket and merchandise orders (linked to Stripe session)
jobs                — Queue jobs table
```

---

## 🔌 API Endpoints

All API routes are prefixed with `/api`.

### Events
| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/api-events` | List all events (with performers & category) |
| `GET` | `/api/api-events/{id}` | Get a single event |
| `POST` | `/api/register_performer` | Register a new performer |
| `POST` | `/api/register_event` | Register a new event |
| `GET` | `/api/get_performer` | Get event with performers and Spotify tracks |

### Merchandise
| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/merchandise` | List all merchandise |
| `GET` | `/api/merchandise/{id}` | Get a single merchandise item |

### Checkout
| Method | Endpoint | Description |
|---|---|---|
| `POST` | `/api/book-event` | Book tickets or buy merchandise (Stripe) |
| `GET` | `/api/booking/success` | Verify Stripe payment success |
| `GET` | `/api/booking/cancel` | Handle cancelled payment |
| `POST` | `/api/check_coupon` | Validate a discount coupon code |
| `POST` | `/api/insert_coupon` | Create a new discount coupon |

---

## ✅ Prerequisites

Make sure you have the following installed:

- **PHP** >= 8.0
- **Composer** >= 2.x
- **Node.js** >= 16.x & **npm** >= 8.x
- **MySQL** >= 5.7
- **Git**

Enable these PHP extensions in `php.ini`:
```
extension=curl
extension=openssl
extension=mbstring
extension=pdo_mysql
extension=bcmath
extension=fileinfo
extension=redis    ; optional, for Redis caching
```

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/vipultikhe234/Event-Ticketing-and-Merchandise-Store.git
cd Event-Ticketing-and-Merchandise-Store
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies & Compile Assets

```bash
npm install
npm run dev
```

### 4. Set Up Environment File

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure Database

Update your `.env` file with your MySQL database credentials (see [Environment Configuration](#-environment-configuration)).

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Seed the Database

```bash
php artisan db:seed --class=CategoryAndMerchandiseSeeder
```

This seeds:
- 5 event categories (Music Festival, Rock, Pop, Electronic, Jazz)
- 4 merchandise items (T-Shirt, Hoodie, Poster, Wristband)
- Links existing events/performers in the pivot table

---

## ⚙️ Environment Configuration

Copy `.env.example` to `.env` and fill in the following:

```dotenv
APP_NAME="Event Ticketing"
APP_ENV=local
APP_KEY=          # Generated by php artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost:8000   # Use your Ngrok URL for Stripe webhooks

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=musicfest
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file      # Change to 'redis' for Redis caching
QUEUE_CONNECTION=sync  # Change to 'database' for background queues

# Stripe (get keys at https://dashboard.stripe.com/apikeys)
STRIPE_KEY=pk_test_xxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxx

# Spotify (get keys at https://developer.spotify.com/dashboard)
SPOTIFY_CLIENT_ID=your_spotify_client_id
SPOTIFY_CLIENT_SECRET=your_spotify_client_secret

# JWT (optional, for API auth)
JWT_SECRET=your_jwt_secret
```

---

## ▶️ Running the Application

```bash
php artisan serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

**Optional — start the queue worker** (for background jobs like emails):

```bash
php artisan queue:work
```

---

## 🧪 Running Tests

```bash
php artisan test
```

Or run only the feature tests:
```bash
vendor/bin/phpunit tests/Feature/EventTest.php
```

**Test coverage includes:**
- ✅ Dashboard renders correctly for authenticated users with event data
- ✅ RESTful Events API returns proper JSON response

---

## 🔗 Third-Party Integrations

### 💳 Stripe Payments

1. Sign up at [https://stripe.com](https://stripe.com)
2. Get your **Publishable Key** and **Secret Key** from the Stripe Dashboard
3. Add them to `.env` as `STRIPE_KEY` and `STRIPE_SECRET`
4. The app uses **Stripe Checkout** — users are redirected to Stripe's hosted payment page
5. After payment, Stripe redirects back with a `session_id` which the app verifies

### 🎧 Spotify API

1. Sign up at [https://developer.spotify.com](https://developer.spotify.com)
2. Create a new app to get your **Client ID** and **Client Secret**
3. Add them to `.env` as `SPOTIFY_CLIENT_ID` and `SPOTIFY_CLIENT_SECRET`
4. The app uses **Client Credentials flow** (no user login required)
5. Performer top tracks are fetched using their **Spotify Artist ID** and cached for 1 hour

To link a performer to Spotify, set their `spotify_id` field to the Spotify Artist ID.
> Example: Coldplay's Artist ID is `4gzpq5Yv3Ls2S5NWotHJuN`

---

## 🌐 Ngrok Setup (for Stripe Webhooks)

Stripe requires a **publicly accessible HTTPS URL** for payment callbacks. Use [Ngrok](https://ngrok.com) during local development:

```bash
# After installing Ngrok
ngrok http 8000
```

This generates a URL like: `https://xxxx-xxxx.ngrok-free.app`

Update your `.env`:
```dotenv
APP_URL=https://xxxx-xxxx.ngrok-free.app
```

---

## ⚡ Caching Strategy

| Data | Cache Key | TTL |
|---|---|---|
| Spotify access token | `spotify_access_token` | 55 min |
| Performer top tracks | `spotify_top_tracks_{id}_{country}` | 60 min |
| Event listings (dashboard) | `event_listings` | 60 min |
| Merchandise listings | `merchandise_listings` | 60 min |
| RESTful events API | `api_events_index` | 60 min |

Cache can be cleared with:
```bash
php artisan cache:clear
```

---

## 📁 Key Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── EventController.php        # Dashboard, event CRUD, RESTful API
│   │   ├── CheckoutController.php     # Stripe checkout, ticket & merch buying
│   │   ├── MerchandiseController.php  # Merchandise API
│   │   └── DiscountCodeController.php # Coupon validation
│   └── Resources/
│       └── EventResource.php          # API response format for events
├── Models/
│   ├── Event.php       # belongsTo Category, belongsToMany Performers
│   ├── Performer.php   # belongsTo Category, belongsToMany Events
│   ├── Category.php    # hasMany Events + Performers
│   ├── Merchandise.php # Products available for purchase
│   └── Order.php       # Tracks all ticket + merchandise purchases
└── Services/
    └── SpotifyService.php   # Spotify API with caching

resources/
├── views/
│   ├── dashboard.blade.php          # Main event + merchandise listing page
│   ├── components/
│   │   ├── event-card.blade.php     # Event card with countdown timer
│   │   ├── featured-performers.blade.php
│   │   ├── countdown-timer.blade.php
│   │   └── modals.blade.php         # Booking & performer modals
│   └── layouts/app.blade.php        # Main layout with navbar & toast

database/
└── seeders/
    └── CategoryAndMerchandiseSeeder.php
```

---

## 👤 Author

**Vipul Tikhe**
- GitHub: [@vipultikhe234](https://github.com/vipultikhe234)

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
