@extends('layouts.portal')

@section('portal_styles')
    <style>
        .table-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #0f172a;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
        }
        .btn-resend:hover {
            background-color: #f1f5f9;
            color: #2563eb;
            border-color: #2563eb;
        }
        .btn-refund:hover {
            background-color: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }
        /* Custom modal overrides */
        .ctb-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .ctb-modal-box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            max-width: 450px;
            width: 100%;
            overflow: hidden;
            animation: modalFadeIn 0.2s ease-out;
            margin: 16px;
        }
        .ctb-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 12px 0;
        }
        .ctb-modal-body {
            padding: 24px;
        }
        .ctb-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            align-items: center;
            margin-top: 24px;
        }
        .btn-modal-cancel {
            background: none;
            border: none;
            color: #64748b;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 16px;
            cursor: pointer;
            text-transform: uppercase;
            border-radius: 6px;
            transition: background 0.15s;
        }
        .btn-modal-cancel:hover {
            background: #f1f5f9;
        }
        .btn-modal-submit {
            background: #b91c1c;
            border: 1px solid #b91c1c;
            color: #ffffff;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 20px;
            cursor: pointer;
            text-transform: uppercase;
            border-radius: 6px;
            transition: opacity 0.15s;
        }
        .btn-modal-submit:hover {
            background: #991b1b;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
@endsection

@section('portal_content')
    <div class="section-header" style="justify-content: space-between;">
        <div class="header-title-container">
            <h1 class="header-title">Digital Orders</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total Orders</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-total">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #16a34a;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Paid</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-paid">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #ef4444;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Refunded</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-refunded">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #2563eb;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Sent</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-sent">-</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card" style="padding: 0;">
        <div class="card-header-custom" style="display: flex; flex-direction: column; gap: 16px; padding: 20px 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; width: 100%;">
                <h2 class="card-title-custom" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Digital Add-on Orders</h2>
                <div style="position: relative;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 14px;"></i>
                    <input type="text" class="form-input-style" id="search-digital" placeholder="Search customer or item..." style="padding-left: 36px; width: 300px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px;">
                </div>
            </div>
            
            <!-- Filters Row -->
            <div style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; width: 100%; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Item Name</span>
                    <select class="form-input-style" id="filter-item" style="width: 200px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Items</option>
                        <option value="deck">Post-Election Deck Only</option>
                        <option value="presentation">Post-Election Presentation</option>
                    </select>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Payment Status</span>
                    <select class="form-input-style" id="filter-payment" style="width: 150px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Statuses</option>
                        <option value="paid">Paid</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>
                <!-- Clear Filters Button -->
                <div style="padding-bottom: 2px;">
                    <button id="btn-clear-filters" onmouseenter="this.style.backgroundColor='#e2e8f0'" onmouseleave="this.style.backgroundColor='#f1f5f9'" style="display: none; height: 36px; background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 0 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; align-items: center; gap: 6px; transition: all 0.15s ease-in-out;">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table" id="digital-orders-table" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 250px; min-width: 200px; white-space: nowrap;">Customer / Email</th>
                        <th style="width: 150px; min-width: 120px; white-space: nowrap;">Company</th>
                        <th style="width: 280px; min-width: 200px; white-space: nowrap;">Item</th>
                        <th style="width: 140px; min-width: 120px; white-space: nowrap;">Order Date</th>
                        <th style="width: 120px; min-width: 100px; white-space: nowrap;">Payment</th>
                        <th style="width: 120px; min-width: 100px; white-space: nowrap;">Delivery</th>
                        <th style="width: 220px; min-width: 200px; text-align: center; white-space: nowrap;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS loaded data will be injected here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Footer -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-top: 1px solid #f1f5f9; background-color: #ffffff; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
            <div style="font-size: 13.5px; color: #64748b;" id="pagination-info">
                Showing 0 to 0 of 0 entries
            </div>
            <div style="display: flex; gap: 8px; align-items: center;" id="pagination-buttons">
                <!-- Pagination buttons will be dynamically injected -->
            </div>
        </div>
    </div>

    <!-- Refund Confirmation Modal -->
    <div id="refundConfirmModal" class="ctb-modal">
        <div class="ctb-modal-box">
            <div class="ctb-modal-body">
                <h3 class="ctb-modal-title">Confirm Refund</h3>
                <p style="font-size: 14.5px; color: #475569; line-height: 1.5; margin: 0 0 12px 0;">
                    Are you sure you want to refund this order? This action will process a partial refund of <strong id="refund-amount-text">$0.00</strong> on Stripe.
                </p>
                <p style="font-size: 13px; color: #ef4444; font-weight: 500; margin: 0;">
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
    <div id="custom-toast" class="portal-toast" style="display: none;">
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

            function loadData() {
                $tbody.html(`<tr><td colspan="7" style="text-align: center; color: #64748b; padding: 24px;"><i class="bi bi-arrow-repeat spin" style="font-size: 20px;"></i> Loading orders...</td></tr>`);
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
                const paymentVal = $paymentFilter.val().toLowerCase();

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
                    $tbody.append(`<tr><td colspan="7" style="text-align: center; color: #64748b; padding: 24px;">No digital addon orders found</td></tr>`);
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
                                <td style="vertical-align: middle;">
                                    <div style="font-weight: 600; color: #0f172a;">${order.customer_name}</div>
                                    <div style="font-size: 12px; color: #64748b;">${order.customer_email}</div>
                                </td>
                                <td style="color: #475569; vertical-align: middle;">${order.company_name}</td>
                                <td style="vertical-align: middle;">
                                    <div style="font-weight: 500; color: #0f172a;">${order.item}</div>
                                    <div style="font-size: 12.5px; color: #b91c1c; font-weight: 600; margin-top: 2px;">${amountStr}</div>
                                </td>
                                <td style="color: #475569; vertical-align: middle;">${new Date(order.order_date).toLocaleDateString()}</td>
                                <td style="vertical-align: middle;"><span style="display: inline-block; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 9999px; ${payPillColor}">${order.payment_status}</span></td>
                                <td style="vertical-align: middle;"><span style="display: inline-block; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 9999px; ${delPillColor}">${order.delivery_status}</span></td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <button onclick="resendEmail(${order.id})" class="table-action-btn btn-resend" title="Resend Delivery Email" ${resendDisabled ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''}>
                                            <i class="bi bi-envelope-at"></i> Resend
                                        </button>
                                        <button onclick="openRefundModal(${order.id}, ${order.amount})" class="table-action-btn btn-refund" title="Refund Add-on Payment" ${refundDisabled ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''}>
                                            <i class="bi bi-arrow-left-right"></i> Refund
                                        </button>
                                    </div>
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
                    backgroundColor: active ? '#b91c1c' : '#ffffff',
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
            $paymentFilter.on('change', () => {
                currentPage = 1;
                filterAndPaginate();
            });
            $clearFiltersBtn.on('click', () => {
                $searchInput.val('');
                $itemFilter.val('all');
                $paymentFilter.val('all');
                currentPage = 1;
                filterAndPaginate();
            });

            // Initial load
            loadData();
        });
    </script>
@endsection
