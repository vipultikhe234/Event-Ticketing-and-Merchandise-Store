<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Ticketing')</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Preconnect to CDN -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="d-flex flex-column h-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
                <x-vt-logo :size="40" class="me-2 rounded shadow-sm" />
                <span>Event Ticketing</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-warning fw-bold" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-user-shield me-1"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('my-bookings') }}">
                                <i class="fas fa-history me-1"></i> My Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-light">{{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <div class="container mt-4">
            @yield('content')
        </div>
    </main>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header">
                <i class="fas fa-bell me-2" id="toast-icon"></i>
                <strong class="me-auto" id="toast-title">Notification</strong>
                <small id="toast-time"></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-message"></div>
        </div>
    </div>

    <!-- Load Bootstrap FIRST (synchronously) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Functions and Payment Handler -->
    <script>
        // Global toast function that's always available
        window.showToast = function(title, message, type = 'info') {
            // Check if Bootstrap is loaded
            if (typeof bootstrap === 'undefined') {
                console.warn('Bootstrap not loaded, showing fallback alert');
                alert(`${title}: ${message}`);
                return;
            }

            const toastEl = document.getElementById('liveToast');
            if (!toastEl) {
                console.error('Toast element not found');
                return;
            }

            const iconMap = {
                success: 'fa-check-circle text-success',
                error: 'fa-exclamation-circle text-danger',
                warning: 'fa-exclamation-triangle text-warning',
                info: 'fa-info-circle text-info'
            };

            const headerClass = {
                success: 'bg-success text-white',
                error: 'bg-danger text-white',
                warning: 'bg-warning text-dark',
                info: 'bg-info text-white'
            };

            // Update toast content
            document.getElementById('toast-title').textContent = title;
            document.getElementById('toast-message').textContent = message;
            document.getElementById('toast-time').textContent = new Date().toLocaleTimeString();

            const icon = document.getElementById('toast-icon');
            icon.className = `fas ${iconMap[type] || 'fa-bell'} me-2`;

            const header = toastEl.querySelector('.toast-header');
            header.className = `toast-header ${headerClass[type] || 'bg-info text-white'}`;

            // Show toast
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        };

        // Check for payment status immediately on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const paymentStatus = urlParams.get('payment');
            const sessionId = urlParams.get('session_id');

            if (paymentStatus === 'success' && sessionId) {
                // Show processing message immediately
                window.showToast('Processing...', 'Verifying your payment', 'info');

                // Verify payment with server
                fetch(`/api/booking/success?session_id=${sessionId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 1) {
                            window.showToast('Payment Successful!', '🎉 Your tickets have been booked successfully!', 'success');
                        } else {
                            window.showToast('Payment Verification Failed', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        window.showToast('Error', 'Failed to verify payment. Please contact support.', 'error');
                    });

                window.history.replaceState({}, document.title, window.location.pathname);

            } else if (paymentStatus === 'cancelled') {
                window.showToast('Payment Cancelled', 'You can try booking again whenever you\'re ready.', 'warning');
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            // Show any session messages
            @if(Session::has('success'))
                window.showToast('Success', '{{ Session::get('success') }}', 'success');
            @endif

            @if(Session::has('error'))
                window.showToast('Error', '{{ Session::get('error') }}', 'error');
            @endif
        });

        // Fallback for async loaded Bootstrap (if needed)
        function ensureBootstrap(callback) {
            if (typeof bootstrap !== 'undefined') {
                callback();
            } else {
                // Wait for Bootstrap to load
                const checkBootstrap = setInterval(() => {
                    if (typeof bootstrap !== 'undefined') {
                        clearInterval(checkBootstrap);
                        callback();
                    }
                }, 100);
            }
        }
    </script>

    <!-- Page-specific scripts -->
    @yield('scripts')

    <!-- Defer app.js loading -->
    <script defer src="{{ mix('js/app.js') }}"></script>

</body>

</html>
