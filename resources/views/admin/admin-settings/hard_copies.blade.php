@extends('layouts.portal')

@section('portal_content')
    <div class="section-header" style="justify-content: space-between;">
        <div class="header-title-container">
            <h1 class="header-title">Hard Copy Subscriptions</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total Hard Copies</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-total">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #16a34a;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Active</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-active">-</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #ef4444;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Inactive</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;" id="stat-inactive">-</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card" style="padding: 0;">
        <div class="card-header-custom" style="display: flex; flex-direction: column; gap: 16px; padding: 20px 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; width: 100%;">
                <h2 class="card-title-custom" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Hard Copy List</h2>
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
                    </select>
                </div>
                <!-- Clear Filters Button -->
                <div style="padding-bottom: 2px;">
                    <button id="btn-clear-filters" onmouseenter="this.style.backgroundColor='#e2e8f0'" onmouseleave="this.style.backgroundColor='#f1f5f9'" style="height: 36px; background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 0 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease-in-out;">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table" id="hard-copies-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 25%;">Company</th>
                        <th style="width: 20%;">Contact</th>
                        <th style="width: 30%;">Address</th>
                        <th style="width: 25%;">Special Instructions</th>
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
@endsection

@section('portal_scripts')
    <script>
        $(document).ready(function () {
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
                const inactive = total - active;

                $('#stat-total').text(total);
                $('#stat-active').text(active);
                $('#stat-inactive').text(inactive);
            }

            function filterAndPaginate() {
                const searchVal = $searchInput.val().toLowerCase().trim();
                const statusVal = $statusFilter.val().toLowerCase();

                // 1. Get filtered list of rows
                const filteredRows = allHardCopies.filter(item => {
                    const sub = item.subscription || {};
                    const addr = item.address || {};
                    
                    const company = (sub.company || '').toLowerCase();
                    const status = sub.isActive ? 'active' : 'inactive';
                    const contactName = (sub.baseAccount ? sub.baseAccount.name : '').toLowerCase();
                    const specialInstructions = (addr.special_instructions || '').toLowerCase();
                    
                    const addrText = formatAddress(addr).toLowerCase();

                    const matchesSearch = company.includes(searchVal) || 
                                          addrText.includes(searchVal) || 
                                          contactName.includes(searchVal) || 
                                          specialInstructions.includes(searchVal);
                    const matchesStatus = statusVal === 'all' || status === statusVal;

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
                    $tbody.append(`<tr><td colspan="5" style="text-align: center; color: #64748b; padding: 24px;">No hard copy subscriptions found</td></tr>`);
                } else {
                    const pageRows = filteredRows.slice(startIndex, endIndex);
                    pageRows.forEach(item => {
                        const sub = item.subscription || {};
                        const addr = item.address || {};
                        
                        const statusStyle = sub.isActive ? '' : 'background-color: #fef2f2; color: #ef4444;';
                        const contactName = sub.baseAccount ? sub.baseAccount.name : 'Not Specified';
                        const specialInstructions = addr.special_instructions || '';
                        
                        const rowHtml = `
                            <tr class="clickable-row" data-id="${sub.id}" style="cursor: pointer;">
                                <td><span class="status-pill-completed" style="${statusStyle}">${sub.isActive ? 'Active' : 'Inactive'}</span></td>
                                <td class="fw-semibold" style="color: #0f172a !important;">${sub.company || 'Not Specified'}</td>
                                <td style="color: #0f172a !important; font-weight: 500;">${contactName}</td>
                                <td style="color: #475569;">${formatAddress(addr)}</td>
                                <td style="color: #64748b; font-style: italic; max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${specialInstructions}">${specialInstructions}</td>
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

            // Row click listener for redirect
            $tbody.on('click', 'tr.clickable-row', function(e) {
                // Prevent redirect if clicking on an anchor or button inside the row
                if ($(e.target).closest('a').length || $(e.target).closest('button').length) {
                    return;
                }
                const subId = $(this).data('id');
                if (subId) {
                    window.location.href = `/ctb-admin/new/subscriptions/${subId}`;
                }
            });

            // Load data from API
            $tbody.html(`<tr><td colspan="5" style="text-align: center; color: #64748b; padding: 24px;"><i class="bi bi-arrow-repeat spin" style="font-size: 20px; display: inline-block; animation: spin 1s linear infinite; margin-right: 8px;"></i> Loading hard copies...</td></tr>`);

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
                    allHardCopies = res.data || res;
                    updateStats(allHardCopies);
                    filterAndPaginate();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching hard copies:', error);
                    $tbody.html(`<tr><td colspan="5" style="text-align: center; color: #ef4444; padding: 24px;">Failed to load hard copy subscriptions. Please try again later.</td></tr>`);
                }
            });
        });
    </script>
@endsection
