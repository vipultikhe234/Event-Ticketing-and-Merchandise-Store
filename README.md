1. Clone the Repository – Clone the project to local machine and navigate to the project folder.

2. Install Dependencies – Install all required PHP and JavaScript packages to ensure the application runs smoothly.
   composer install
   composer require stripe/stripe-php
   npm install
   npm run dev
   php artisan key:generate
   php artisan migrate
   php artisan db:seed --class=SeederClassName
   php artisan queue:work
   php artisan serve
   composer require jwilsson/spotify-web-api-php

3. Configure Environment – Update the .env file with database connection, Stripe API keys, queue connection, and mail settings.

4. Run Migrations – Create the necessary database tables:
   performers → Stores artists.
   events → Stores event details linked to performers.
   discount_codes → Stores discount/coupon codes.
   orders → Tracks ticket purchases and payments.

5. Seed the Database – Insert sample data for performers, events, and discount codes to facilitate testing.

6. Start the Queue Worker – Start the queue to process background jobs such as sending ticket confirmation emails.

7. Run the Application – Launch the local development server and access the application in browser.

8. Dependencies Required – PHP, Composer, Node.js, npm, Laravel framework, Stripe PHP SDK, and a MySQL database.

9. Project Approach – The project is an event ticketing system that allows users to browse events, apply discount codes, purchase tickets via Stripe Checkout, and receive confirmation emails through queued jobs. The database links performers to events, tracks orders, and manages discount codes, following Laravel best practices and clean code structure.

10. Required PHP Extensions for Laravel + Stripe
    In php.ini (usually in php\php.ini or XAMPP):
    extension=curl → For HTTP requests (Stripe API)
    extension=openssl → For secure connections
    extension=mbstring → String handling
    extension=pdo_mysql → MySQL connection
    extension=bcmath → Laravel calculations (optional but recommended)
    extension=fileinfo → Required for file uploads

11. Payment Gateway (Stripe) Setup

    1. Create a Stripe Account – Sign up at https://stripe.com
       to get access to API keys.
    2. Obtain API Keys – Publishable Key → For frontend (Stripe.js) -> Secret Key → For backend (server-side requests)
    3. Update .env File – Add your Stripe keys: -> STRIPE_KEY=your_stripe_publishable_key -> STRIPE_SECRET=your_stripe_secret_key
    4. Stripe PHP SDK – Make sure the package is installed: -> composer require stripe/stripe-php
    5. Checkout Integration – The backend uses Stripe Checkout to create payment sessions. Users are redirected to Stripe’s secure payment page.
    6. Handling Payment Success/Failure – After payment:
    7. Stripe returns session_id to your success URL.
    8. The application verifies the payment and updates the order status.
    9. Emails (tickets) are sent via queued jobs.

12. Ngrok implementation -> Ngrok is a tool that exposes local development server to the internet via a secure public URL.
    Laravel application runs locally (e.g., http://127.0.0.1:8000).
    services like Stripe payment require a publicly accessible URL.
    Ngrok generates a temporary HTTPS URL (like https://concessive-ventilable-angelica.ngrok-free.dev) that can be used as a callback URL

    1. Install Ngrok -> Download from https://ngrok.com/ and install it.
    2. Expose Local Server -> If Laravel server is running on port 8000: ngrok http 8000 ->This will generate a public HTTPS URL. -> Example: https://concessive-ventilable-angelica.ngrok-free.dev
    3. Update .env ->Set APP_URL to your Ngrok URL: -> APP_URL=https://concessive-ventilable-angelica.ngrok-free.dev

13. Spotify Integration (Performers Table)
    1. Purpose -> The goal of integrating Spotify is to associate performers with their Spotify content so that users can preview their music, see albums, or listen to tracks before buying tickets. This improves user engagement and creates a richer event experience.
    2. Spotify Developer Account -> Sign up at Spotify for Developers -> Create a new application to get: -> Client ID -> Client Secret
    3. Install Spotify API Package -> composer require jwilsson/spotify-web-api-php
    4. Configuration -> SPOTIFY_CLIENT_ID=your_client_id -> SPOTIFY_CLIENT_SECRET=your_client_secret
"# Event-Ticketing-and-Merchandise-Store" 
