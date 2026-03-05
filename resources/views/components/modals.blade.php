<!-- Performer Modal -->
<div class="modal fade" id="performersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg overflow-hidden" style="border-radius: 1rem;">
            <div class="modal-header border-bottom border-secondary bg-dark bg-opacity-75 backdrop-blur">
                <h5 class="modal-title fw-bold text-primary"><i class="fas fa-magic me-2"></i>Performer Spotlight</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="performer-loading" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading performer...</span>
                    </div>
                    <p class="mt-3 text-white-50">Curating artist details...</p>
                </div>
                <div id="performer-content" class="d-none p-4"></div>
            </div>
        </div>
    </div>
</div>

<!-- Book Ticket / Buy Merch Modal -->
<div class="modal fade" id="bookTicketModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form id="ticketForm" class="w-100">
            <div class="modal-content bg-dark border-secondary text-white shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                <div class="modal-header border-bottom border-secondary bg-gradient-dark pt-4 pb-3 px-4">
                    <h5 class="modal-title fw-bold text-white fs-4" id="purchaseModalTitle">Complete Purchase</h5>
                    <button type="button" class="btn-close btn-close-white bg-dark bg-opacity-50 rounded-circle" data-bs-dismiss="modal" aria-label="Close" style="padding: 0.8rem;"></button>
                </div>
                <div class="modal-body p-4 bg-dark">
                    <input type="hidden" id="event_id" name="event_id">
                    <input type="hidden" id="merchandise_id" name="merchandise_id">

                    <div class="mb-4">
                        <label for="tickets" class="form-label text-white-50 fw-semibold text-uppercase small tracking-wide" id="quantityLabel">Quantity Required</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary border-0 text-white-50"><i class="fas fa-hashtag"></i></span>
                            <input type="number" id="tickets" name="tickets" class="form-control bg-dark border-secondary text-white fs-5" min="1" value="1" required style="border-radius: 0 0.5rem 0.5rem 0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="coupon_code" class="form-label text-white-50 fw-semibold text-uppercase small tracking-wide">Promotional Code <span class="text-muted text-lowercase font-monospace">(Optional)</span></label>
                        <div class="input-group p-1 bg-secondary bg-opacity-25 rounded border border-secondary border-opacity-50">
                            <input type="text" id="coupon_code" name="coupon_code" class="form-control bg-transparent border-0 text-white font-monospace text-uppercase" placeholder="Enter code" style="box-shadow: none;">
                            <button type="button" class="btn btn-primary px-4 fw-bold rounded" id="verifyCoupon">APPLY</button>
                        </div>
                        <div id="coupon-status" class="mt-2 small px-1 transition-all"></div>
                    </div>

                    <div id="price-summary" class="mb-4 p-4 rounded d-none" style="background: linear-gradient(145deg, rgba(25, 30, 40, 1) 0%, rgba(15, 20, 25, 1) 100%); border: 1px solid rgba(255,255,255,0.05);">
                        <h6 class="text-white-50 text-uppercase small fw-bold tracking-wide mb-3 border-bottom border-secondary pb-2">Order Summary</h6>
                        
                        <div class="d-flex justify-content-between mb-2 fs-6">
                            <span class="text-white-50">Subtotal</span>
                            <span id="base-price" class="fw-medium text-white">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fs-6">
                            <span class="text-success"><i class="fas fa-tag me-1 small"></i> Discount</span>
                            <span id="discount-amount" class="text-success fw-bold">-₹0.00</span>
                        </div>
                        
                        <hr class="border-secondary opacity-25 my-3">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-white fw-bold fs-5">Total Payment</span>
                            <span id="total-price" class="text-primary fw-bolder display-6">₹0.00</span>
                        </div>
                    </div>

                    <div class="d-grid mt-2">
                        <button type="submit" id="submitTicket" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold text-uppercase tracking-wide position-relative overflow-hidden checkout-btn">
                            <span id="submit-text" class="position-relative z-index-1 d-flex align-items-center justify-content-center">
                                <i class="fas fa-lock me-2"></i> Pay Securely
                            </span>
                            <div id="submit-loading" class="position-absolute top-50 start-50 translate-middle d-none hidden-loader z-index-2">
                                <div class="spinner-border spinner-border-sm text-white" role="status">
                                    <span class="visually-hidden">Processing...</span>
                                </div>
                                <span class="ms-2">Processing...</span>
                            </div>
                        </button>
                        <div class="text-center mt-3">
                            <small class="text-white-50"><i class="fab fa-cc-stripe me-1 text-muted"></i> Payments are processed securely via Stripe.</small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .tracking-wide { letter-spacing: 0.05em; }
    .backdrop-blur { backdrop-filter: blur(10px); }
    .bg-gradient-dark { background: linear-gradient(to right, #1a1a2e, #16213e); }
    .z-index-1 { z-index: 1; }
    .z-index-2 { z-index: 2; }
    
    .checkout-btn { transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3); }
    .checkout-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4); }
    
    /* When loading, hide text and show loader */
    #submitTicket:disabled #submit-text { opacity: 0; }
    #submitTicket:disabled #submit-loading { display: flex !important; }
</style>
