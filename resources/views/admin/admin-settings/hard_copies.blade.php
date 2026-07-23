@extends('layouts.portal')

@section('portal_styles')
    <style>
        .table-action-edit {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #0f172a;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .table-action-edit:hover {
            background-color: #f1f5f9;
            color: #b91c1c;
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
            max-width: 520px;
            width: 100%;
            overflow: hidden;
            animation: modalFadeIn 0.2s ease-out;
            margin: 16px;
        }
        .ctb-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 20px 0;
        }
        .ctb-modal-body {
            padding: 24px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 18px;
        }
        .form-col {
            flex: 1;
        }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            height: 38px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            box-sizing: border-box;
            font-size: 14px;
            color: #0f172a;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-input:focus {
            border-color: #b91c1c !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.15) !important;
            outline: none;
        }
        .form-select {
            width: 100%;
            height: 38px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #ffffff;
            color: #0f172a;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-select:focus {
            border-color: #b91c1c !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.15) !important;
            outline: none;
        }
        .form-textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            box-sizing: border-box;
            font-size: 14px;
            resize: vertical;
            font-family: inherit;
            color: #0f172a;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-textarea:focus {
            border-color: #b91c1c !important;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.15) !important;
            outline: none;
        }
        .ctb-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            align-items: center;
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
        .btn-modal-submit:disabled {
            background: #cbd5e1;
            border-color: #cbd5e1;
            cursor: not-allowed;
            opacity: 1;
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
            <h1 class="header-title">Shipments</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-total">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #f59e0b;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Active</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-active">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #ef4444;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">InActive</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-inactive">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #3b82f6;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Shipped</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-shipped">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #16a34a;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Delivered</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-delivered">-</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card" style="padding: 0;">
        <div class="card-header-custom" style="display: flex; flex-direction: column; gap: 16px; padding: 20px 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; width: 100%;">
                <h2 class="card-title-custom" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Shipments List</h2>
                <div style="position: relative;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 14px;"></i>
                    <input type="text" class="form-input-style" id="search-hard-copies" placeholder="Search companies or addresses..." style="padding-left: 36px; width: 300px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px;">
                </div>
            </div>
            
            <!-- Filters Row -->
            <div style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; width: 100%; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Status</span>
                    <select class="form-input-style" id="filter-status" style="width: 150px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="in transit">In Transit</option>
                        <option value="out for delivery">Out for Delivery</option>
                        <option value="delivered">Delivered</option>
                        <option value="exception / delayed">Exception / Delayed</option>
                        <option value="returned to sender">Returned to Sender</option>
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
            <table class="portal-grid-table" id="hard-copies-table" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 100px; min-width: 100px; white-space: nowrap;">Subscription</th>
                        <th style="width: 120px; min-width: 120px; white-space: nowrap;">Shipment No.</th>
                        <th style="width: 200px; min-width: 150px; white-space: nowrap;">Contact Name</th>
                        <th style="width: 220px; min-width: 150px; white-space: nowrap;">Item Name</th>
                        <th style="width: 100px; min-width: 100px; white-space: nowrap;">Carrier</th>
                        <th style="width: 120px; min-width: 120px; white-space: nowrap;">Tracking No.</th>
                        <th style="width: 110px; min-width: 110px; white-space: nowrap;">Ship Date</th>
                        <th style="width: 110px; min-width: 110px; white-space: nowrap;">Est. Delivery</th>
                        <th style="width: 130px; min-width: 120px; white-space: nowrap;">Shipment</th>
                        <th style="width: 130px; min-width: 130px; text-align: center; white-space: nowrap;">Action</th>
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
                Showing 1 to 5 of 9 entries
            </div>
            <div style="display: flex; gap: 8px; align-items: center;" id="pagination-buttons">
                <!-- Pagination buttons will be dynamically injected -->
            </div>
        </div>
    </div>

    <!-- Edit Shipment Modal (CTB Custom Modal) -->
    <div id="editShipmentModal" class="ctb-modal">
        <div class="ctb-modal-box">
            <div class="ctb-modal-body">
                <h3 class="ctb-modal-title" id="editShipmentModalLabel">Edit Shipment</h3>
                <form id="edit-shipment-form" novalidate>
                    <input type="hidden" id="edit-shipment-id">
                    
                    <div class="form-row">
                        <div class="form-col" style="flex: 1;">
                            <label class="form-label">Item Name</label>
                            <input type="text" id="shipment-edit-item-name" class="form-input" maxlength="255" placeholder="e.g. California Target Book">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col" style="flex: 1;">
                            <label class="form-label">Status</label>
                            <select id="shipment-edit-status" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="Shipped">Shipped</option>
                                <option value="In Transit">In Transit</option>
                                <option value="Out for Delivery">Out for Delivery</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Exception / Delayed">Exception / Delayed</option>
                                <option value="Returned to Sender">Returned to Sender</option>
                            </select>
                        </div>
                        <div class="form-col" style="flex: 1;">
                            <label class="form-label">Carrier</label>
                            <input type="text" id="shipment-edit-carrier" class="form-input" maxlength="255" placeholder="e.g. FedEx, UPS">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col" style="flex: 1;">
                            <label class="form-label">Tracking Number</label>
                            <input type="text" id="shipment-edit-tracking" class="form-input" maxlength="255">
                        </div>
                        <div class="form-col" style="flex: 1;">
                            <label class="form-label">Tracking URL</label>
                            <input type="url" id="shipment-edit-tracking-url" class="form-input" maxlength="255" placeholder="https://...">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col" style="flex: 1;">
                            <label class="form-label">Ship Date</label>
                            <input type="date" id="shipment-edit-ship-date" class="form-input">
                        </div>
                        <div class="form-col" style="flex: 1;">
                            <label class="form-label">Delivery Estimate</label>
                            <input type="date" id="shipment-edit-est-delivery" class="form-input">
                        </div>
                    </div>

                    <div id="shipment-edit-error" class="modal-error" style="display: none; color: #ef4444; background: #fef2f2; border: 1px solid #fecaca; padding: 10px; border-radius: 6px; margin-bottom: 16px; font-size: 13px;"></div>
                    
                    <div class="ctb-modal-footer">
                        <button type="button" class="btn-modal-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-modal-submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- View Shipment Modal -->
    <div id="viewShipmentModal" class="ctb-modal">
        <div class="ctb-modal-box">
            <div class="ctb-modal-body">
                <h3 class="ctb-modal-title">View Shipment Details</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Shipment Number</div>
                        <div id="view-order-id" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Status</div>
                        <div id="view-status" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px; text-transform: capitalize;">-</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Carrier</div>
                        <div id="view-carrier" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Tracking Number</div>
                        <div id="view-tracking" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Ship Date</div>
                        <div id="view-ship-date" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Estimated Delivery</div>
                        <div id="view-est-delivery" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 24px 0;">

                <h4 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 16px 0;">Address & Contact</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Contact Name</div>
                        <div id="view-contact-name" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Company Name</div>
                        <div id="view-company-name" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Item Name</div>
                        <div id="view-item-name" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px;">-</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Shipping Address</div>
                        <div id="view-address" style="font-size: 14px; color: #0f172a; font-weight: 500; margin-top: 4px; line-height: 1.5;">-</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Special Instructions</div>
                        <div id="view-instructions" style="font-size: 14px; color: #0f172a; font-style: italic; margin-top: 4px;">-</div>
                    </div>
                </div>

                <div class="ctb-modal-footer" style="margin-top: 24px;">
                    <button type="button" class="btn-modal-cancel" onclick="closeViewModal()" style="background: #f1f5f9; color: #0f172a;">Close</button>
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
            function showToast(title, body, isError = false) {
                $('#toast-title').text(title).css('color', isError ? '#ef4444' : '#10b981');
                $('#toast-body').text(body);
                $('#custom-toast').stop(true, true).fadeIn(300).delay(4000).fadeOut(300);
            }

            window.openEditModal = function(id) {
                $('#shipment-edit-error').hide().empty();
                // Populate data (you can fetch from allHardCopies array)
                const item = allHardCopies.find(x => x.id == id);
                if (item) {
                    $('#edit-shipment-id').val(item.id);
                    $('#shipment-edit-item-name').val(item.item_name || '');
                    $('#shipment-edit-status').val(item.status || 'Pending');
                    $('#shipment-edit-carrier').val(item.carrier || '');
                    $('#shipment-edit-tracking').val(item.tracking_id || '');
                    $('#shipment-edit-tracking-url').val(item.tracking_url || '');
                    $('#shipment-edit-ship-date').val(item.ship_date || '');
                    $('#shipment-edit-est-delivery').val(item.estimated_delivery || '');
                    
                    const addr = item.address || {};
                    $('#shipment-edit-line1').val(addr.line1 || '');
                    $('#shipment-edit-line2').val(addr.line2 || '');
                    $('#shipment-edit-city').val(addr.city || '');
                    $('#shipment-edit-state').val(addr.state || 'CA');
                    $('#shipment-edit-zip').val(addr.zip_code || '');
                    $('#shipment-edit-instructions').val(addr.special_instructions || '');
                }

                // Show modal
                $('#editShipmentModal').css('display', 'flex');
            };

            window.closeEditModal = function() {
                $('#editShipmentModal').css('display', 'none');
            };

            window.openViewModal = function(id) {
                const item = allHardCopies.find(x => x.id == id);
                if (item) {
                    const sub = item.subscription || {};
                    const addr = item.address || {};
                    const contactName = sub.baseAccount ? sub.baseAccount.name : 'Not Specified';
                    const companyName = sub.company || 'Not Specified';

                    $('#view-order-id').text('SH-' + item.id);
                    $('#view-item-name').text(item.item_name || '');
                    $('#view-status').text(item.status || 'Processing');
                    $('#view-carrier').text(item.carrier || '-');
                    
                    let trackingHtml = '-';
                    if (item.tracking_id) {
                        trackingHtml = item.tracking_id;
                        if (item.tracking_url) {
                            trackingHtml = `<a href="${item.tracking_url}" target="_blank" style="color: #b91c1c; text-decoration: underline;">${item.tracking_id}</a>`;
                        }
                    }
                    $('#view-tracking').html(trackingHtml);

                    $('#view-ship-date').text(item.ship_date ? new Date(item.ship_date).toLocaleDateString() : '-');
                    $('#view-est-delivery').text(item.estimated_delivery ? new Date(item.estimated_delivery).toLocaleDateString() : '-');

                    $('#view-contact-name').text(contactName);
                    $('#view-company-name').text(companyName);
                    $('#view-address').html(formatAddress(addr).replace(/<br>/g, ', '));
                    $('#view-instructions').text(addr.special_instructions || '-');
                }
                $('#viewShipmentModal').css('display', 'flex');
            };

            window.closeViewModal = function() {
                $('#viewShipmentModal').css('display', 'none');
            };

            $('#edit-shipment-form').on('submit', function(e) {
                e.preventDefault();
                
                const btn = $('#edit-shipment-form .btn-modal-submit');
                const errDiv = $('#shipment-edit-error');
                const id = $('#edit-shipment-id').val();
                
                if (!id) return;
                
                const item = allHardCopies.find(x => x.id == id);
                if (!item) return;

                const subId = item.subscription_id || 0;
                
                const statusVal = $('#shipment-edit-status').val();
                const carrierVal = $('#shipment-edit-carrier').val().trim();
                const trackingVal = $('#shipment-edit-tracking').val().trim();
                const shipDateVal = $('#shipment-edit-ship-date').val();
                const estDeliveryVal = $('#shipment-edit-est-delivery').val();
                
                let validationErrors = [];

                if (['Shipped', 'In Transit', 'Out for Delivery', 'Delivered'].includes(statusVal)) {
                    if (!carrierVal) validationErrors.push('Carrier is required when status is ' + statusVal + '.');
                    if (!trackingVal) validationErrors.push('Tracking Number is required when status is ' + statusVal + '.');
                    if (!shipDateVal) validationErrors.push('Ship Date is required when status is ' + statusVal + '.');
                }

                if (shipDateVal && estDeliveryVal) {
                    const shipTime = new Date(shipDateVal).getTime();
                    const estTime = new Date(estDeliveryVal).getTime();
                    if (estTime < shipTime) {
                        validationErrors.push('Estimated Delivery date cannot be before the Ship Date.');
                    }
                }

                const trackingUrlVal = $('#shipment-edit-tracking-url').val().trim();
                if (trackingUrlVal) {
                    const urlPattern = /^(https?:\/\/)?([\w\-]+(\.[\w\-]+)+)([\/\w\-.,@?^=%&:\/~+#]*[\w\-@?^=%&\/~+#])?$/;
                    if (!urlPattern.test(trackingUrlVal)) {
                        validationErrors.push('Please enter a valid Tracking URL (e.g. https://www.carrier.com/...).');
                    }
                }

                if (validationErrors.length > 0) {
                    errDiv.html(validationErrors.join('<br>')).show();
                    return;
                }

                btn.prop('disabled', true).text('Saving...');
                errDiv.hide();

                const payload = {
                    shipment: {
                        item_name: $('#shipment-edit-item-name').val(),
                        status: $('#shipment-edit-status').val(),
                        carrier: $('#shipment-edit-carrier').val(),
                        tracking_id: $('#shipment-edit-tracking').val(),
                        tracking_url: $('#shipment-edit-tracking-url').val(),
                        ship_date: $('#shipment-edit-ship-date').val() || null,
                        estimated_delivery: $('#shipment-edit-est-delivery').val() || null
                    }
                };

                $.ajax({
                    url: `/api/subscriptions/${subId}/hard-copies/${id}`,
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(payload),
                    success: function(res) {
                        btn.prop('disabled', false).text('Save');
                        // Update local data
                        const updated = res.data || res;
                        const index = allHardCopies.findIndex(x => x.id == id);
                        if (index !== -1) {
                            allHardCopies[index] = { ...allHardCopies[index], ...updated };
                        }
                        
                        closeEditModal();
                        filterAndPaginate();
                        showToast('Success', 'Shipment updated successfully.', false);
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Save');
                        let msg = 'Failed to save changes. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        errDiv.text(msg).show();
                        showToast('Error', msg, true);
                    }
                });
            });

            const apiToken = "{{ Auth::user()->api_token }}";
            const $searchInput = $('#search-hard-copies');
            const $statusFilter = $('#filter-status');
            const $clearFiltersBtn = $('#btn-clear-filters');
            const $tbody = $('#hard-copies-table tbody');
            const $paginationInfo = $('#pagination-info');
            const $paginationButtons = $('#pagination-buttons');

            let allHardCopies = [];
            let currentPage = 1;
            const pageSize = 5;

            function formatAddress(addr) {
                if (!addr) return 'Not Specified';
                const parts = [];
                if (addr.line1) parts.push(addr.line1);
                if (addr.line2) parts.push(addr.line2);
                if (addr.city || addr.state || addr.zip_code) {
                    let cityStateZip = '';
                    if (addr.city) cityStateZip += addr.city;
                    if (addr.state) cityStateZip += (cityStateZip ? ', ' : '') + addr.state;
                    if (addr.zip_code) cityStateZip += ' ' + addr.zip_code;
                    parts.push(cityStateZip);
                }
                return parts.join(', ');
            }

            function updateStats(items) {
                const total = items.length;
                const active = items.filter(item => item.subscription && item.subscription.isActive).length;
                const inactive = items.filter(item => !item.subscription || !item.subscription.isActive).length;
                const shipped = items.filter(item => (item.status || '').toLowerCase() === 'shipped').length;

                $('#stat-total').text(total);
                $('#stat-active').text(active);
                $('#stat-inactive').text(inactive);
                $('#stat-shipped').text(shipped);
            }

            function filterAndPaginate() {
                const searchVal = $searchInput.val().toLowerCase().trim();
                const statusVal = $statusFilter.val().toLowerCase();

                // Toggle Clear Filters button visibility
                const isFiltered = searchVal !== '' || statusVal !== 'all';
                if (isFiltered) {
                    $clearFiltersBtn.css('display', 'inline-flex');
                } else {
                    $clearFiltersBtn.css('display', 'none');
                }

                // 1. Get filtered list of rows
                const filteredRows = allHardCopies.filter(item => {
                    const sub = item.subscription || {};
                    const addr = item.address || {};
                    
                    const company = (sub.company || '').toLowerCase();
                    const itemStatus = (item.status || 'pending').toLowerCase();
                    const contactName = (sub.baseAccount ? sub.baseAccount.name : '').toLowerCase();
                    const specialInstructions = (addr.special_instructions || '').toLowerCase();
                    
                    const addrText = formatAddress(addr).toLowerCase();

                    const matchesSearch = company.includes(searchVal) || 
                                          addrText.includes(searchVal) || 
                                          contactName.includes(searchVal) || 
                                          specialInstructions.includes(searchVal);
                    
                    let matchesStatus = false;
                    if (statusVal === 'all') {
                        matchesStatus = true;
                    } else if (statusVal === 'active') {
                        matchesStatus = sub.isActive === true;
                    } else if (statusVal === 'inactive') {
                        matchesStatus = !sub.isActive;
                    } else {
                        matchesStatus = itemStatus === statusVal;
                    }

                    return matchesSearch && matchesStatus;
                });

                // 2. Calculate pagination boundaries
                const totalEntries = filteredRows.length;
                const totalPages = Math.ceil(totalEntries / pageSize) || 1;
                
                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = Math.min(startIndex + pageSize, totalEntries);

                // 3. Render only rows for current page
                $tbody.empty();
                if (totalEntries === 0) {
                    $tbody.append(`<tr><td colspan="6" style="text-align: center; color: #64748b; padding: 24px;">No hard copy subscriptions found</td></tr>`);
                } else {
                    const pageRows = filteredRows.slice(startIndex, endIndex);
                    pageRows.forEach(item => {
                        const sub = item.subscription || {};
                        const addr = item.address || {};
                        
                        const contactName = sub.baseAccount ? sub.baseAccount.name : 'Not Specified';
                        const specialInstructions = addr.special_instructions || '';
                        
                        const shipmentStatus = item.status ? (item.status.charAt(0).toUpperCase() + item.status.slice(1)) : 'Processing';

                        let pillColor = 'background-color: #f1f5f9; color: #475569;'; // default processing/pending
                        const statusLower = (item.status || 'pending').toLowerCase();
                        if (statusLower === 'delivered') {
                            pillColor = 'background-color: #dcfce7; color: #16a34a;';
                        } else if (statusLower === 'shipped' || statusLower === 'in transit' || statusLower === 'out for delivery') {
                            pillColor = 'background-color: #dbeafe; color: #2563eb;';
                        } else if (statusLower.includes('delay') || statusLower.includes('exception') || statusLower === 'returned to sender') {
                            pillColor = 'background-color: #fee2e2; color: #ef4444;';
                        }

                        const rowHtml = `
                            <tr>
                                <td style="vertical-align: middle;"><span style="display: inline-block; padding: 4px 12px; font-size: 12.5px; font-weight: 600; border-radius: 9999px; ${sub.isActive ? 'background-color: #e6f4ea; color: #137333;' : 'background-color: #fce8e6; color: #c5221f;'}">${sub.isActive ? 'Active' : 'Inactive'}</span></td>
                                <td class="fw-semibold" style="color: #0f172a !important;">SH-${item.id}</td>
                                <td style="color: #0f172a !important; font-weight: 500;">${contactName}</td>
                                <td style="color: #0f172a !important;">${item.item_name || ''}</td>
                                <td style="color: #475569;">${item.carrier || '-'}</td>
                                <td style="color: #475569;">${item.tracking_url ? `<a href="${item.tracking_url}" target="_blank" style="color: #2563eb; text-decoration: underline;">${item.tracking_id || 'Link'}</a>` : (item.tracking_id || '-')}</td>
                                <td style="color: #475569;">${item.ship_date ? new Date(item.ship_date).toLocaleDateString() : '-'}</td>
                                <td style="color: #475569;">${item.estimated_delivery ? new Date(item.estimated_delivery).toLocaleDateString() : '-'}</td>
                                <td><span style="display: inline-block; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 9999px; ${pillColor}">${shipmentStatus}</span></td>
                                <td class="action-column-cell">
                                    <div class="action-column-container">
                                        <a href="javascript:void(0)" onclick="openViewModal(${item.id})" class="table-action-edit" title="View">
                                            <i class="bi bi-eye" style="font-size: 16px;"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="openEditModal(${item.id})" class="table-action-edit" title="Edit">
                                            <i class="bi bi-pencil" style="font-size: 16px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `;
                        $tbody.append(rowHtml);
                    });
                }

                // 4. Update pagination info text
                if (totalEntries === 0) {
                    $paginationInfo.text('Showing 0 to 0 of 0 entries');
                } else {
                    $paginationInfo.text(`Showing ${startIndex + 1} to ${endIndex} of ${totalEntries} entries`);
                }

                // 5. Render pagination buttons
                renderPaginationButtons(totalPages);
            }

            function renderPaginationButtons(totalPages) {
                $paginationButtons.empty();

                // Previous Button
                const $prevBtn = $('<button>').text('Previous');
                styleButton($prevBtn, currentPage === 1);
                if (currentPage > 1) {
                    $prevBtn.on('click', () => {
                        currentPage--;
                        filterAndPaginate();
                    });
                }
                $paginationButtons.append($prevBtn);

                // Determine pages to show
                const pages = [];
                const delta = 1; 
                
                for (let i = 1; i <= totalPages; i++) {
                    if (i === 1 || i === totalPages || (i >= currentPage - delta && i <= currentPage + delta)) {
                        pages.push(i);
                    }
                }

                let lastPage = 0;
                pages.forEach(page => {
                    if (lastPage !== 0) {
                        if (page - lastPage === 2) {
                            const $pageBtn = $('<button>').text(lastPage + 1);
                            styleButton($pageBtn, false, currentPage === lastPage + 1);
                            const tempVal = lastPage + 1;
                            $pageBtn.on('click', () => {
                                currentPage = tempVal;
                                filterAndPaginate();
                            });
                            $paginationButtons.append($pageBtn);
                        } else if (page - lastPage > 2) {
                            const $ellipsis = $('<span>').text('...').css({
                                padding: '6px 12px',
                                color: '#94a3b8',
                                fontSize: '13px'
                            });
                            $paginationButtons.append($ellipsis);
                        }
                    }
                    
                    const $pageBtn = $('<button>').text(page);
                    styleButton($pageBtn, false, currentPage === page);
                    $pageBtn.on('click', () => {
                        currentPage = page;
                        filterAndPaginate();
                    });
                    $paginationButtons.append($pageBtn);
                    
                    lastPage = page;
                });

                // Next Button
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

            function styleButton($btn, isDisabled, isActive = false) {
                $btn.css({
                    padding: '6px 12px',
                    borderRadius: '6px',
                    fontSize: '13px',
                    fontWeight: '500',
                    border: '1px solid #e2e8f0',
                    transition: 'all 0.15s ease-in-out'
                });
                
                if (isDisabled) {
                    $btn.css({
                        background: '#f8fafc',
                        color: '#94a3b8',
                        cursor: 'not-allowed'
                    });
                } else if (isActive) {
                    $btn.css({
                        background: '#0f172a',
                        color: '#ffffff',
                        borderColor: '#0f172a',
                        cursor: 'default'
                    });
                } else {
                    $btn.css({
                        background: '#ffffff',
                        color: '#475569',
                        cursor: 'pointer'
                    });
                    
                    $btn.on('mouseenter', function() {
                        $(this).css({
                            background: '#f8fafc',
                            borderColor: '#cbd5e1'
                        });
                    }).on('mouseleave', function() {
                        $(this).css({
                            background: '#ffffff',
                            borderColor: '#e2e8f0'
                        });
                    });
                }
            }

            // Listeners
            if ($searchInput.length) {
                $searchInput.on('input', () => {
                    currentPage = 1;
                    filterAndPaginate();
                });
            }
            if ($statusFilter.length) {
                $statusFilter.on('change', () => {
                    currentPage = 1;
                    filterAndPaginate();
                });
            }
            if ($clearFiltersBtn.length) {
                $clearFiltersBtn.on('click', () => {
                    $searchInput.val('');
                    $statusFilter.val('all');
                    currentPage = 1;
                    filterAndPaginate();
                });
            }

            // Load data from API
            $tbody.html(`<tr><td colspan="6" style="text-align: center; color: #64748b; padding: 24px;"><i class="bi bi-arrow-repeat spin" style="font-size: 20px; display: inline-block; animation: spin 1s linear infinite; margin-right: 8px;"></i> Loading hard copies...</td></tr>`);

            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                `)
                .appendTo('head');

            $.ajax({
                url: '/api/subscriptions/hard-copies',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + apiToken,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    console.log(res);
                    allHardCopies = res.data || res;
                    updateStats(allHardCopies);
                    filterAndPaginate();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching hard copies:', error);
                    $tbody.html(`<tr><td colspan="6" style="text-align: center; color: #ef4444; padding: 24px;">Failed to load hard copy subscriptions. Please try again later.</td></tr>`);
                }
            });
        });
    </script>
@endsection
