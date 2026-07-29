@extends('layouts.portal')



@section('portal_content')
    <div class="section-header as-digital-1">
        <div class="header-title-container">
            <h1 class="header-title">Digital Orders</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="as-digital-2">
        <div class="portal-card as-digital-3">
            <div class="as-digital-4">Total Orders</div>
            <div class="as-digital-5" id="stat-total">-</div>
        </div>
        <div class="portal-card as-digital-6">
            <div class="as-digital-4">Paid</div>
            <div class="as-digital-5" id="stat-paid">-</div>
        </div>
        <!-- <div class="portal-card as-digital-7">
            <div class="as-digital-4">Refunded</div>
            <div class="as-digital-5" id="stat-refunded">-</div>
        </div> -->
        <div class="portal-card as-digital-8">
            <div class="as-digital-4">Sent</div>
            <div class="as-digital-5" id="stat-sent">-</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card as-digital-9">
        <div class="card-header-custom as-digital-10">
            <div class="as-digital-11">
                <h2 class="card-title-custom as-digital-12">Digital Add-on Orders</h2>
                <div class="as-digital-13">
                    <i class="bi bi-search as-digital-14"></i>
                    <input type="text" class="form-input-style as-digital-15" id="search-digital" placeholder="Search customer or item...">
                </div>
            </div>
            
            <!-- Filters Row -->
            <div class="as-digital-16">
                <div class="as-digital-17">
                    <span class="as-digital-18">Item Name</span>
                    <select class="form-input-style as-digital-19" id="filter-item">
                        <option value="all">All Items</option>
                        <option value="deck">Post-Election Deck Only</option>
                        <option value="presentation">Post-Election Presentation</option>
                    </select>
                </div>
                <!-- <div class="as-digital-17">
                    <span class="as-digital-18">Payment Status</span>
                    <select class="form-input-style as-digital-20" id="filter-payment">
                        <option value="all">All Statuses</option>
                        <option value="paid">Paid</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div> -->
                <!-- Clear Filters Button -->
                <div class="as-digital-21">
                    <button class="as-digital-22" id="btn-clear-filters" onmouseenter="this.style.backgroundColor='#e2e8f0'" onmouseleave="this.style.backgroundColor='#f1f5f9'">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table as-digital-23" id="digital-orders-table">
                <thead>
                    <tr>
                        <th class="as-digital-24">Customer / Email</th>
                        <th class="as-digital-25">Company</th>
                        <th class="as-digital-26">Item</th>
                        <th class="as-digital-27">Order Date</th>
                        <th class="as-digital-28">Payment</th>
                        <th class="as-digital-28">Delivery</th>
                        <th class="as-digital-29 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS loaded data will be injected here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Footer -->
        <div class="as-digital-30">
            <div class="as-digital-31" id="pagination-info">
                Showing 0 to 0 of 0 entries
            </div>
            <div class="as-digital-32" id="pagination-buttons">
                <!-- Pagination buttons will be dynamically injected -->
            </div>
        </div>
    </div>

    <!-- Refund Confirmation Modal -->
    <div id="refundConfirmModal" class="ctb-modal">
        <div class="ctb-modal-box">
            <div class="ctb-modal-body">
                <h3 class="ctb-modal-title">Confirm Refund</h3>
                <p class="as-digital-33">
                    Are you sure you want to refund this order? This action will process a partial refund of <strong id="refund-amount-text">$0.00</strong> on Stripe.
                </p>
                <p class="as-digital-34">
                    Warning: This action cannot be undone.
                </p>
                <input type="hidden" id="refund-order-id">
                
                <div class="ctb-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeRefundModal()">Cancel</button>
                    <button type="button" class="btn-modal-submit" id="btn-confirm-refund-submit" onclick="submitRefund()">Confirm Refund</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="custom-toast" class="portal-toast as-digital-35">
        <h4 class="portal-toast-title" id="toast-title"></h4>
        <p class="portal-toast-body" id="toast-body"></p>
    </div>
@endsection

@section('portal_scripts')
    <script>
        $(document).ready(function () {
            const apiToken = "{{ Auth::user()->api_token }}";
            const $searchInput = $('#search-digital');
            const $itemFilter = $('#filter-item');
            const $paymentFilter = $('#filter-payment');
            const $clearFiltersBtn = $('#btn-clear-filters');
            const $tbody = $('#digital-orders-table tbody');
            const $paginationInfo = $('#pagination-info');
            const $paginationButtons = $('#pagination-buttons');

            let allOrders = [];
            let currentPage = 1;
            const pageSize = 5;

            function showToast(title, body, isError = false) {
                $('#toast-title').text(title).css('color', isError ? '#ef4444' : '#10b981');
                $('#toast-body').text(body);
                $('#custom-toast').stop(true, true).fadeIn(300).delay(4000).fadeOut(300);
            }

            function formatDate(dateStr) {
                if (!dateStr) return '-';
                const dateObj = new Date(dateStr);
                if (typeof dateStr === 'string' && dateStr.length === 10 && dateStr.includes('-')) {
                    const parts = dateStr.split('-');
                    return new Date(parts[0], parts[1] - 1, parts[2]).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                }
                return dateObj.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            }

            function loadData() {
                $tbody.html(`<tr><td class="as-digital-36" colspan="7"><i class="bi bi-arrow-repeat spin as-digital-37"></i> Loading orders...</td></tr>`);
                $.ajax({
                    url: '/api/subscriptions/digital-orders',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function (res) {
                        allOrders = res || [];
                        updateStats(allOrders);
                        filterAndPaginate();
                    },
                    error: function (xhr) {
                        showToast('Error', 'Failed to fetch digital addon orders.', true);
                    }
                });
            }

            function updateStats(items) {
                const total = items.length;
                const paid = items.filter(x => x.payment_status.toLowerCase() === 'paid').length;
                const refunded = items.filter(x => x.payment_status.toLowerCase() === 'refunded').length;
                const sent = items.filter(x => x.delivery_status.toLowerCase() === 'sent').length;

                $('#stat-total').text(total);
                $('#stat-paid').text(paid);
                $('#stat-refunded').text(refunded);
                $('#stat-sent').text(sent);
            }

            function filterAndPaginate() {
                const searchVal = $searchInput.val().toLowerCase().trim();
                const itemVal = $itemFilter.val().toLowerCase();
                const paymentVal = ($paymentFilter.length && $paymentFilter.val()) ? $paymentFilter.val().toLowerCase() : 'all';

                const isFiltered = searchVal !== '' || itemVal !== 'all' || paymentVal !== 'all';
                $clearFiltersBtn.css('display', isFiltered ? 'inline-flex' : 'none');

                const filtered = allOrders.filter(order => {
                    const name = order.customer_name.toLowerCase();
                    const email = order.customer_email.toLowerCase();
                    const company = order.company_name.toLowerCase();
                    const item = order.item.toLowerCase();

                    const matchesSearch = name.includes(searchVal) || email.includes(searchVal) || company.includes(searchVal) || item.includes(searchVal);

                    let matchesItem = true;
                    if (itemVal !== 'all') {
                        matchesItem = item.includes(itemVal);
                    }

                    let matchesPayment = true;
                    if (paymentVal !== 'all') {
                        matchesPayment = order.payment_status.toLowerCase() === paymentVal;
                    }

                    return matchesSearch && matchesItem && matchesPayment;
                });

                const totalEntries = filtered.length;
                const totalPages = Math.ceil(totalEntries / pageSize) || 1;

                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = Math.min(startIndex + pageSize, totalEntries);

                $tbody.empty();
                if (totalEntries === 0) {
                    $tbody.append(`<tr><td class="as-digital-36" colspan="7">No digital addon orders found</td></tr>`);
                } else {
                    const pageRows = filtered.slice(startIndex, endIndex);
                    pageRows.forEach(order => {
                        const amountStr = '$' + (order.amount / 100).toFixed(2);
                        
                        let payPillColor = 'background-color: #dcfce7; color: #16a34a;'; // Paid
                        if (order.payment_status.toLowerCase() === 'refunded') {
                            payPillColor = 'background-color: #fee2e2; color: #ef4444;';
                        }

                        let delPillColor = 'background-color: #dbeafe; color: #2563eb;'; // Sent
                        if (order.delivery_status.toLowerCase() === 'failed') {
                            delPillColor = 'background-color: #fee2e2; color: #ef4444;';
                        }

                        const resendDisabled = order.payment_status.toLowerCase() === 'refunded';
                        const refundDisabled = order.payment_status.toLowerCase() === 'refunded';

                        const rowHtml = `
                            <tr>
                                <td class="as-digital-38">
                                    <div class="as-digital-39">${order.customer_name}</div>
                                    <div class="as-digital-40">${order.customer_email}</div>
                                </td>
                                <td class="as-digital-41">${order.company_name}</td>
                                <td class="as-digital-38">
                                    <div class="as-digital-42">${order.item}</div>
                                    <div class="as-digital-43">${amountStr}</div>
                                </td>
                                <td class="as-digital-41">${formatDate(order.order_date)}</td>
                                <td class="as-digital-38"><span class="as-digital-44" style="${payPillColor}">${order.payment_status}</span></td>
                                <td class="as-digital-38"><span class="as-digital-44" style="${delPillColor}">${order.delivery_status}</span></td>
                                <td class="as-digital-45 text-center">
                                    <button onclick="resendEmail(${order.id})" class="table-action-btn btn-resend" title="Resend Delivery Email" ${resendDisabled ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''}>
                                        <i class="bi bi-envelope-at"></i> Resend
                                    </button>
                                </td>
                            </tr>
                        `;
                        $tbody.append(rowHtml);
                    });
                }

                if (totalEntries === 0) {
                    $paginationInfo.text('Showing 0 to 0 of 0 entries');
                } else {
                    $paginationInfo.text(`Showing ${startIndex + 1} to ${endIndex} of ${totalEntries} entries`);
                }

                renderPaginationButtons(totalPages);
            }

            function renderPaginationButtons(totalPages) {
                $paginationButtons.empty();

                const $prevBtn = $('<button>').text('Previous');
                styleButton($prevBtn, currentPage === 1);
                if (currentPage > 1) {
                    $prevBtn.on('click', () => {
                        currentPage--;
                        filterAndPaginate();
                    });
                }
                $paginationButtons.append($prevBtn);

                for (let i = 1; i <= totalPages; i++) {
                    const $pageBtn = $('<button>').text(i);
                    styleButton($pageBtn, false, currentPage === i);
                    $pageBtn.on('click', () => {
                        currentPage = i;
                        filterAndPaginate();
                    });
                    $paginationButtons.append($pageBtn);
                }

                const $nextBtn = $('<button>').text('Next');
                styleButton($nextBtn, currentPage === totalPages);
                if (currentPage < totalPages) {
                    $nextBtn.on('click', () => {
                        currentPage++;
                        filterAndPaginate();
                    });
                }
                $paginationButtons.append($nextBtn);
            }

            function styleButton($btn, disabled = false, active = false) {
                $btn.css({
                    border: '1px solid #cbd5e1',
                    backgroundColor: active ? '#0f172a' : '#ffffff',
                    color: active ? '#ffffff' : '#475569',
                    padding: '6px 12px',
                    borderRadius: '6px',
                    fontSize: '13px',
                    fontWeight: '600',
                    cursor: disabled ? 'not-allowed' : 'pointer',
                    opacity: disabled ? 0.5 : 1
                });
            }

            window.resendEmail = function (id) {
                const $btn = $(event.currentTarget);
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html('<i class="bi bi-arrow-repeat spin"></i> Sending...');

                $.ajax({
                    url: `/api/subscriptions/digital-orders/${id}/resend`,
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function (res) {
                        $btn.prop('disabled', false).html(originalHtml);
                        showToast('Success', 'Delivery email resent successfully.', false);
                        loadData();
                    },
                    error: function (xhr) {
                        $btn.prop('disabled', false).html(originalHtml);
                        const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Resend email failed.';
                        showToast('Error', msg, true);
                        loadData();
                    }
                });
            };

            window.openRefundModal = function (id, amount) {
                $('#refund-order-id').val(id);
                $('#refund-amount-text').text('$' + (amount / 100).toFixed(2));
                $('#refundConfirmModal').css('display', 'flex');
            };

            window.closeRefundModal = function () {
                $('#refundConfirmModal').css('display', 'none');
                $('#refund-order-id').val('');
                $('#refund-amount-text').text('$0.00');
            };

            window.submitRefund = function () {
                const id = $('#refund-order-id').val();
                if (!id) return;

                const $btn = $('#btn-confirm-refund-submit');
                const originalText = $btn.text();
                $btn.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: `/api/subscriptions/digital-orders/${id}/refund`,
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function (res) {
                        $btn.prop('disabled', false).text(originalText);
                        closeRefundModal();
                        showToast('Success', 'Refund processed successfully via Stripe.', false);
                        loadData();
                    },
                    error: function (xhr) {
                        $btn.prop('disabled', false).text(originalText);
                        const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Refund failed.';
                        showToast('Error', msg, true);
                    }
                });
            };

            // Event Listeners
            $searchInput.on('input', () => {
                currentPage = 1;
                filterAndPaginate();
            });
            $itemFilter.on('change', () => {
                currentPage = 1;
                filterAndPaginate();
            });
            if ($paymentFilter.length) {
                $paymentFilter.on('change', () => {
                    currentPage = 1;
                    filterAndPaginate();
                });
            }
            $clearFiltersBtn.on('click', () => {
                $searchInput.val('');
                $itemFilter.val('all');
                if ($paymentFilter.length) {
                    $paymentFilter.val('all');
                }
                currentPage = 1;
                filterAndPaginate();
            });

            // Initial load
            loadData();

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection


<!-- // <button onclick="openRefundModal(${order.id}, ${order.amount})" class="table-action-btn btn-refund as-digital-47" title="Refund Add-on Payment" ${refundDisabled ? 'disabled ' : ''}>
//     <i class="bi bi-arrow-left-right"></i> Refund
// </button> -->