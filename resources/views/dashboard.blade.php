@extends('layouts.app')

@section('title', 'Event Dashboard')

@section('content')

{{-- Override body/page background to light --}}
<style>
    body { background: #f9fafb !important; }
    .container { max-width: 1200px; }

    /* Merch card */
    .merch-card { transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb !important; }
    .merch-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
    .merch-card .card-body { background: #fff; }

    /* Search input */
    .search-input { border-radius: 8px; border: 1px solid #d1d5db; padding: 0.6rem 1rem; font-size: 0.9rem; }
    .search-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); outline: none; }
    .search-btn { border-radius: 8px; }
</style>

<div class="py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 gap-3">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:#111827;">Explore Events</h1>
            <p class="mb-0" style="color:#6b7280;">Discover your next live experience.</p>
        </div>
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="input-group" style="min-width: 280px;">
                <span class="input-group-text bg-white border-end-0" style="border: 1px solid #d1d5db; border-right: none; border-radius: 8px 0 0 8px;">
                    <i class="fas fa-search" style="color:#9ca3af;"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 shadow-none search-input" style="border-radius: 0 8px 8px 0; border-left: none;" placeholder="Search events or artists..." value="{{ $search ?? '' }}">
                @if(!empty($search))
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-1 search-btn"><i class="fas fa-times"></i></a>
                @endif
            </div>
        </form>
    </div>

    @if(!empty($search))
        <p class="mb-4" style="color:#6b7280;">Results for <strong style="color:#111827;">"{{ $search }}"</strong></p>
    @endif

    {{-- Events Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h6 fw-bold mb-0 text-uppercase" style="color: #6b7280; letter-spacing: 0.07em;">
            Upcoming Events
        </h2>
        <span class="badge rounded-pill px-3" style="background:#eff6ff; color:#2563eb;">{{ $events->count() }} Events</span>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5" id="event-cards-container">
        @forelse ($events as $event)
            <div class="col">
                <x-event-card :event="$event" />
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 rounded-3" style="background:#fff; border: 1px solid #e5e7eb;">
                    <i class="fas fa-calendar-times fa-3x mb-3 d-block" style="color:#d1d5db;"></i>
                    <h5 style="color:#374151;">No events found</h5>
                    <p style="color:#9ca3af;">Try different keywords or browse all events.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm rounded-pill px-4">Browse All</a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Merchandise Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="h6 fw-bold mb-0 text-uppercase" style="color: #6b7280; letter-spacing: 0.07em;">
            Official Merchandise
        </h2>
        <span class="badge rounded-pill px-3" style="background:#fef9c3; color:#92400e;">{{ $merchandises->count() }} Items</span>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4 mb-5" id="merchandise-cards-container">
        @forelse ($merchandises as $item)
            <div class="col">
                <div class="card merch-card shadow-sm h-100 bg-white">
                    @if($item->stock <= 0)
                        <div class="position-absolute top-0 end-0 mt-2 me-2" style="z-index:1;">
                            <span class="badge bg-danger rounded-pill px-3">Sold Out</span>
                        </div>
                    @elseif($item->stock <= 10)
                        <div class="position-absolute top-0 end-0 mt-2 me-2" style="z-index:1;">
                            <span class="badge rounded-pill px-3" style="background:#fef3c7; color:#b45309;">{{ $item->stock }} left</span>
                        </div>
                    @endif

                    @if($item->image)
                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center" style="height: 200px; background: #f3f4f6;">
                            <i class="fas fa-tshirt fa-2x" style="color:#d1d5db;"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="fw-bold mb-1" style="color:#111827;">{{ $item->name }}</h6>
                        <p class="flex-grow-1 mb-3" style="color:#9ca3af; font-size:0.8rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $item->description }}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #f3f4f6;">
                            <div>
                                <span class="fw-bold" style="color:#111827;">₹{{ number_format($item->price, 0) }}</span><br>
                                <small style="color: {{ $item->stock > 0 ? '#16a34a' : '#dc2626' }}; font-size:0.75rem;">{{ $item->stock > 0 ? $item->stock . ' in stock' : 'Out of stock' }}</small>
                            </div>
                            <button class="btn btn-sm buy-merch"
                                    style="background: {{ $item->stock > 0 ? '#2563eb' : '#e5e7eb' }}; color: {{ $item->stock > 0 ? '#fff' : '#9ca3af' }}; border:none; border-radius:8px; font-size:0.82rem; padding:0.4rem 1rem;"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}"
                                    data-price="{{ $item->price }}"
                                    {{ $item->stock <= 0 ? 'disabled' : '' }}>
                                {{ $item->stock > 0 ? 'Buy' : 'Sold Out' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 rounded-3" style="background:#fff; border: 1px solid #e5e7eb;">
                    <i class="fas fa-box-open fa-3x mb-3 d-block" style="color:#d1d5db;"></i>
                    <h5 style="color:#374151;">No merchandise available</h5>
                </div>
            </div>
        @endforelse
    </div>

    @include('components.modals')
</div>

<div id="payment-result" aria-live="polite" aria-atomic="true"></div>
@endsection

@section('scripts')
<script>
    const EventManager = {
        currentEvent: null,
        currentMerch: null,
        currentPrice: 0,
        currentDiscount: 0,
        isCouponVerified: false,

        init() {
            this.bindEvents();
        },

        bindEvents() {
            document.addEventListener('click', (e) => {
                if (e.target.closest('.view-performers')) this.handleViewPerformers(e.target.closest('.view-performers'));
                if (e.target.closest('.book-ticket')) this.handleBookTicket(e.target.closest('.book-ticket'));
                if (e.target.closest('.buy-merch')) this.handleBuyMerch(e.target.closest('.buy-merch'));
                if (e.target.closest('#verifyCoupon')) this.handleVerifyCoupon();
            });
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
                if (!response.ok) throw new Error('Network error');
                const data = await response.json();
                this.renderPerformerContent(data, contentEl);
            } catch (error) {
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
                        ${p.image ? `<img src="/${p.image}" class="img-fluid rounded mb-2" style="max-height:200px; object-fit:cover;">` :
                            `<div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2 mx-auto" style="height:150px; width:150px;">
                                <i class="fas fa-user fa-3x text-white"></i></div>`}
                        <h5 class="text-primary">${p.name}</h5>
                        ${p.genre ? `<span class="badge bg-info">${p.genre}</span>` : ''}
                        ${p.bio ? `<p class="mt-3 text-white-50 small">${p.bio}</p>` : ''}
                    </div>
                    ${this.renderPerformerTracks(data.performer_tracks)}
                `;
            } else {
                container.innerHTML = this.getWarningMessage('No performers found for this event.');
            }
        },

        renderPerformerTracks(tracks) {
            if (!tracks || tracks.length === 0) return '<p class="text-muted text-center">No tracks available</p>';
            return `<h6 class="text-white-50 mb-3">Top Tracks:</h6>
                <div class="list-group">
                    ${tracks.slice(0, 5).map(track => `
                        <div class="list-group-item bg-dark border-secondary text-white">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <span>${track.name}</span>
                                ${track.preview_url ? `<audio controls style="height:30px; max-width:200px;"><source src="${track.preview_url}" type="audio/mpeg"></audio>` : '<small class="text-muted">No preview</small>'}
                            </div>
                        </div>`).join('')}
                </div>`;
        },

        handleBookTicket(button) {
            this.currentEvent = button.dataset.id;
            this.currentMerch = null;
            this.currentPrice = parseFloat(button.dataset.price);
            this.currentDiscount = 0;
            this.isCouponVerified = false;
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
            document.getElementById('event_id').value = '';
            document.getElementById('merchandise_id').value = this.currentMerch;
            document.getElementById('tickets').value = 1;
            document.getElementById('coupon_code').value = '';
            document.getElementById('coupon-status').innerHTML = '';
            document.getElementById('price-summary').classList.add('d-none');
            document.getElementById('submitTicket').disabled = false;
            document.getElementById('purchaseModalTitle').textContent = 'Buy: ' + button.dataset.name;
            document.getElementById('quantityLabel').textContent = 'Quantity';
            this.updatePriceSummary();
            new bootstrap.Modal(document.getElementById('bookTicketModal')).show();
        },

        handleTicketQuantityChange(event) {
            let value = Math.max(1, parseInt(event.target.value) || 1);
            event.target.value = value;
            this.updatePriceSummary();
            if (this.isCouponVerified) {
                document.getElementById('coupon-status').innerHTML = '<small class="text-warning">Re-verify coupon after changing quantity.</small>';
                this.isCouponVerified = false;
                document.getElementById('submitTicket').disabled = true;
            }
        },

        async handleVerifyCoupon() {
            const coupon = document.getElementById('coupon_code').value.trim();
            const tickets = parseInt(document.getElementById('tickets').value);
            const verifyBtn = document.getElementById('verifyCoupon');
            if (!coupon) { this.showCouponStatus('Please enter a coupon code', 'error'); return; }
            try {
                verifyBtn.disabled = true;
                verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                const response = await fetch('/check-coupon', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ user_id: {{ $user->id }}, coupon_code: coupon, ticket_amount: this.currentPrice * tickets, event_id: this.currentEvent })
                });
                const data = await response.json();
                if (data.status === 1) {
                    this.currentDiscount = data.discount || 0;
                    this.isCouponVerified = true;
                    this.showCouponStatus(`✓ Saved ₹${data.discount}`, 'success');
                    document.getElementById('submitTicket').disabled = false;
                } else {
                    this.currentDiscount = 0;
                    this.isCouponVerified = false;
                    this.showCouponStatus(data.message || 'Invalid code', 'error');
                    document.getElementById('submitTicket').disabled = true;
                }
            } catch (e) {
                this.showCouponStatus('Verification failed.', 'error');
                document.getElementById('submitTicket').disabled = true;
            } finally {
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = 'APPLY';
                this.updatePriceSummary();
            }
        },

        async handleTicketSubmit(event) {
            event.preventDefault();
            const submitBtn = document.getElementById('submitTicket');
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                const formData = {
                    event_id: this.currentEvent, merchandise_id: this.currentMerch,
                    quantity: document.getElementById('tickets').value,
                    coupon_code: document.getElementById('coupon_code').value,
                    user_id: {{ $user->id }}
                };
                const response = await fetch('/api/book-event', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(formData)
                });
                const data = await response.json();
                if (data.checkout_url) { window.location.href = data.checkout_url; }
                else throw new Error(data.message || 'Unknown error');
            } catch (error) {
                this.showToast('Error', error.message, 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Pay Securely';
            }
        },

        updatePriceSummary() {
            const tickets = parseInt(document.getElementById('tickets').value) || 1;
            const basePrice = this.currentPrice * tickets;
            const totalPrice = basePrice - this.currentDiscount;
            document.getElementById('base-price').textContent = `₹${basePrice.toFixed(2)}`;
            document.getElementById('discount-amount').textContent = `-₹${this.currentDiscount.toFixed(2)}`;
            document.getElementById('total-price').textContent = `₹${totalPrice.toFixed(2)}`;
            if (this.currentPrice > 0) document.getElementById('price-summary').classList.remove('d-none');
        },

        showCouponStatus(msg, type) {
            document.getElementById('coupon-status').innerHTML = `<small class="text-${type === 'success' ? 'success' : 'danger'}">${msg}</small>`;
        },

        showToast(title, message, type = 'info') {
            if (typeof window.showToast === 'function') window.showToast(title, message, type);
        },

        getErrorMessage(msg) { return `<div class="alert alert-danger text-center">${msg}</div>`; },
        getWarningMessage(msg) { return `<div class="alert alert-warning text-center">${msg}</div>`; }
    };

    document.addEventListener('DOMContentLoaded', () => EventManager.init());
</script>
@endsection
