@extends('layouts.portal')



@section('portal_content')
    <div class="section-header as-classifieds-1">
        <div class="header-title-container">
            <h1 class="header-title">Classifieds Manager</h1>
        </div>
        <button type="button" id="btn-add-classified" class="btn-add-subscription as-classifieds-2">
            <i class="bi bi-plus-lg"></i> ADD
        </button>
    </div>

    <!-- Stats Grid Row -->
    <div class="stats-grid-classifieds">
        <!-- Card 1: Active Ads -->
        <div class="stats-card-classified">
            <div>
                <div class="as-classifieds-3">Active Ads</div>
                <div class="as-classifieds-4" id="stat-active">-</div>
                <div class="as-classifieds-5">Currently live</div>
            </div>
            <div class="as-classifieds-6">
                <i class="bi bi-pencil-square"></i>
            </div>
        </div>

        <!-- Card 2: Pending Review -->
        <div class="stats-card-classified">
            <div>
                <div class="as-classifieds-3">Pending Review</div>
                <div class="as-classifieds-4" id="stat-pending">-</div>
                <div class="as-classifieds-5">Awaiting approval</div>
            </div>
            <div class="as-classifieds-7">
                <i class="bi bi-clock"></i>
            </div>
        </div>

        <!-- Card 3: Expiring Soon -->
        <div class="stats-card-classified">
            <div>
                <div class="as-classifieds-3">Expiring Soon</div>
                <div class="as-classifieds-4" id="stat-expiring">-</div>
                <div class="as-classifieds-5">Within 3 days</div>
            </div>
            <div class="as-classifieds-8">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
        </div>

        <!-- Card 4: Revenue -->
        <div class="stats-card-classified">
            <div>
                <div class="as-classifieds-3">Revenue (Month)</div>
                <div class="as-classifieds-4" id="stat-revenue">-</div>
                <div class="as-classifieds-5" id="stat-revenue-month-label">{{ date('F Y') }}</div>
            </div>
            <div class="as-classifieds-9">
                <i class="bi bi-currency-dollar"></i>
            </div>
        </div>
    </div>

    <!-- Pending Alert Banner -->
    <div class="as-classifieds-10" id="pending-alert-banner">
        <div>
            <i class="bi bi-exclamation-circle-fill as-classifieds-11"></i>
            <span id="pending-alert-text">0 ads are pending review. New submissions require approval before going live.</span>
            <a class="as-classifieds-12" href="#" id="btn-review-now">Review now &rarr;</a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="portal-card as-classifieds-13">
        <div class="card-header-custom as-classifieds-14">
            <div class="as-classifieds-15">
                <h2 class="card-title-custom as-classifieds-16">All Classified Ads</h2>
            </div>
            
            <!-- Filters Row -->
            <div class="filter-row-classifieds as-classifieds-17">
                <div class="as-classifieds-18">
                    <i class="bi bi-search as-classifieds-19"></i>
                    <input type="text" class="form-input-style as-classifieds-20" id="search-classifieds" placeholder="Search ads...">
                </div>
                
                <div>
                    <select class="form-input-style as-classifieds-21" id="filter-status">
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <div>
                    <select class="form-input-style as-classifieds-21" id="filter-category">
                        <option value="all">All Categories</option>
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        @else
                            <option value="Jobs">Jobs</option>
                            <option value="Office Space">Office Space</option>
                            <option value="Consulting">Consulting</option>
                            <option value="Other">Other</option>
                        @endif
                    </select>
                </div>

                <div>
                    <select class="form-input-style as-classifieds-21" id="filter-date-range">
                        <option value="all">All Time</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                    </select>
                </div>

                <div class="as-classifieds-22">
                    <button class="as-classifieds-23" id="btn-clear-filters">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                    <button type="button" class="btn-export-csv as-classifieds-24" id="btn-export-csv">
                        <i class="bi bi-download"></i> Export CSV
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body-custom as-classifieds-25">
            <table class="portal-grid-table as-classifieds-26" id="classifieds-table">
                <thead>
                    <tr>
                        <th class="as-classifieds-27">Ad</th>
                        <th class="as-classifieds-28">Category</th>
                        <th class="as-classifieds-29">Advertiser</th>
                        <th class="as-classifieds-30">Start Date</th>
                        <th class="as-classifieds-30">End Date</th>
                        <th class="as-classifieds-31">Status</th>
                        <th class="as-classifieds-30">Payment Status</th>
                        <th class="as-classifieds-31">Rate</th>
                        <th class="as-classifieds-32"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS loaded data -->
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Footer -->
        <div class="as-classifieds-33">
            <div class="as-classifieds-34" id="pagination-info">
                Showing 0 to 0 of 0 entries
            </div>
            <div class="as-classifieds-35" id="pagination-buttons">
                <!-- Pagination buttons -->
            </div>
        </div>
    </div>

    <!-- Custom Confirm Delete Modal -->
    <div class="as-classifieds-36" id="confirm-modal">
        <div class="portal-card as-classifieds-37">
            <div class="as-classifieds-38">
                <i class="bi bi-exclamation-triangle as-classifieds-39"></i>
            </div>
            <h3 class="as-classifieds-40">Delete Classified Ad?</h3>
            <p class="as-classifieds-41">Are you sure you want to permanently delete this classified ad? This action cannot be undone.</p>
            <div class="as-classifieds-42">
                <button class="as-classifieds-43 btn-modal-cancel" type="button" id="btn-cancel-delete">Cancel</button>
                <button class="as-classifieds-44" type="button" id="btn-confirm-delete">Delete</button>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="as-classifieds-36" id="view-modal">
        <div class="portal-card as-classifieds-45">
            <div class="as-classifieds-46">
                <h3 class="as-classifieds-16">Classified Ad Details</h3>
                <button class="as-classifieds-47" type="button" id="btn-close-view-modal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="as-classifieds-48" id="view-modal-content">
                <!-- Content will be injected here -->
            </div>
        </div>
    </div>

    <!-- Modal Popup for Add/Edit Classified -->
    <div id="classified-modal">
        <div class="portal-card as-classifieds-45" id="modal-container">
            <!-- Modal Header -->
            <div class="as-classifieds-46">
                <h3 class="as-classifieds-16" id="modal-title">Add Classified Ad</h3>
                <button class="as-classifieds-47" type="button" id="btn-close-modal"><i class="bi bi-x-lg"></i></button>
            </div>
            
            <!-- Error Banner -->
            <div class="as-classifieds-49" id="modal-error-banner"></div>

            <!-- Form -->
            <form class="as-classifieds-50" id="classified-form" novalidate>
                <input type="hidden" id="classified_id">

                <!-- Contact Information -->
                <div class="as-classifieds-51">
                    <div class="as-classifieds-52">
                        <label class="form-label-style">First Name *</label>
                        <input type="text" id="first_name" class="form-input-style" placeholder="e.g. John" required>
                    </div>
                    <div class="as-classifieds-52">
                        <label class="form-label-style">Last Name *</label>
                        <input type="text" id="last_name" class="form-input-style" placeholder="e.g. Doe" required>
                    </div>
                </div>
                
                <div class="as-classifieds-51">
                    <div class="as-classifieds-52">
                        <label class="form-label-style">Phone Number *</label>
                        <input type="text" id="phone_number" class="form-input-style" placeholder="e.g. (555) 123-4567" required>
                    </div>
                    <div class="as-classifieds-52">
                        <label class="form-label-style">Advertiser Email *</label>
                        <input type="email" id="advertiser_email" class="form-input-style" placeholder="contact@org.com" required>
                    </div>
                </div>

                <!-- Organization Name -->
                <div>
                    <label class="form-label-style">Organization Name *</label>
                    <input type="text" id="organization_name" class="form-input-style" placeholder="e.g. Department of Finance" required>
                </div>

                <!-- Status & Category Select dropdowns -->
                <div class="as-classifieds-51">
                    <div class="as-classifieds-53">
                        <label class="form-label-style">Category *</label>
                        <select class="form-input-style" id="category" required>
                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $index => $cat)
                                    <option value="{{ $cat->name }}" {{ $index === 0 ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            @else
                                <option value="Jobs" selected>Jobs</option>
                                <option value="Office Space">Office Space</option>
                                <option value="Consulting">Consulting</option>
                                <option value="Other">Other</option>
                            @endif
                        </select>
                    </div>
                    <div class="as-classifieds-53">
                        <label class="form-label-style">Status *</label>
                        <select class="form-input-style" id="status" required>
                            <option value="Pending" selected>Pending</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Ad Headline / Title -->
                <div>
                    <label class="form-label-style">Ad Headline / Title *</label>
                    <input type="text" id="title" class="form-input-style" placeholder="e.g. Senior Policy Analyst" required>
                </div>

                <!-- Ad Body Text -->
                <div>
                    <label class="form-label-style">Ad Body Text *</label>
                    <textarea id="body" class="form-input-style as-classifieds-54" placeholder="Ad description, salary, qualifications, how to apply..." required></textarea>
                    <div class="as-classifieds-55">
                        <span class="as-classifieds-56" id="body-helper-text">Maximum 100 words.</span>
                        <span class="as-classifieds-57" id="word-count-badge">0 / 100 words</span>
                    </div>
                </div>

                <!-- Link URL -->
                <div>
                    <label class="form-label-style">Link URL</label>
                    <input type="text" id="link_url" class="form-input-style" placeholder="https://...">
                </div>
                <div class="as-classifieds-51">
                    <div class="as-classifieds-52">
                        <label class="form-label-style">Payment Status *</label>
                        <select class="form-input-style" id="payment_status" required>
                            <option value="Paid (via GHL)" selected>Paid (via GHL)</option>
                            <option value="Pending Payment">Pending Payment</option>
                            <option value="Invoiced">Invoiced</option>
                            <option value="Complimentary">Complimentary</option>
                        </select>
                    </div>
                </div>

                <!-- Ad Duration & Rate ($) -->
                <div class="as-classifieds-51">
                    <div class="as-classifieds-52">
                        <label class="form-label-style">Ad Duration *</label>
                        <select class="form-input-style" id="rate_type" required>
                            @if(isset($rates) && count($rates) > 0)
                                @foreach($rates as $index => $rate)
                                    @php
                                        $rateTitle = $rate->title ?? $rate->name;
                                        $rateAmt = $rate->rate_amount ? round($rate->rate_amount) : '';
                                        $rateDays = $rate->days ?? '';
                                        $details = '';
                                        if ($rateAmt && $rateDays) {
                                            $details = " (\${$rateAmt} / {$rateDays} Days)";
                                        } elseif ($rateAmt) {
                                            $details = " (\${$rateAmt})";
                                        }
                                    @endphp
                                    <option value="{{ $rate->id }}" data-amount="{{ $rateAmt }}" data-days="{{ $rateDays }}" {{ $index === 0 ? 'selected' : '' }}>{{ $rateTitle }}{{ $details }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="as-classifieds-52">
                        <label class="form-label-style">Rate ($) *</label>
                        <input type="number" id="ad_rate_amount" class="form-input-style" placeholder="e.g. 165" min="0" step="0.01" required>
                    </div>
                </div>

                <!-- Start Date & End Date -->
                <div class="as-classifieds-51">
                    <div class="as-classifieds-53">
                        <label class="form-label-style">Start Date *</label>
                        <input type="date" id="starts_on" class="form-input-style" placeholder="mm/dd/yyyy" required>
                    </div>
                    <div class="as-classifieds-53">
                        <label class="form-label-style">End Date *</label>
                        <input type="date" id="ends_on" class="form-input-style" placeholder="mm/dd/yyyy" required>
                    </div>
                </div>

                <!-- Admin Notes -->
                <div>
                    <label class="form-label-style">Admin Notes</label>
                    <textarea id="admin_notes" class="form-input-style as-classifieds-58" placeholder="Internal notes (not shown publicly)..."></textarea>
                </div>

                <!-- Actions Button Row -->
                <div class="as-classifieds-59">

                    <div class="as-classifieds-60">
                        <button class="as-classifieds-61 btn-modal-cancel" type="button" id="btn-cancel-modal">Cancel</button>
                        <button class="as-classifieds-62" type="submit" id="btn-save-classified">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('portal_scripts')
    <script>
        $(document).ready(function () {
            const apiToken = "{{ Auth::user()->api_token }}";
            const $searchInput = $('#search-classifieds');
            const $statusFilter = $('#filter-status');
            const $categoryFilter = $('#filter-category');
            const $dateRangeFilter = $('#filter-date-range');
            const $btnClearFilters = $('#btn-clear-filters');
            const $tbody = $('#classifieds-table tbody');
            const $paginationInfo = $('#pagination-info');
            const $paginationButtons = $('#pagination-buttons');
            


            let rateOptions = [];
            let currentPage = 1;
            let pageSize = 10;

            initRowsPerPage({
                targetSelector: '.filter-row-classifieds',
                defaultSize: pageSize,
                onChange: function(newSize) {
                    pageSize = newSize;
                    currentPage = 1;
                    loadClassifieds();
                }
            });

            function loadRateOptions(callback) {
                $.ajax({
                    url: '/ctb-admin/new/classifieds/rates',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function(rates) {
                        rateOptions = rates || [];
                        const $select = $('#rate_type');
                        $select.empty();
                        rateOptions.forEach(r => {
                            const title = r.title || r.name || 'Rate Option';
                            const amount = r.rate_amount ? Math.round(r.rate_amount) : '';
                            const days = r.days || '';
                            let details = '';
                            if (amount && days) {
                                details = ` ($${amount} / ${days} Days)`;
                            } else if (amount) {
                                details = ` ($${amount})`;
                            }
                            $select.append(`<option value="${r.id}" data-amount="${amount}" data-days="${days}">${title}${details}</option>`);
                        });
                        if (callback) callback();
                    },
                    error: function() {
                        console.error('Failed to load rate options from DB.');
                        if (callback) callback();
                    }
                });
            }

            function formatDate(dateStr) {
                if (!dateStr) return '';
                if (dateStr.includes('T')) {
                    dateStr = dateStr.split('T')[0];
                }
                const date = new Date(dateStr + 'T00:00:00');
                if (isNaN(date.getTime())) return dateStr;
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
            }

            function updateStats(stats) {
                if (!stats) return;
                $('#stat-pending').text(stats.pending);
                
                // Update notification banner count
                if (stats.pending > 0) {
                    $('#pending-alert-text').text(`${stats.pending} ad${stats.pending > 1 ? 's are' : ' is'} pending review. New submissions require approval before going live.`);
                    $('#pending-alert-banner').css('display', 'flex');
                } else {
                    $('#pending-alert-banner').hide();
                }

                $('#stat-active').text(stats.active);
                $('#stat-expiring').text(stats.expiring);
                $('#stat-revenue').text('$' + Math.round(stats.revenue).toLocaleString());
                
                const now = new Date();
                const currentMonthName = now.toLocaleString('default', { month: 'long' });
                const currentYear = now.getFullYear();
                $('#stat-revenue-month-label').text(`${currentMonthName} ${currentYear}`);
            }

            function toggleClearFiltersButton() {
                const searchVal = $searchInput.val().trim();
                const statusVal = $('#filter-status').val();
                const catVal = $('#filter-category').val();
                const dateVal = $('#filter-date-range').val();

                const isApplied = (searchVal !== '') || (statusVal !== 'all') || (catVal !== 'all') || (dateVal !== 'all');

                if (isApplied) {
                    $('#btn-clear-filters').css('display', 'inline-flex');
                } else {
                    $('#btn-clear-filters').css('display', 'none');
                }
            }

            function loadClassifieds() {
                toggleClearFiltersButton();
                $tbody.html(`<tr><td class="as-classifieds-63" colspan="9"><i class="bi bi-arrow-repeat spin as-classifieds-64"></i> Loading classifieds...</td></tr>`);

                $.ajax({
                    url: '/api/classifieds',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    data: {
                        search: $searchInput.val().trim(),
                        status: $statusFilter.val(),
                        category: $categoryFilter.val(),
                        date_range: $dateRangeFilter.val(),
                        page: currentPage,
                        limit: pageSize
                    },
                    success: function(res) {
                        updateStats(res.stats);
                        renderClassifieds(res.data, res.pagination);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching classifieds:', error);
                        $tbody.html(`<tr><td class="as-classifieds-65" colspan="10">Failed to load classifieds. Please try again.</td></tr>`);
                    }
                });
            }

            function renderClassifieds(data, pagination) {
                const todayStr = new Date().toISOString().split('T')[0];
                $tbody.empty();

                if (!data || data.length === 0) {
                    $tbody.append(`<tr><td class="as-classifieds-63" colspan="9">No classified ads found</td></tr>`);
                    $paginationInfo.text('Showing 0 to 0 of 0 entries');
                    renderPaginationButtons(1, 1);
                    return;
                }

                data.forEach(ad => {
                    let endsOnStr = ad.ends_on;
                    if (endsOnStr && endsOnStr.includes('T')) endsOnStr = endsOnStr.split('T')[0];
                    let startsOnStr = ad.starts_on;
                    if (startsOnStr && startsOnStr.includes('T')) startsOnStr = startsOnStr.split('T')[0];

                    const isExpired = endsOnStr && endsOnStr < todayStr;
                    const isPending = ad.status === 'Pending';
                    
                    let displayStatus = ad.status;
                    let badgeClass = 'status-pill status-inactive';
                    if (isExpired && ad.status === 'Active') {
                        displayStatus = 'Expired';
                        badgeClass = 'status-pill status-expired';
                    } else if (ad.status === 'Active') {
                        badgeClass = 'status-pill status-active';
                    } else if (ad.status === 'Pending') {
                        badgeClass = 'status-pill status-pending';
                    }

                    const displayStart = formatDate(ad.starts_on) || '—';
                    const displayEnd = formatDate(ad.ends_on) || '—';
                    
                    let paymentBadgeStyle = '';
                    const pStatus = ad.payment_status || 'Pending Payment';
                    if (pStatus === 'Paid (via GHL)') {
                        paymentBadgeStyle = 'background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 700; display: inline-block; white-space: nowrap;';
                    } else if (pStatus === 'Pending Payment') {
                        paymentBadgeStyle = 'background-color: #fffbeb; color: #b45309; border: 1px solid #fef3c7; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 700; display: inline-block; white-space: nowrap;';
                    } else if (pStatus === 'Invoiced') {
                        paymentBadgeStyle = 'background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 700; display: inline-block; white-space: nowrap;';
                    } else if (pStatus === 'Complimentary') {
                        paymentBadgeStyle = 'background-color: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 700; display: inline-block; white-space: nowrap;';
                    }
                    
                    let startSubText = ad.starts_on ? '<div class="as-classifieds-66">Start</div>' : '';
                    let endSubText = '';
                    if (endsOnStr) {
                        if (isExpired) {
                            endSubText = '<div class="as-classifieds-67">Expired</div>';
                        } else {
                            const diffTime = Math.abs(new Date(endsOnStr + 'T00:00:00') - new Date(todayStr + 'T00:00:00'));
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                            if (diffDays === 0) {
                                endSubText = '<div class="as-classifieds-68">Expires today</div>';
                            } else {
                                endSubText = `<div class="as-classifieds-69">Expires in ${diffDays} days</div>`;
                            }
                        }
                    }

                    const categoryTag = ad.category ? ad.category.toUpperCase() : 'JOBS';
                    const orgName = ad.organization_name || '';
                    const headline = ad.title || '';
                    
                    const rowStyle = isPending ? 'background-color: #fffbeb !important;' : '';
                    const rowClass = isExpired ? 'text-muted-expired' : '';

                    const rowHtml = `
                        <tr style="${rowStyle}" class="${rowClass}">
                            <td>
                                <div class="as-classifieds-70">${headline}</div>
                            </td>
                            <td class="as-classifieds-71">${ad.category || 'Jobs'}</td>
                            <td>
                                <div class="as-classifieds-72">${ad.advertiser_email || '—'}</div>
                            </td>
                            <td class="as-classifieds-73">
                                <div class="as-classifieds-74">${displayStart}</div>
                                ${startSubText}
                            </td>
                            <td class="as-classifieds-73">
                                <div class="as-classifieds-74">${displayEnd}</div>
                                ${endSubText}
                            </td>
                            <td><span class="${badgeClass}">${displayStatus}</span></td>
                            <td><span style="${paymentBadgeStyle}">${pStatus}</span></td>
                            <td class="as-classifieds-75">${ad.rate_amount ? '$' + parseFloat(ad.rate_amount).toFixed(2) : '—'}</td>
                            <td class="as-classifieds-76">
                                <div class="dropdown table-dropdown-container">
                                    <button class="table-action-edit" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end as-classifieds-77">
                                        <li><a class="dropdown-item btn-edit-row as-classifieds-78" href="#" data-id="${ad.id}"><i class="bi bi-pencil as-classifieds-79"></i> Edit</a></li>
                                        <li><a class="dropdown-item btn-view-row as-classifieds-78" href="#" data-id="${ad.id}"><i class="bi bi-eye as-classifieds-79"></i> View</a></li>
                                        <li><a class="dropdown-item btn-delete-row as-classifieds-78" href="#" data-id="${ad.id}"><i class="bi bi-trash as-classifieds-79"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    `;
                    $tbody.append(rowHtml);
                });

                // Update Pagination info
                $paginationInfo.text(`Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total || 0} entries`);

                renderPaginationButtons(pagination.last_page, pagination.current_page);
            }

            function renderPaginationButtons(lastPage, currentPageNum) {
                $paginationButtons.empty();

                // Previous
                const $prevBtn = $('<button>').text('Previous');
                styleButton($prevBtn, currentPageNum === 1);
                if (currentPageNum > 1) {
                    $prevBtn.on('click', () => {
                        currentPage = currentPageNum - 1;
                        loadClassifieds();
                    });
                }
                $paginationButtons.append($prevBtn);

                // Page numbers
                const pages = [];
                const delta = 1;
                
                for (let i = 1; i <= lastPage; i++) {
                    if (i === 1 || i === lastPage || (i >= currentPageNum - delta && i <= currentPageNum + delta)) {
                        pages.push(i);
                    }
                }

                let last = 0;
                pages.forEach(page => {
                    if (last !== 0) {
                        if (page - last === 2) {
                            const $pageBtn = $('<button>').text(last + 1);
                            styleButton($pageBtn, false, currentPageNum === last + 1);
                            const tempVal = last + 1;
                            $pageBtn.on('click', () => {
                                currentPage = tempVal;
                                loadClassifieds();
                            });
                            $paginationButtons.append($pageBtn);
                        } else if (page - last > 2) {
                            const $ellipsis = $('<span>').text('...').css({
                                padding: '6px 12px',
                                color: '#94a3b8',
                                fontSize: '13px'
                              });
                            $paginationButtons.append($ellipsis);
                        }
                    }
                    
                    const $pageBtn = $('<button>').text(page);
                    styleButton($pageBtn, false, currentPageNum === page);
                    $pageBtn.on('click', () => {
                        currentPage = page;
                        loadClassifieds();
                    });
                    $paginationButtons.append($pageBtn);
                    
                    last = page;
                });

                // Next
                const $nextBtn = $('<button>').text('Next');
                styleButton($nextBtn, currentPageNum === lastPage);
                if (currentPageNum < lastPage) {
                    $nextBtn.on('click', () => {
                        currentPage = currentPageNum + 1;
                        loadClassifieds();
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
                        background: '#1c3a63',
                        color: '#ffffff',
                        borderColor: '#1c3a63',
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

            // Export current filtered rows to CSV (AJAX based)
            function exportCSV() {
                $.ajax({
                    url: '/api/classifieds',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    data: {
                        search: $searchInput.val().trim(),
                        status: $statusFilter.val(),
                        category: $categoryFilter.val(),
                        date_range: $dateRangeFilter.val(),
                        export: 1
                    },
                    success: function(filtered) {
                        if (!filtered || filtered.length === 0) {
                            alert('No matching records to export.');
                            return;
                        }

                        const headers = ["Status", "Category", "Organization Name", "Ad Headline", "Start Date", "End Date", "Advertiser Email", "Payment Status", "Rate", "Rate Amount", "Admin Notes"];
                        let csvRows = [headers.join(",")];
                        const todayStr = new Date().toISOString().split('T')[0];

                        filtered.forEach(ad => {
                            let endsOnStr = ad.ends_on || '';
                            if (endsOnStr && endsOnStr.includes('T')) endsOnStr = endsOnStr.split('T')[0];
                            let startsOnStr = ad.starts_on || '';
                            if (startsOnStr && startsOnStr.includes('T')) startsOnStr = startsOnStr.split('T')[0];

                            const isExpired = endsOnStr && endsOnStr < todayStr;
                            let displayStatus = ad.status;
                            if (isExpired && ad.status === 'Active') {
                                displayStatus = 'Expired';
                            }

                            const row = [
                                displayStatus,
                                ad.category || 'Jobs',
                                ad.organization_name || '',
                                ad.title || '',
                                startsOnStr,
                                endsOnStr,
                                ad.advertiser_email || '',
                                ad.payment_status || 'Pending Payment',
                                ad.rate_option ? ad.rate_option.rate : (ad.rate || ''),
                                ad.rate_option ? ad.rate_option.rate_amount : (ad.rate_amount || '0.00'),
                                ad.admin_notes || ''
                            ].map(val => {
                                let clean = String(val).replace(/"/g, '""');
                                return `"${clean}"`;
                            }).join(",");

                            csvRows.push(row);
                        });

                        const csvString = csvRows.join("\n");
                        const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement("a");
                        link.setAttribute("href", url);
                        const todayFormatted = new Date().toISOString().split('T')[0].replace(/-/g, '_');
                        link.setAttribute("download", `classifieds_export_${todayFormatted}.csv`);
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function() {
                        alert('Failed to export CSV. Please try again.');
                    }
                });
            }

            // Spinner CSS keyframes
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                `)
                .appendTo('head');



            // Listeners for filters
            let searchTimeout = null;
            $searchInput.on('input', () => {
                currentPage = 1;
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(loadClassifieds, 250);
            });
            $('#filter-status, #filter-category, #filter-date-range').on('change', () => {
                currentPage = 1;
                loadClassifieds();
            });
            $btnClearFilters.on('click', () => {
                $searchInput.val('');
                $('#filter-status').val('all');
                $('#filter-category').val('all');
                $('#filter-date-range').val('all');
                currentPage = 1;
                loadClassifieds();
            });

            $('#btn-export-csv').on('click', exportCSV);

            // Notification review now link trigger
            $('#btn-review-now').on('click', function(e) {
                e.preventDefault();
                $('#filter-status').val('pending').trigger('change');
            });

            // Modal elements
            const $modal = $('#classified-modal');
            const $modalContainer = $('#modal-container');
            const $modalTitle = $('#modal-title');
            const $modalErrorBanner = $('#modal-error-banner');
            const $form = $('#classified-form');
            const $bodyTextarea = $('#body');
            const $wordCountBadge = $('#word-count-badge');
            const $rateType = $('#rate_type');
            const $btnDelete = $('#btn-delete-classified');
            const $btnSave = $('#btn-save-classified');

            function openModal() {
                $modal.css('display', 'flex');
                setTimeout(() => {
                    $modal.addClass('modal-open');
                }, 10);
            }

            function closeModal() {
                $modal.removeClass('modal-open');
                setTimeout(() => {
                    $modal.css('display', 'none');
                    resetForm();
                }, 300);
            }

            function resetForm() {
                $form[0].reset();
                $('#classified_id').val('');
                const firstCatVal = $('#category option:first').val();
                $('#category').val(firstCatVal || '');
                const firstRateVal = $('#rate_type option:first').val();
                $rateType.val(firstRateVal || '').trigger('change');
                $('#ad_rate_amount').val('');
                $('#payment_status').val('Pending Payment');
                $modalErrorBanner.hide().html('');
                $btnDelete.hide();
                $('.error-msg').remove();
                $('input, select, textarea').css('border-color', '#cbd5e1');
                updateWordCount();
            }

            function getWordCount(text) {
                const words = text.trim().split(/\s+/).filter(Boolean);
                return words.length;
            }

            function updateWordCount() {
                const text = $bodyTextarea.val() || '';
                const count = getWordCount(text);
                $wordCountBadge.text(`${count} / 100 words`);
                if (count > 100) {
                    $wordCountBadge.css('color', '#ef4444');
                } else {
                    $wordCountBadge.css('color', '#64748b');
                }
            }

            $bodyTextarea.on('input keyup', updateWordCount);

            function calculateExpiration() {
                const selectedOpt = $rateType.find('option:selected');
                const days = parseInt(selectedOpt.attr('data-days')) || 0;
                const startVal = $('#starts_on').val();

                if (startVal && days > 0) {
                    const startDate = new Date(startVal + 'T00:00:00');
                    if (!isNaN(startDate.getTime())) {
                        startDate.setDate(startDate.getDate() + days - 1);
                        const year = startDate.getFullYear();
                        const month = String(startDate.getMonth() + 1).padStart(2, '0');
                        const day = String(startDate.getDate()).padStart(2, '0');
                        $('#ends_on').val(`${year}-${month}-${day}`);
                    }
                }
            }

            // Auto-fill Rate ($) & calculate End Date on Ad Duration change
            $rateType.on('change', function() {
                const selectedOpt = $(this).find('option:selected');
                const amt = selectedOpt.attr('data-amount');
                if (amt !== undefined && amt !== null && amt !== '') {
                    $('#ad_rate_amount').val(amt);
                }
                calculateExpiration();
            });

            $('#starts_on').on('change input', calculateExpiration);

            $('#btn-add-classified').on('click', () => {
                resetForm();
                $modalTitle.text('Add Classified Ad');
                openModal();
            });

            $('#btn-close-modal, #btn-cancel-modal').on('click', closeModal);

            $tbody.on('click', '.btn-edit-row', function() {
                const adId = $(this).data('id');
                resetForm();
                $modalTitle.text('Edit Classified Ad');
                $btnSave.prop('disabled', true).text('Loading...');

                openModal();

                $.ajax({
                    url: '/api/classifieds/' + adId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function(ad) {
                        $btnSave.prop('disabled', false).text('Save');
                        $('#classified_id').val(ad.id);
                        $('#status').val(ad.status);
                        $('#category').val(ad.category || $('#category option:first').val());
                        $('#organization_name').val(ad.organization_name);
                        $('#title').val(ad.title);
                        $bodyTextarea.val(ad.body);
                        $('#link_url').val(ad.link_url || '');

                        let startsOn = ad.starts_on;
                        if (startsOn && startsOn.includes('T')) startsOn = startsOn.split('T')[0];
                        let endsOn = ad.ends_on;
                        if (endsOn && endsOn.includes('T')) endsOn = endsOn.split('T')[0];
                        
                        $('#starts_on').val(startsOn);
                        $('#ends_on').val(endsOn);
                        $('#advertiser_email').val(ad.advertiser_email);
                        $('#first_name').val(ad.first_name || '');
                        $('#last_name').val(ad.last_name || '');
                        $('#phone_number').val(ad.phone_number || '');
                        $('#payment_status').val(ad.payment_status || 'Pending Payment');
                        $('#admin_notes').val(ad.admin_notes || '');

                        // Sync Rates
                        const rateId = ad.classified_rate_id;
                        const rateAmount = ad.rate_amount !== undefined && ad.rate_amount !== null ? ad.rate_amount : 0;

                        if (rateId && $('#rate_type option[value="' + rateId + '"]').length > 0) {
                            $rateType.val(rateId);
                        }
                        $('#ad_rate_amount').val(rateAmount);

                        $btnDelete.show();
                        updateWordCount();
                    },
                    error: function(xhr) {
                        $btnSave.prop('disabled', false).text('Save');
                        closeModal();
                        alert('Failed to load classified ad details.');
                    }
                });
            });

            // Form Submit (Create / Update)
            $form.on('submit', function(e) {
                e.preventDefault();
                $modalErrorBanner.hide().html('');
                $('.error-msg').remove();
                $('input, select, textarea').css('border-color', '#cbd5e1');

                let isValid = true;
                const requiredFields = [
                    { id: 'first_name', label: 'First Name' },
                    { id: 'last_name', label: 'Last Name' },
                    { id: 'phone_number', label: 'Phone Number' },
                    { id: 'status', label: 'Status' },
                    { id: 'category', label: 'Category' },
                    { id: 'organization_name', label: 'Organization Name' },
                    { id: 'title', label: 'Ad Headline / Title' },
                    { id: 'body', label: 'Ad Body Text', type: 'body' },
                    { id: 'starts_on', label: 'Start Date' },
                    { id: 'ends_on', label: 'End Date' },
                    { id: 'advertiser_email', label: 'Advertiser Email', type: 'email' },
                    { id: 'ad_rate_amount', label: 'Rate ($)' }
                ];

                requiredFields.forEach(f => {
                    const $el = $('#' + f.id);
                    const val = $el.val() ? $el.val().trim() : '';
                    if (!val) {
                        showError($el, 'This field is required.');
                        isValid = false;
                    } else if (f.type === 'email' && !validateEmail(val)) {
                        showError($el, 'Please enter a valid email.');
                        isValid = false;
                    } else if (f.type === 'body') {
                        const wordCount = getWordCount(val);
                        if (wordCount > 100) {
                            showError($el, `Maximum 100 words allowed. (Current: ${wordCount})`);
                            isValid = false;
                        }
                    }
                });

                const linkVal = $('#link_url').val().trim();
                if (linkVal && !validateUrl(linkVal)) {
                    showError($('#link_url'), 'Please enter a valid URL (including http:// or https://).');
                    isValid = false;
                }

                const startVal = $('#starts_on').val();
                const endVal = $('#ends_on').val();
                if (startVal && endVal && new Date(startVal) > new Date(endVal)) {
                    showError($('#ends_on'), 'End Date must be on or after Start Date.');
                    isValid = false;
                }

                if (!isValid) {
                    showModalError('Please fix the highlighted errors below.');
                    return;
                }

                const rateAmountVal = parseFloat($('#ad_rate_amount').val()) || 0.00;
                const adId = $('#classified_id').val();
                const payload = {
                    status: $('#status').val(),
                    category: $('#category').val(),
                    organization_name: $('#organization_name').val().trim(),
                    title: $('#title').val().trim(),
                    body: $bodyTextarea.val().trim(),
                    link_url: linkVal || null,
                    starts_on: startVal,
                    ends_on: endVal,
                    advertiser_email: $('#advertiser_email').val().trim(),
                    first_name: $('#first_name').val().trim() || null,
                    last_name: $('#last_name').val().trim() || null,
                    phone_number: $('#phone_number').val().trim() || null,
                    payment_status: $('#payment_status').val(),
                    classified_rate_id: $('#rate_type').val(),
                    rate_amount: rateAmountVal,
                    admin_notes: $('#admin_notes').val().trim() || null
                };

                $btnSave.prop('disabled', true).text('Saving...');
                const method = adId ? 'PUT' : 'POST';
                const url = adId ? '/api/classifieds/' + adId : '/api/classifieds';

                $.ajax({
                    url: url,
                    method: method,
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(payload),
                    success: function() {
                        closeModal();
                        loadClassifieds();
                    },
                    error: function(xhr) {
                        $btnSave.prop('disabled', false).text('Save');
                        let errMsg = 'Failed to save classified ad.';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            let errorList = '<ul class="as-classifieds-80">';
                            Object.keys(errors).forEach(k => {
                                errorList += `<li>${errors[k].join(' ')}</li>`;
                                if (k === 'body') showError($bodyTextarea, errors[k].join(' '));
                                else if (k === 'rate') showError($customRateText, errors[k].join(' '));
                                else if (k === 'rate_amount') showError($customRateAmount, errors[k].join(' '));
                                else showError($('#' + k), errors[k].join(' '));
                            });
                            errorList += '</ul>';
                            errMsg = `<b>Validation errors:</b><br/>${errorList}`;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        showModalError(errMsg);
                    }
                });
            });

            // Delete Action
            $btnDelete.on('click', () => {
                const adId = $('#classified_id').val();
                if (!adId) return;

                if (confirm('Are you sure you want to delete this classified ad? This action cannot be undone.')) {
                    $btnDelete.prop('disabled', true).text('Deleting...');
                    $btnSave.prop('disabled', true);

                    $.ajax({
                        url: '/api/classifieds/' + adId,
                        method: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + apiToken,
                            'Accept': 'application/json'
                        },
                        success: function() {
                            closeModal();
                            loadClassifieds();
                        },
                        error: function(xhr) {
                            $btnDelete.prop('disabled', false).html('<i class="bi bi-trash"></i> Delete');
                            $btnSave.prop('disabled', false);
                            alert('Failed to delete classified ad.');
                        }
                    });
                }
            });

            let adIdToDelete = null;

            $tbody.on('click', '.btn-delete-row', function(e) {
                e.preventDefault();
                adIdToDelete = $(this).data('id');
                const $cModal = $('#confirm-modal');
                $cModal.css('display', 'flex');
                setTimeout(() => $cModal.css('opacity', '1'), 10);
            });

            $('#btn-cancel-delete').on('click', function() {
                const $cModal = $('#confirm-modal');
                $cModal.css('opacity', '0');
                setTimeout(() => $cModal.css('display', 'none'), 200);
                adIdToDelete = null;
            });

            $('#btn-confirm-delete').on('click', function() {
                if (!adIdToDelete) return;
                const $btn = $(this);
                $btn.prop('disabled', true).text('Deleting...');
                
                $.ajax({
                    url: '/api/classifieds/' + adIdToDelete,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function() {
                        $('#btn-cancel-delete').click();
                        $btn.prop('disabled', false).text('Delete');
                        loadClassifieds();
                    },
                    error: function() {
                        $('#btn-cancel-delete').click();
                        $btn.prop('disabled', false).text('Delete');
                        alert('Failed to delete classified ad.');
                    }
                });
            });

            // View row logic
            $tbody.on('click', '.btn-view-row', function(e) {
                e.preventDefault();
                const adId = $(this).data('id');
                const $vModal = $('#view-modal');
                $('#view-modal-content').html('<div class="as-classifieds-81">Loading...</div>');
                $vModal.css('display', 'flex');
                setTimeout(() => $vModal.css('opacity', '1'), 10);

                $.ajax({
                    url: '/api/classifieds/' + adId,
                    method: 'GET',
                    headers: { 'Authorization': 'Bearer ' + apiToken, 'Accept': 'application/json' },
                    success: function(ad) {
                        const fields = [
                            // Advertiser Info
                            { key: 'first_name', label: 'First Name' },
                            { key: 'last_name', label: 'Last Name' },
                            { key: 'organization_name', label: 'Organization Name' },
                            { key: 'advertiser_email', label: 'Advertiser Email' },
                            { key: 'phone_number', label: 'Phone Number' },
                            { key: 'link_url', label: 'Link URL' },

                            // Ad Info
                            { key: 'title', label: 'Headline / Title' },
                            { key: 'category', label: 'Category' },
                            { key: 'status', label: 'Ad Status' },
                            { key: 'payment_status', label: 'Payment Status' },
                            { key: 'starts_on', label: 'Start Date' },
                            { key: 'ends_on', label: 'End Date' },
                            { key: 'rate_amount', label: 'Rate Amount ($)' },
                            
                            // Timestamps
                            { key: 'created_at', label: 'Created At' },
                            { key: 'updated_at', label: 'Updated At' },

                            // Full width content at the bottom
                            { key: 'body', label: 'Ad Body Text' },
                            { key: 'admin_notes', label: 'Admin Notes' }
                        ];

                        let html = '<div class="as-classifieds-82">';
                        fields.forEach((f) => {
                            let val = ad[f.key];
                            if (val === null || val === undefined || val === '') val = '<span class="as-classifieds-83">-</span>';
                            
                            // Make body and notes full width
                            const isFullWidth = (f.key === 'body' || f.key === 'admin_notes');
                            const gridCol = isFullWidth ? 'grid-column: span 2;' : '';

                            html += `
                            <div class="as-classifieds-84" style="${gridCol}">
                                <div class="as-classifieds-85">${f.label}</div>
                                <div class="as-classifieds-86">${val}</div>
                            </div>`;
                        });
                        html += '</div>';
                        $('#view-modal-content').html(html);
                    },
                    error: function() {
                        $('#view-modal-content').html('<div class="as-classifieds-87">Failed to load details.</div>');
                    }
                });
            });

            $('#btn-close-view-modal').on('click', function() {
                const $vModal = $('#view-modal');
                $vModal.css('opacity', '0');
                setTimeout(() => $vModal.css('display', 'none'), 200);
            });

            function showError($el, msg) {
                $el.css('border-color', '#ef4444');
                $el.after(`<div class="error-msg as-classifieds-88">${msg}</div>`);
            }

            function validateEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            function validateUrl(url) {
                return /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(url);
            }

            function showModalError(msg) {
                $modalErrorBanner.html(msg).slideDown(200);
                $('#classified-modal').animate({ scrollTop: 0 }, 200);
            }

            // Run initial load (load rate options first, then classified ads)
            loadRateOptions(function() {
                loadClassifieds();
            });
        });
    </script>
@endsection
