@extends('layouts.portal')

@section('portal_styles')
    <style>
        #contacts-table tbody tr.clickable-row {
            cursor: pointer;
            transition: background-color 0.15s ease;
        }
        #contacts-table tbody tr.clickable-row:hover {
            background-color: #f8fafc;
        }
    </style>
@endsection

@section('portal_content')
    <div class="section-header" style="justify-content: space-between;">
        <div class="header-title-container">
            <h1 class="header-title">Contacts</h1>
        </div>
        <button class="btn-export-csv">
            <i class="bi bi-download"></i> EXPORT
        </button>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total Contacts</div>
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
                <h2 class="card-title-custom" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Contact List</h2>
                <div style="position: relative;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 14px;"></i>
                    <input type="text" class="form-input-style" id="search-contacts" placeholder="Search contacts, emails or companies..." style="padding-left: 36px; width: 300px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px;">
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
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 12.5px; font-weight: 600; color: #475569;">Role</span>
                    <select class="form-input-style" id="filter-role" style="width: 150px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Roles</option>
                        <option value="subscriber">Subscriber</option>
                        <option value="editor">Editor</option>
                        <option value="admin">Admin</option>
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
            <table class="portal-grid-table" id="contacts-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 25%;">Company</th>
                        <th style="width: 15%;">Role</th>
                        <th style="width: 20%;">Subscribed On</th>
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
                Showing 1 to 5 of 8 entries
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
            const $searchInput = $('#search-contacts');
            const $statusFilter = $('#filter-status');
            const $roleFilter = $('#filter-role');
            const $clearFiltersBtn = $('#btn-clear-filters');
            const $tbody = $('#contacts-table tbody');
            const $paginationInfo = $('#pagination-info');
            const $paginationButtons = $('#pagination-buttons');
            
            let allContacts = [];
            let currentPage = 1;
            const pageSize = 5;

            function formatDate(dateStr) {
                if (!dateStr) return 'N/A';
                const date = new Date(dateStr.replace(' ', 'T'));
                if (isNaN(date)) return dateStr;
                
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const month = months[date.getMonth()];
                const day = date.getDate();
                
                let suffix = 'th';
                if (day === 1 || day === 21 || day === 31) suffix = 'st';
                else if (day === 2 || day === 22) suffix = 'nd';
                else if (day === 3 || day === 23) suffix = 'rd';
                
                return `${month} ${day}${suffix}, ${date.getFullYear()}`;
            }

            function updateStats(items) {
                const total = items.length;
                const active = items.filter(item => item.hasActiveSubscription).length;
                const inactive = total - active;

                $('#stat-total').text(total);
                $('#stat-active').text(active);
                $('#stat-inactive').text(inactive);
            }

            function filterAndPaginate() {
                const searchVal = $searchInput.val().toLowerCase().trim();
                const statusVal = $statusFilter.val().toLowerCase();
                const roleVal = $roleFilter.val().toLowerCase();

                // 1. Get filtered list of rows
                const filteredRows = allContacts.filter(item => {
                    const status = item.hasActiveSubscription ? 'active' : 'inactive';
                    const name = (item.name || '').toLowerCase();
                    const email = (item.email || '').toLowerCase();
                    const company = (item.company || '').toLowerCase();
                    const role = (item.role || '').toLowerCase();

                    const matchesSearch = name.includes(searchVal) || email.includes(searchVal) || company.includes(searchVal) || role.includes(searchVal);
                    const matchesStatus = statusVal === 'all' || status === statusVal;
                    const matchesRole = roleVal === 'all' || role === roleVal;

                    return matchesSearch && matchesStatus && matchesRole;
                });

                // 2. Calculate pagination boundaries
                const totalEntries = filteredRows.length;
                const totalPages = Math.ceil(totalEntries / pageSize) || 1;
                
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
                    $tbody.append(`<tr><td colspan="6" style="text-align: center; color: #64748b; padding: 24px;">No contacts found</td></tr>`);
                } else {
                    const pageRows = filteredRows.slice(startIndex, endIndex);
                    pageRows.forEach(item => {
                        const statusStyle = item.hasActiveSubscription ? '' : 'background-color: #fef2f2; color: #ef4444;';
                        const roleText = item.role ? item.role.charAt(0).toUpperCase() + item.role.slice(1) : 'Subscriber';
                        
                        const rowHtml = `
                            <tr class="clickable-row" data-id="${item.id}">
                                <td><span class="status-pill-completed" style="${statusStyle}">${item.hasActiveSubscription ? 'Active' : 'Inactive'}</span></td>
                                <td class="fw-semibold" style="color: #0f172a !important;">${item.name || 'Not Specified'}</td>
                                <td><a href="mailto:${item.email}" style="color: #0f172a !important;">${item.email}</a></td>
                                <td style="color: #0f172a !important;">${item.company || 'Not Specified'}</td>
                                <td style="color: #0f172a !important;">${roleText}</td>
                                <td style="color: #0f172a !important;">${formatDate(item.createdAt)}</td>
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
            if ($roleFilter.length) {
                $roleFilter.on('change', () => {
                    currentPage = 1;
                    filterAndPaginate();
                });
            }
            if ($clearFiltersBtn.length) {
                $clearFiltersBtn.on('click', () => {
                    $searchInput.val('');
                    $statusFilter.val('all');
                    $roleFilter.val('all');
                    currentPage = 1;
                    filterAndPaginate();
                });
            }

            // Export to CSV functionality
            $('.btn-export-csv').on('click', function() {
                if (!allContacts || allContacts.length === 0) {
                    alert('No contacts available to export.');
                    return;
                }

                // Headers
                const headers = ['Name', 'Email', 'Company', 'Is Active'];
                
                // Rows
                const rows = allContacts.map(u => [
                    u.name || '',
                    u.email || '',
                    u.company || '',
                    u.hasActiveSubscription ? 'Yes' : 'No'
                ]);

                // Build CSV content
                let csvContent = headers.join(',') + '\n';
                rows.forEach(row => {
                    const escapedRow = row.map(val => {
                        let escaped = String(val).replace(/"/g, '""');
                        if (escaped.includes(',') || escaped.includes('"') || escaped.includes('\n')) {
                            escaped = `"${escaped}"`;
                        }
                        return escaped;
                    });
                    csvContent += escapedRow.join(',') + '\n';
                });

                // Download file
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const date = new Date();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                const yyyy = date.getFullYear();
                const filename = `ctb_contacts_${mm}-${dd}-${yyyy}.csv`;

                if (navigator.msSaveBlob) {
                    navigator.msSaveBlob(blob, filename);
                } else {
                    const link = document.createElement("a");
                    if (link.download !== undefined) {
                        const url = URL.createObjectURL(blob);
                        link.setAttribute("href", url);
                        link.setAttribute("download", filename);
                        link.style.visibility = 'hidden';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                }
            });

            // Row click listener to redirect to contact detail page
            $tbody.on('click', '.clickable-row', function(e) {
                // If clicked target is an anchor tag or inside one, do not redirect
                if (e.target.closest('a')) {
                    return;
                }
                const id = $(this).data('id');
                if (id) {
                    window.location.href = `/ctb-admin/new/contacts/${id}`;
                }
            });

            // Load data from API
            $tbody.html(`<tr><td colspan="6" style="text-align: center; color: #64748b; padding: 24px;"><i class="bi bi-arrow-repeat spin" style="font-size: 20px; display: inline-block; animation: spin 1s linear infinite; margin-right: 8px;"></i> Loading contacts...</td></tr>`);

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
                url: '/api/users',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + apiToken,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    allContacts = res.data || res;
                    updateStats(allContacts);
                    filterAndPaginate();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching contacts:', error);
                    $tbody.html(`<tr><td colspan="6" style="text-align: center; color: #ef4444; padding: 24px;">Failed to load contacts. Please try again later.</td></tr>`);
                }
            });
        });
    </script>
@endsection
