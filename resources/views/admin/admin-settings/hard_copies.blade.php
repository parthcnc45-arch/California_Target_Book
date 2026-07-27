@extends('layouts.portal')



@section('portal_content')
    <div class="section-header as-hardcopies-1">
        <div class="header-title-container">
            <h1 class="header-title">Shipments</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="as-hardcopies-2">
        <div class="portal-card as-hardcopies-3">
            <div class="as-hardcopies-4">Total</div>
            <div class="as-hardcopies-5" id="stat-total">-</div>
        </div>
        <div class="portal-card as-hardcopies-6">
            <div class="as-hardcopies-4">Active</div>
            <div class="as-hardcopies-5" id="stat-active">-</div>
        </div>
        <div class="portal-card as-hardcopies-7">
            <div class="as-hardcopies-4">InActive</div>
            <div class="as-hardcopies-5" id="stat-inactive">-</div>
        </div>
        <div class="portal-card as-hardcopies-8">
            <div class="as-hardcopies-4">Shipped</div>
            <div class="as-hardcopies-5" id="stat-shipped">-</div>
        </div>
        <div class="portal-card as-hardcopies-9">
            <div class="as-hardcopies-4">Delivered</div>
            <div class="as-hardcopies-5" id="stat-delivered">-</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card as-hardcopies-10">
        <div class="card-header-custom as-hardcopies-11">
            <div class="as-hardcopies-12">
                <h2 class="card-title-custom as-hardcopies-13">Shipments List</h2>
                <div class="as-hardcopies-14">
                    <i class="bi bi-search as-hardcopies-15"></i>
                    <input type="text" class="form-input-style as-hardcopies-16" id="search-hard-copies" placeholder="Search companies or addresses...">
                </div>
            </div>
            
            <!-- Filters Row -->
            <div class="as-hardcopies-17">
                <div class="as-hardcopies-18">
                    <span class="as-hardcopies-19">Status</span>
                    <select class="form-input-style as-hardcopies-20" id="filter-status">
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
                <div class="as-hardcopies-21">
                    <button class="as-hardcopies-22" id="btn-clear-filters" onmouseenter="this.style.backgroundColor='#e2e8f0'" onmouseleave="this.style.backgroundColor='#f1f5f9'">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table as-hardcopies-23" id="hard-copies-table">
                <thead>
                    <tr>
                        <th class="as-hardcopies-24">Subscription</th>
                        <th class="as-hardcopies-25">Shipment No.</th>
                        <th class="as-hardcopies-26">Contact Name</th>
                        <th class="as-hardcopies-27">Item Name</th>
                        <th class="as-hardcopies-24">Carrier</th>
                        <th class="as-hardcopies-25">Tracking No.</th>
                        <th class="as-hardcopies-28">Ship Date</th>
                        <th class="as-hardcopies-28">Est. Delivery</th>
                        <th class="as-hardcopies-29">Shipment</th>
                        <th class="as-hardcopies-30">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS loaded data will be injected here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Footer -->
        <div class="as-hardcopies-31">
            <div class="as-hardcopies-32" id="pagination-info">
                Showing 1 to 5 of 9 entries
            </div>
            <div class="as-hardcopies-33" id="pagination-buttons">
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
                        <div class="form-col as-hardcopies-34">
                            <label class="form-label">Item Name</label>
                            <input type="text" id="shipment-edit-item-name" class="form-input" maxlength="255" placeholder="e.g. California Target Book">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col as-hardcopies-34">
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
                        <div class="form-col as-hardcopies-34">
                            <label class="form-label">Carrier</label>
                            <input type="text" id="shipment-edit-carrier" class="form-input" maxlength="255" placeholder="e.g. FedEx, UPS">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col as-hardcopies-34">
                            <label class="form-label">Tracking Number</label>
                            <input type="text" id="shipment-edit-tracking" class="form-input" maxlength="255">
                        </div>
                        <div class="form-col as-hardcopies-34">
                            <label class="form-label">Tracking URL</label>
                            <input type="url" id="shipment-edit-tracking-url" class="form-input" maxlength="255" placeholder="https://...">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col as-hardcopies-34">
                            <label class="form-label">Ship Date</label>
                            <input type="date" id="shipment-edit-ship-date" class="form-input">
                        </div>
                        <div class="form-col as-hardcopies-34">
                            <label class="form-label">Delivery Estimate</label>
                            <input type="date" id="shipment-edit-est-delivery" class="form-input">
                        </div>
                    </div>

                    <div id="shipment-edit-error" class="modal-error as-hardcopies-35"></div>
                    
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
                
                <div class="as-hardcopies-36">
                    <div>
                        <div class="as-hardcopies-37">Shipment Number</div>
                        <div class="as-hardcopies-38" id="view-order-id">-</div>
                    </div>
                    <div>
                        <div class="as-hardcopies-37">Status</div>
                        <div class="as-hardcopies-39" id="view-status">-</div>
                    </div>
                    <div>
                        <div class="as-hardcopies-37">Carrier</div>
                        <div class="as-hardcopies-38" id="view-carrier">-</div>
                    </div>
                    <div>
                        <div class="as-hardcopies-37">Tracking Number</div>
                        <div class="as-hardcopies-38" id="view-tracking">-</div>
                    </div>
                    <div>
                        <div class="as-hardcopies-37">Ship Date</div>
                        <div class="as-hardcopies-38" id="view-ship-date">-</div>
                    </div>
                    <div>
                        <div class="as-hardcopies-37">Estimated Delivery</div>
                        <div class="as-hardcopies-38" id="view-est-delivery">-</div>
                    </div>
                </div>

                <hr class="as-hardcopies-40">

                <h4 class="as-hardcopies-41">Address & Contact</h4>
                <div class="as-hardcopies-42">
                    <div>
                        <div class="as-hardcopies-37">Contact Name</div>
                        <div class="as-hardcopies-38" id="view-contact-name">-</div>
                    </div>
                    <div>
                        <div class="as-hardcopies-37">Company Name</div>
                        <div class="as-hardcopies-38" id="view-company-name">-</div>
                    </div>
                    <div>
                        <div class="as-hardcopies-37">Item Name</div>
                        <div class="as-hardcopies-38" id="view-item-name">-</div>
                    </div>
                    <div class="as-hardcopies-43">
                        <div class="as-hardcopies-37">Shipping Address</div>
                        <div class="as-hardcopies-44" id="view-address">-</div>
                    </div>
                    <div class="as-hardcopies-43">
                        <div class="as-hardcopies-37">Special Instructions</div>
                        <div class="as-hardcopies-45" id="view-instructions">-</div>
                    </div>
                </div>

                <div class="ctb-modal-footer as-hardcopies-46">
                    <button type="button" class="btn-modal-cancel as-hardcopies-47" onclick="closeViewModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="custom-toast" class="portal-toast as-hardcopies-48">
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
                $('#edit-shipment-id').val('');
                $('#shipment-edit-item-name').val('');
                $('#shipment-edit-status').val('Pending');
                $('#shipment-edit-carrier').val('');
                $('#shipment-edit-tracking').val('');
                $('#shipment-edit-tracking-url').val('');
                $('#shipment-edit-ship-date').val('');
                $('#shipment-edit-est-delivery').val('');
                $('#shipment-edit-error').hide().empty();
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
                            trackingHtml = `<a class="as-hardcopies-49" href="${item.tracking_url}" target="_blank">${item.tracking_id}</a>`;
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
                    $tbody.append(`<tr><td class="as-hardcopies-50" colspan="6">No hard copy subscriptions found</td></tr>`);
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
                                <td class="as-hardcopies-51"><span class="as-hardcopies-52" style="${sub.isActive ? 'background-color: #e6f4ea; color: #137333;' : 'background-color: #fce8e6; color: #c5221f;'}">${sub.isActive ? 'Active' : 'Inactive'}</span></td>
                                <td class="fw-semibold as-hardcopies-53">SH-${item.id}</td>
                                <td class="as-hardcopies-54">${contactName}</td>
                                <td class="as-hardcopies-53">${item.item_name || ''}</td>
                                <td class="as-hardcopies-55">${item.carrier || '-'}</td>
                                <td class="as-hardcopies-55">${item.tracking_url ? `<a class="as-hardcopies-56" href="${item.tracking_url}" target="_blank">${item.tracking_id || 'Link'}</a>` : (item.tracking_id || '-')}</td>
                                <td class="as-hardcopies-55">${item.ship_date ? new Date(item.ship_date).toLocaleDateString() : '-'}</td>
                                <td class="as-hardcopies-55">${item.estimated_delivery ? new Date(item.estimated_delivery).toLocaleDateString() : '-'}</td>
                                <td><span class="as-hardcopies-57" style="${pillColor}">${shipmentStatus}</span></td>
                                <td class="as-classifieds-76">
                                    <div class="dropdown table-dropdown-container">
                                        <button class="table-action-edit" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end as-classifieds-77">
                                            <li><a class="dropdown-item as-classifieds-78" href="javascript:void(0)" onclick="openViewModal(${item.id})"><i class="bi bi-eye as-classifieds-79"></i> View</a></li>
                                            <li><a class="dropdown-item as-classifieds-78" href="javascript:void(0)" onclick="openEditModal(${item.id})"><i class="bi bi-pencil as-classifieds-79"></i> Edit</a></li>
                                        </ul>
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
            $tbody.html(`<tr><td class="as-hardcopies-50" colspan="6"><i class="bi bi-arrow-repeat spin as-hardcopies-59"></i> Loading hard copies...</td></tr>`);

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
                    $tbody.html(`<tr><td class="as-hardcopies-60" colspan="6">Failed to load hard copy subscriptions. Please try again later.</td></tr>`);
                }
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
