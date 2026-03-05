@extends('layouts.app')

@section('title', 'Event Dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h1 class="display-5 fw-bold text-white mb-1">Explore Events</h1>
            <p class="text-white-50">Discovery your next favorite music experience.</p>
        </div>
        <div class="col-md-6 text-end">
            <form action="{{ route('dashboard') }}" method="GET" class="search-form d-inline-block">
                <div class="input-group search-group">
                    <span class="input-group-text bg-dark border-secondary border-end-0 text-white-50"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control bg-dark border-secondary border-start-0 text-white" placeholder="Search events or artists..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary border-secondary"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($search)
        <h4 class="text-white-50 mb-4">Showing results for "<span class="text-white fw-bold">{{ $search }}</span>"</h4>
    @endif

    <div class="section-divider mb-4">
        <h2 class="h3 fw-bold text-white"><i class="fas fa-ticket-alt text-primary me-2"></i>Upcoming Events</h2>
    </div>

    <!-- Loading State for Events -->
    <div id="events-loading" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading events...</span>
        </div>
        <p class="mt-2">Loading events...</p>
    </div>

    <!-- Event Cards Section -->
    <div class="mt-2">
        <div class="row" id="event-cards-container">
            @forelse ($events as $event)
                <div class="col-md-4 mb-4">
                    <x-event-card :event="$event" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info bg-dark border-info text-white-50 text-center py-5">
                        <i class="fas fa-calendar-times opacity-25 display-1 mb-3"></i>
                        <h5>No events found matching your search.</h5>
                        <p>Try different keywords or browse all events.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">Browse All</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="section-divider mb-4 mt-5">
        <h2 class="h3 fw-bold text-white"><i class="fas fa-shopping-bag text-warning me-2"></i>Official Merchandise</h2>
    </div>
    <div class="mt-2">
        <div class="row" id="merchandise-cards-container">
            @forelse ($merchandises as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm bg-dark border-secondary merchandise-card overflow-hidden">
                        @if($item->image)
                            <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}" style="height: 180px; object-fit: cover;">
                        @else
                             <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="fas fa-shopping-bag fa-3x text-white-50"></i>
                             </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">{{ $item->name }}</h5>
                            <p class="card-text text-white-50 small">{{ Str::limit($item->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="h5 mb-0 d-block text-white">₹{{ number_format($item->price, 2) }}</span>
                                    <small class="text-{{ $item->stock > 0 ? 'success' : 'danger' }} small">
                                        {{ $item->stock > 0 ? $item->stock . ' in stock' : 'Out of stock' }}
                                    </small>
                                </div>
                                <button class="btn btn-{{ $item->stock > 0 ? 'primary' : 'secondary disabled' }} btn-sm buy-merch px-3 rounded-pill" 
                                        data-id="{{ $item->id }}" 
                                        data-name="{{ $item->name }}"
                                        data-price="{{ $item->price }}"
                                        {{ $item->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $item->stock > 0 ? 'Buy Now' : 'Sold Out' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                     <div class="text-center py-5 text-white-50">
                        <i class="fas fa-box-open opacity-25 display-3 mb-3"></i>
                        <h5>No merchandise found matching your search.</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @include('components.modals')
</div>

<!-- Payment Result Container -->
<div id="payment-result" aria-live="polite" aria-atomic="true"></div>
@endsection

@section('scripts')
<script>
    // Global state management
    const EventManager = {
        currentEvent: null,
        currentPrice: 0,
        currentDiscount: 0,
        isCouponVerified: false,

        init() {
            this.bindEvents();
            this.checkPaymentStatus();
        },

        bindEvents() {
            // Delegated event listeners for better performance
            document.addEventListener('click', (e) => {
                if (e.target.closest('.view-performers')) {
                    this.handleViewPerformers(e.target.closest('.view-performers'));
                }
                if (e.target.closest('.book-ticket')) {
                    this.handleBookTicket(e.target.closest('.book-ticket'));
                }
                if (e.target.closest('.buy-merch')) {
                    this.handleBuyMerch(e.target.closest('.buy-merch'));
                }
                if (e.target.closest('#verifyCoupon')) {
                    this.handleVerifyCoupon();
                }
            });

            // Form submissions
            document.getElementById('ticketForm')?.addEventListener('submit', (e) => this.handleTicketSubmit(e));
            document.getElementById('tickets')?.addEventListener('input', (e) => this.handleTicketQuantityChange(e));
        },

        async handleViewPerformers(button) {
            const eventId = button.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('performersModal'));
            const loadingEl = document.getElementById('performer-loading');
            const contentEl = document.getElementById('performer-content');

            try {
                loadingEl.classList.remove('d-none');
                contentEl.classList.add('d-none');

                const response = await fetch(`/events/${eventId}/performers`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                this.renderPerformerContent(data, contentEl);

            } catch (error) {
                console.error('Error fetching performer:', error);
                contentEl.innerHTML = this.getErrorMessage('Failed to load performer details.');
            } finally {
                loadingEl.classList.add('d-none');
                contentEl.classList.remove('d-none');
                modal.show();
            }
        },

        renderPerformerContent(data, container) {
            if (data.status === 1 && data.performer) {
                const p = data.performer;
                container.innerHTML = `
                    <div class="text-center mb-3">
                        ${p.image ?
                            `<img src="/${p.image}" class="img-fluid rounded mb-2" loading="lazy" style="max-height:200px; object-fit: cover;">` :
                            `<div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2" style="height: 200px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>`
                        }
                        <h5 class="text-primary">${p.name}</h5>
                        ${p.genre ? `<span class="badge bg-info">${p.genre}</span>` : ''}
                        ${p.bio ? `<p class="mt-3">${p.bio}</p>` : ''}
                    </div>
                    ${this.renderPerformerTracks(data.performer_tracks)}
                `;
            } else {
                container.innerHTML = this.getWarningMessage('No performers found for this event.');
            }
        },

        renderPerformerTracks(tracks) {
            if (!tracks || tracks.length === 0) {
                return '<p class="text-muted">No tracks available</p>';
            }

            return `
                <h6>Top Tracks:</h6>
                <div class="list-group">
                    ${tracks.slice(0, 5).map(track => `
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>${track.name}</span>
                                ${track.preview_url ?
                                    `<audio controls class="audio-player" style="height: 30px;">
                                        <source src="${track.preview_url}" type="audio/mpeg">
                                    </audio>` :
                                    '<small class="text-muted">No preview</small>'
                                }
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        },

        handleBookTicket(button) {
            this.currentEvent = button.dataset.id;
            this.currentMerch = null;
            this.currentPrice = parseFloat(button.dataset.price);
            this.currentDiscount = 0;
            this.isCouponVerified = false;

            // Reset form
            document.getElementById('event_id').value = this.currentEvent;
            document.getElementById('merchandise_id').value = '';
            document.getElementById('tickets').value = 1;
            document.getElementById('coupon_code').value = '';
            document.getElementById('coupon-status').innerHTML = '';
            document.getElementById('price-summary').classList.add('d-none');
            document.getElementById('submitTicket').disabled = false;
            
            document.getElementById('purchaseModalTitle').textContent = 'Book Ticket';
            document.getElementById('quantityLabel').textContent = 'Number of Tickets';

            this.updatePriceSummary();
            new bootstrap.Modal(document.getElementById('bookTicketModal')).show();
        },

        handleBuyMerch(button) {
            this.currentEvent = null;
            this.currentMerch = button.dataset.id;
            this.currentPrice = parseFloat(button.dataset.price);
            this.currentDiscount = 0;
            this.isCouponVerified = false;

            // Reset form
            document.getElementById('event_id').value = '';
            document.getElementById('merchandise_id').value = this.currentMerch;
            document.getElementById('tickets').value = 1;
            document.getElementById('coupon_code').value = '';
            document.getElementById('coupon-status').innerHTML = '';
            document.getElementById('price-summary').classList.add('d-none');
            document.getElementById('submitTicket').disabled = false;

            document.getElementById('purchaseModalTitle').textContent = 'Buy Merchandise: ' + button.dataset.name;
            document.getElementById('quantityLabel').textContent = 'Quantity';

            this.updatePriceSummary();
            new bootstrap.Modal(document.getElementById('bookTicketModal')).show();
        },

        handleTicketQuantityChange(event) {
            let value = event.target.value.replace(/[-eE]/g, '');
            value = Math.max(1, value);
            event.target.value = value;

            this.updatePriceSummary();

            // Reset coupon verification if quantity changes
            if (this.isCouponVerified) {
                document.getElementById('coupon-status').innerHTML =
                    '<small class="text-warning">Coupon needs re-verification due to quantity change</small>';
                this.isCouponVerified = false;
                document.getElementById('submitTicket').disabled = true;
            }
        },

        async handleVerifyCoupon() {
            const coupon = document.getElementById('coupon_code').value.trim();
            const tickets = parseInt(document.getElementById('tickets').value);
            const verifyBtn = document.getElementById('verifyCoupon');

            if (!coupon) {
                this.showCouponStatus('Please enter a coupon code', 'error');
                return;
            }

            try {
                verifyBtn.disabled = true;
                verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Verifying...';

                const response = await fetch('/check-coupon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: {{ $user->id }},
                        coupon_code: coupon,
                        ticket_amount: this.currentPrice * tickets,
                        event_id: this.currentEvent
                    })
                });

                const data = await response.json();

                if (data.status === 1) {
                    this.currentDiscount = data.discount || 0;
                    this.isCouponVerified = true;
                    this.showCouponStatus(`Coupon applied! ${data.discount}`, 'success');
                    document.getElementById('submitTicket').disabled = false;
                } else {
                    this.currentDiscount = 0;
                    this.isCouponVerified = false;
                    this.showCouponStatus(data.message || 'Invalid coupon code', 'error');
                    document.getElementById('submitTicket').disabled = true;
                }
            } catch (error) {
                console.error('Error verifying coupon:', error);
                this.showCouponStatus('Failed to verify coupon. Please try again.', 'error');
                this.currentDiscount = 0;
                this.isCouponVerified = false;
                document.getElementById('submitTicket').disabled = true;
            } finally {
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = 'Verify';
                this.updatePriceSummary();
            }
        },

        async handleTicketSubmit(event) {
            event.preventDefault();

            const submitBtn = document.getElementById('submitTicket');
            const submitText = document.getElementById('submit-text');
            const submitLoading = document.getElementById('submit-loading');

            try {
                submitBtn.disabled = true;
                submitText.textContent = 'Processing...';
                submitLoading.classList.remove('d-none');

                const formData = {
                    event_id: this.currentEvent,
                    merchandise_id: this.currentMerch,
                    quantity: document.getElementById('tickets').value,
                    coupon_code: document.getElementById('coupon_code').value,
                    user_id: {{ $user->id }}
                };

                const response = await fetch('/api/book-event', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.checkout_url) {
                    window.location.href = data.checkout_url;
                } else {
                    throw new Error(data.message || 'Unknown response from server');
                }
            } catch (error) {
                console.error('Payment error:', error);
                this.showToast('Payment Failed', error.message, 'error');

                // Reset button
                submitBtn.disabled = false;
                submitText.textContent = 'Proceed to Payment';
                submitLoading.classList.add('d-none');
            }
        },

        updatePriceSummary() {
            const tickets = parseInt(document.getElementById('tickets').value) || 1;
            const basePrice = this.currentPrice * tickets;
            const totalPrice = basePrice - this.currentDiscount;

            document.getElementById('base-price').textContent = `₹${basePrice.toFixed(2)}`;
            document.getElementById('discount-amount').textContent = `-₹${this.currentDiscount.toFixed(2)}`;
            document.getElementById('total-price').textContent = `₹${totalPrice.toFixed(2)}`;

            // Show summary if we have any price data
            if (this.currentPrice > 0) {
                document.getElementById('price-summary').classList.remove('d-none');
            }
        },

        showCouponStatus(message, type) {
            const statusEl = document.getElementById('coupon-status');
            statusEl.innerHTML = message;
            statusEl.className = `mt-2 ${type === 'success' ? 'text-success' : 'text-danger'}`;
        },

        checkPaymentStatus() {
            const urlParams = new URLSearchParams(window.location.search);
            const paymentStatus = urlParams.get('payment');
            const sessionId = urlParams.get('session_id');

            if (paymentStatus === 'success' && sessionId) {
                this.showPaymentSuccess(sessionId);
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (paymentStatus === 'cancelled') {
                this.showToast('Payment Cancelled', 'You can try booking again whenever you\'re ready.', 'warning');
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        },

        async showPaymentSuccess(sessionId) {
            this.showToast('Processing...', 'Verifying your payment', 'info');

            try {
                const response = await fetch(`/api/booking/success?session_id=${sessionId}`);
                const data = await response.json();

                if (data.status === 1) {
                    this.showToast('Payment Successful!', '🎉 Your tickets have been booked successfully!', 'success');
                } else {
                    this.showToast('Payment Verification Failed', data.message, 'error');
                }
            } catch (error) {
                this.showToast('Error', 'Failed to verify payment. Please contact support.', 'error');
            }
        },

        showToast(title, message, type = 'info') {
            // Use the global toast function from layout
            if (typeof window.showToast === 'function') {
                window.showToast(title, message, type);
            }
        },

        getErrorMessage(message) {
            return `<div class="alert alert-danger text-center">${message}</div>`;
        },

        getWarningMessage(message) {
            return `<div class="alert alert-warning text-center">${message}</div>`;
        }
    };

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
        EventManager.init();

        // Initialize countdown timers
        this.initializeCountdownTimers();

        // Show session toasts
        this.showSessionToasts();
    });

    function initializeCountdownTimers() {
        document.querySelectorAll(".countdown-timer").forEach((timer) => {
            const eventDate = new Date(timer.dataset.eventDate).getTime();
            const daysEl = timer.querySelector(".days");
            const hoursEl = timer.querySelector(".hours");
            const minutesEl = timer.querySelector(".minutes");
            const secondsEl = timer.querySelector(".seconds");

            function updateCountdown() {
                const now = Date.now();
                const distance = eventDate - now;

                if (distance <= 0) {
                    timer.innerHTML = "<h6 class='text-center text-success'>Event Started</h6>";
                    return;
                }

                const days = Math.floor(distance / (86400000));
                const hours = Math.floor((distance % 86400000) / 3600000);
                const minutes = Math.floor((distance % 3600000) / 60000);
                const seconds = Math.floor((distance % 60000) / 1000);

                daysEl.textContent = `${days} Days`;
                hoursEl.textContent = `${hours} Hrs`;
                minutesEl.textContent = `${minutes} Min`;
                secondsEl.textContent = `${seconds} Sec`;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    }

    function showSessionToasts() {
        @if(Session::has('success'))
            EventManager.showToast('Success', '{{ Session::get('success') }}', 'success');
        @endif
    }
</script>
@endsection
