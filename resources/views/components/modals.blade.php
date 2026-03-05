<!-- Performer Modal -->
<div class="modal fade" id="performersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Performer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="performer-loading" class="text-center d-none">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading performer...</span>
                    </div>
                    <p>Loading performer details...</p>
                </div>
                <div id="performer-content" class="d-none"></div>
            </div>
        </div>
    </div>
</div>

<!-- Book Ticket Modal -->
<div class="modal fade" id="bookTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="ticketForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseModalTitle">Book Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="event_id" name="event_id">
                    <input type="hidden" id="merchandise_id" name="merchandise_id">

                    <div class="mb-3">
                        <label for="tickets" class="form-label" id="quantityLabel">Number of Tickets</label>
                        <input type="number" id="tickets" name="tickets" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="coupon_code" class="form-label">Coupon Code (Optional)</label>
                        <div class="input-group">
                            <input type="text" id="coupon_code" name="coupon_code" class="form-control" placeholder="Enter coupon code">
                            <button type="button" class="btn btn-outline-secondary" id="verifyCoupon">Verify</button>
                        </div>
                        <div id="coupon-status" class="mt-2"></div>
                    </div>

                    <div id="price-summary" class="mb-3 p-3 bg-light rounded d-none">
                        <h6>Price Summary:</h6>
                        <div class="d-flex justify-content-between">
                            <span>Base Price:</span>
                            <span id="base-price">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Discount:</span>
                            <span id="discount-amount">-₹0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span id="total-price">₹0.00</span>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" id="submitTicket" class="btn btn-primary btn-lg">
                            <span id="submit-text">Proceed to Payment</span>
                            <div id="submit-loading" class="spinner-border spinner-border-sm d-none" role="status">
                                <span class="visually-hidden">Processing...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
