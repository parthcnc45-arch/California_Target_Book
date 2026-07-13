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
    </style>
@endsection

@section('portal_content')
    <div class="section-header" style="justify-content: space-between;">
        <div class="header-title-container">
            <h1 class="header-title">Subscriptions</h1>
        </div>
        <a href="/ctb-admin/new/subscriptions/add" class="btn-add-subscription">
            <i class="bi bi-plus-lg"></i> ADD
        </a>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total Subscriptions</div>
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
                <h2 class="card-title-custom" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Subscribers List</h2>
                <div style="position: relative;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 14px;"></i>
                    <input type="text" class="form-input-style" id="search-subscribers" placeholder="Search companies or contacts..." style="padding-left: 36px; width: 300px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px;">
                </div>
            </div>
            
            <!-- Filters Row -->
            <div style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; width: 100%; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Status</span>
                    <select class="form-input-style" id="filter-status" style="width: 140px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Term</span>
                    <select class="form-input-style" id="filter-frequency" style="width: 140px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Terms</option>
                        <option value="0">Trial</option>
                        <option value="12">12 Months</option>
                        <option value="24">24 Months</option>
                    </select>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Starts On (From)</span>
                    <input type="date" class="form-input-style" id="filter-starts-on" style="width: 150px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff; color: #475569;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Ends On (To)</span>
                    <input type="date" class="form-input-style" id="filter-ends-on" style="width: 150px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff; color: #475569;">
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
            <table class="portal-grid-table" id="subscribers-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 25%;">Company</th>
                        <th style="width: 20%;">Contact</th>
                        <th style="width: 15%;">Term</th>
                        <th style="width: 15%;">Starts On</th>
                        <th style="width: 15%;">Ends On</th>
                        <th style="width: 90px; text-align: center;">Action</th>
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
            const $searchInput = $('#search-subscribers');
            const $statusFilter = $('#filter-status');
            const $frequencyFilter = $('#filter-frequency');
            const $startsOnFilter = $('#filter-starts-on');
            const $endsOnFilter = $('#filter-ends-on');
            const $btnClearFilters = $('#btn-clear-filters');
            const $tbody = $('#subscribers-table tbody');
            const $paginationInfo = $('#pagination-info');
            const $paginationButtons = $('#pagination-buttons');

            let allSubscriptions = [];
            let currentPage = 1;
            const pageSize = 10;

            function formatDate(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) return dateStr;
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const month = months[date.getMonth()];
                const day = date.getDate();
                let suffix = 'th';
                if (day === 1 || day === 21 || day === 31) suffix = 'st';
                else if (day === 2 || day === 22) suffix = 'nd';
                else if (day === 3 || day === 23) suffix = 'rd';
                return `${month} ${day}${suffix}, ${date.getFullYear()}`;
            }

            function formatFrequency(freq) {
                if (freq === 0) return 'Trial';
                if (freq === 12) return '12 Months';
                if (freq === 24) return '24 Months';
                return freq ? `${freq} Months` : '';
            }

            function updateStats(subs) {
                const total = subs.length;
                const active = subs.filter(s => s.isActive).length;
                const inactive = total - active;

                $('#stat-total').text(total);
                $('#stat-active').text(active);
                $('#stat-inactive').text(inactive);
            }

            function filterAndPaginate() {
                const searchVal = $searchInput.val().toLowerCase().trim();
                const statusVal = $statusFilter.val().toLowerCase();
                const freqVal = $frequencyFilter.val();
                const startsOnVal = $startsOnFilter.val();
                const endsOnVal = $endsOnFilter.val();

                // 1. Get filtered list of rows
                const filteredRows = allSubscriptions.filter(sub => {
                    const company = (sub.company || '').toLowerCase();
                    const name = (sub.baseAccount ? sub.baseAccount.name : '').toLowerCase();
                    const status = sub.isActive ? 'active' : 'inactive';
                    const startsOnStr = sub.cycle ? sub.cycle.starts_on : null;
                    const endsOnStr = sub.cycle ? sub.cycle.ends_on : null;

                    const matchesSearch = company.includes(searchVal) || name.includes(searchVal);
                    const matchesStatus = statusVal === 'all' || status === statusVal;
                    const matchesFrequency = freqVal === 'all' || String(sub.frequency) === freqVal;

                    let matchesDate = true;
                    if (startsOnVal && !endsOnVal) {
                        matchesDate = startsOnStr ? (startsOnStr === startsOnVal) : false;
                    } else if (!startsOnVal && endsOnVal) {
                        matchesDate = endsOnStr ? (endsOnStr === endsOnVal) : false;
                    } else if (startsOnVal && endsOnVal) {
                        matchesDate = (startsOnStr && endsOnStr) ? (startsOnStr >= startsOnVal && endsOnStr <= endsOnVal) : false;
                    }

                    return matchesSearch && matchesStatus && matchesFrequency && matchesDate;
                });

                // 2. Calculate pagination boundaries
                const totalEntries = filteredRows.length;
                const totalPages = Math.ceil(totalEntries / pageSize) || 1;
                
                // Adjust current page if out of bounds
                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }
                if (currentPage < 1) {
                    currentPage = 1;
                }

                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = Math.min(startIndex + pageSize, totalEntries);

                // 3. Render only rows for current page
                $tbody.empty();
                if (totalEntries === 0) {
                    $tbody.append(`<tr><td colspan="7" style="text-align: center; color: #64748b; padding: 24px;">No subscriptions found</td></tr>`);
                } else {
                    const pageRows = filteredRows.slice(startIndex, endIndex);
                    pageRows.forEach(sub => {
                        const statusStyle = sub.isActive ? '' : 'background-color: #fef2f2; color: #ef4444;';
                        const startsOnStr = sub.cycle ? sub.cycle.starts_on : null;
                        const endsOnStr = sub.cycle ? sub.cycle.ends_on : null;

                        const rowHtml = `
                            <tr>
                                <td><span class="status-pill-completed" style="${statusStyle}">${sub.isActive ? 'Active' : 'Inactive'}</span></td>
                                <td class="fw-semibold" style="color: #0f172a !important;">${sub.company || ''}</td>
                                <td><a href="#" style="color: #0f172a !important; font-weight: 600;">${sub.baseAccount ? sub.baseAccount.name : 'N/A'}</a></td>
                                <td style="color: #475569;">${formatFrequency(sub.frequency)}</td>
                                <td style="color: #475569;">${formatDate(startsOnStr)}</td>
                                <td style="color: #475569;">${formatDate(endsOnStr)}</td>
                                <td style="text-align: center;">
                                    <a href="/ctb-admin/new/subscriptions/${sub.id}" class="table-action-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
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
                const delta = 1; // Number of pages to show before and after current page
                
                for (let i = 1; i <= totalPages; i++) {
                    if (
                        i === 1 || // Always show first page
                        i === totalPages || // Always show last page
                        (i >= currentPage - delta && i <= currentPage + delta) // Show pages around current
                    ) {
                        pages.push(i);
                    }
                }

                // Render pages with ellipses
                let lastPage = 0;
                pages.forEach(page => {
                    if (lastPage !== 0) {
                        if (page - lastPage === 2) {
                            // If gap is exactly 1 page (e.g. between 1 and 3), fill it with page 2
                            const $pageBtn = $('<button>').text(lastPage + 1);
                            styleButton($pageBtn, false, currentPage === lastPage + 1);
                            const tempVal = lastPage + 1;
                            $pageBtn.on('click', () => {
                                currentPage = tempVal;
                                filterAndPaginate();
                            });
                            $paginationButtons.append($pageBtn);
                        } else if (page - lastPage > 2) {
                            // Add ellipsis span
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
            $('#filter-status, #filter-frequency, #filter-starts-on, #filter-ends-on').on('change', () => {
                currentPage = 1;
                filterAndPaginate();
            });
            if ($btnClearFilters.length) {
                $btnClearFilters.on('click', () => {
                    $searchInput.val('');
                    $('#filter-status').val('all');
                    $('#filter-frequency').val('all');
                    $('#filter-starts-on').val('');
                    $('#filter-ends-on').val('');
                    currentPage = 1;
                    filterAndPaginate();
                });
            }

            // Load data from API
            $tbody.html(`<tr><td colspan="7" style="text-align: center; color: #64748b; padding: 24px;"><i class="bi bi-arrow-repeat spin" style="font-size: 20px; display: inline-block; animation: spin 1s linear infinite; margin-right: 8px;"></i> Loading subscriptions...</td></tr>`);

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
                url: '/api/subscriptions',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + apiToken,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    allSubscriptions = res.data || res;
                    updateStats(allSubscriptions);
                    filterAndPaginate();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching subscriptions:', error);
                    $tbody.html(`<tr><td colspan="7" style="text-align: center; color: #ef4444; padding: 24px;">Failed to load subscriptions. Please try again later.</td></tr>`);
                }
            });
        });
    </script>
@endsection
