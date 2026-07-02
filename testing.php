<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscriptions Dashboard</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    

    <style>
        :root {
            --primary-color: #1b5bf7;
            --primary-hover: #154cd2;
            --bg-light: #f8f9fc;
            --border-color: #e3e8ee;
            --text-dark: #212529;
            --text-muted: #64748b;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        body {
            background: var(--bg-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Dashboard Content Wrapper */
        .dashboard-content {
            padding: 40px 24px;
            max-width: 1500px;
            width: 100%;
            margin: 0 auto;
        }

        .dashboard-title {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .dashboard-subtitle {
            font-size: 13px;
        }

        /* Subscriptions Card */
        .card-subscriptions {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-top: 24px;
        }

        /* Filters Bar */
        .filters-bar-container {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .filters-left, .filters-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .date-range-picker-container {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 12px;
            background: #ffffff;
        }

        .status-filter-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 36px 6px 12px;
            font-size: 13px;
            color: #334155;
            background-color: #ffffff;
            outline: none;
            cursor: pointer;
            min-width: 140px;
            height: 38px;
            box-shadow: none;
        }
        .status-filter-select:focus {
            border-color: var(--primary-color);
            box-shadow: none;
        }

        .calendar-icon {
            color: var(--text-muted);
            margin-right: 8px;
            font-size: 14px;
        }

        .date-input {
            border: none;
            outline: none;
            font-size: 13px;
            width: 100px;
            color: var(--text-dark);
        }

        .date-separator {
            color: var(--text-muted);
            padding: 0 8px;
            font-size: 12px;
        }

        .search-input-container {
            position: relative;
            width: 240px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .search-input {
            width: 100%;
            padding: 6px 12px 6px 36px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            border-color: var(--primary-color);
        }

        .btn-filter-action {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
        }

        .btn-filter-action:hover {
            background: #f8fafc;
        }

        .btn-filter-icon-action {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            transition: background-color 0.2s;
        }

        .btn-filter-icon-action:hover {
            background: #f8fafc;
        }

        /* Custom Table Design */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 12px;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .table-custom tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Avatars */
        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
            flex-shrink: 0;
        }

        /* Status Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .status-active {
            background-color: #e6f4ea;
            color: #137333;
        }

        .status-canceled {
            background-color: #fff3cd;
            color: #b25e00;
        }

        .status-pending {
            background-color: #f1f5f9;
            color: #475569;
        }

        .btn-action-trigger {
            background: none;
            border: none;
            color: #64748b;
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .btn-action-trigger:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .small-info-icon {
            font-size: 12px;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s;
        }
        .small-info-icon:hover {
            color: var(--primary-color);
        }

        /* DataTable Custom overrides */
        .dataTables_wrapper .dataTables_info {
            padding: 16px 20px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 16px 20px;
        }

        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter {
            display: none; /* Hide default DT controls */
        }

        /* Pagination Overrides */
        .pagination {
            margin-bottom: 0;
            gap: 4px;
        }

        .page-item .page-link {
            border-radius: 6px !important;
            border: 1px solid var(--border-color);
            color: #475569;
            font-size: 13px;
            padding: 6px 12px;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
        }

        .page-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            border-radius: 8px;
            padding: 4px;
        }

        .dropdown-item {
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 6px;
        }
        .dropdown-item.active, .dropdown-item:active{
            text-decoration: none;
            background-color: transparent;
            border: none;
        }
    </style>
</head>
<body>

<div class="dashboard-content">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h1 class="dashboard-title">Subscriptions</h1>
            <p class="dashboard-subtitle text-muted mb-0">Keep track of customer subscriptions (<span id="totalSubs" class="fw-semibold text-dark">0</span> total)</p>
        </div>
    </div>

    <!-- Main Subscription Card -->
    <div class="card-subscriptions">
        <!-- Filters Bar -->
        <div class="filters-bar-container">
            <div class="filters-left">
                <div class="date-range-picker-container">
                    <i class="bi bi-calendar3 calendar-icon"></i>
                    <input type="text" id="startDateInput" class="date-input" placeholder="Start Date" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">
                    <span class="date-separator"><i class="bi bi-arrow-right"></i></span>
                    <input type="text" id="endDateInput" class="date-input" placeholder="End Date" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">
                </div>
                <select id="statusFilterSelect" class="form-select status-filter-select">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="canceled">Canceled</option>
                    <option value="paused">Paused</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div class="filters-right">
                <div class="search-input-container">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="customSearchInput" class="search-input" placeholder="Search">
                </div>
                <button class="btn btn-filter-icon-action" id="btnRefresh" title="Refresh Table">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        </div>

        <!-- Table Loading State -->
        <div id="loader" class="py-5 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading subscriptions...</p>
        </div>

        <!-- Subscription Data Table -->
        <div class="table-responsive">
            <table id="subscriptionTable" class="table table-custom w-100" style="display:none;">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th style="width: 50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamically Populated -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {

    let table;

    function loadSubscriptions() {
        $('#loader').show();
        $('#subscriptionTable').hide();
        
        if (table) {
            table.destroy();
        }

        fetch('https://app.californiatargetbook.com/api/ghl/public-subscriptions')
        .then(response => response.json())
        .then(data => {

            let rows = '';

            document.getElementById('totalSubs').innerText = data.stats.total_subs;

            data.subscriptions.forEach(sub => {

                let statusBadge = getStatusBadge(sub.status);
                let initials = getInitials(sub.user_name);
                let avatarColorStyle = getAvatarColorStyle(sub.user_name);
                let formattedDate = formatCreatedDate(sub.created_at);
                let amount = getAmount(sub);
                let provider = getProvider(sub.payment_method);
                
                let actionItems = '';
                let statusLower = (sub.status || '').toLowerCase();
                
                if (statusLower === 'active') {
                    actionItems = `
                        <li>
                            <a class="dropdown-item text-warning"
                            href="javascript:void(0)"
                            onclick="cancelSubscription('${sub.stripe_sub_id}')">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancel Subscription
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger"
                            href="javascript:void(0)"
                            onclick="pausedSubscription('${sub.stripe_sub_id}')">
                                <i class="bi bi-pause-circle me-2"></i>
                                Pause Subscription
                            </a>
                        </li>
                    `;
                } else if (statusLower === 'paused') {
                    actionItems = `
                        <li>
                            <a class="dropdown-item text-warning"
                            href="javascript:void(0)"
                            onclick="cancelSubscription('${sub.stripe_sub_id}')">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancel Subscription
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-success"
                            href="javascript:void(0)"
                            onclick="resumeSubscription('${sub.stripe_sub_id}')">
                                <i class="bi bi-play-circle me-2"></i>
                                Resume Subscription
                            </a>
                        </li>
                    `;
                } else {
                    actionItems = `
                        <li>
                            <span class="dropdown-item text-muted disabled">
                                <i class="bi bi-info-circle me-2"></i>No actions available
                            </span>
                        </li>
                    `;
                }
                
                rows += `
                <tr>
                    <td>${sub.user_name}</td>
                    <td>${sub.user_email}</td>
                    <td>${sub.frequency}</td>
                    <td>${formatDateOnly(sub.start_date)}</td>
                    <td>${formatDateOnly(sub.end_date)}</td>
                    <td>${statusBadge}</td>
                    <td>${sub.created_at}</td>

                    <td>
                        <div class="dropdown">

                            <button
                                class="btn btn-sm btn-light border"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                ${actionItems}
                            </ul>

                        </div>
                    </td>

                </tr>
                `;
            });

            $('#subscriptionTable tbody').html(rows);

            $('#loader').hide();
            $('#subscriptionTable').show();

            table = $('#subscriptionTable').DataTable({
                pageLength: 25,
                responsive: true,
                scrollX: true,
                order: [[6, 'desc']], // Sort by Created Date column (index 6)
                dom: 'rtip', // Hide default DT search and length controls
                language: {
                    paginate: {
                        previous: "<i class='bi bi-chevron-left'></i> Prev",
                        next: "Next <i class='bi bi-chevron-right'></i>"
                    }
                }
            });

        })
        .catch(error => {
            $('#loader').html(`
                <div class="alert alert-danger mx-3 my-3">
                    Failed to load subscriptions.
                </div>
            `);
            console.error(error);
        });
    }

    loadSubscriptions();

    // Bind custom search
    $('#customSearchInput').on('keyup', function() {
        if (table) {
            table.search(this.value).draw();
        }
    });

    // Bind date range filter
    $('#startDateInput, #endDateInput').on('change', function() {
        if (table) {
            table.draw();
        }
    });

    // Bind status filter dropdown
    $('#statusFilterSelect').on('change', function() {
        if (table) {
            table.draw();
        }
    });

    // Refresh button resets inputs and reloads
    $('#btnRefresh').on('click', function() {
        $('#startDateInput').val('').attr('type', 'text');
        $('#endDateInput').val('').attr('type', 'text');
        $('#customSearchInput').val('');
        $('#statusFilterSelect').val('');
        loadSubscriptions();
    });

});

// Helper functions for UI mapping and styling
function formatDateOnly(dateStr) {
    if (!dateStr || dateStr === 'N/A') return 'N/A';
    return dateStr.trim().split(/\s+/)[0];
}
function getProvider(paymentMethod) {
    if (!paymentMethod) return 'Stripe';
    let pm = paymentMethod.toLowerCase();
    if (pm === 'stripe') return 'Stripe';
    if (pm === 'paypal') return 'PayPal';
    return paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);
}

function getInitials(name) {
    if (!name || name === 'N/A') return '??';
    let cleanName = name.replace(/[^a-zA-Z0-9\s]/g, '').trim();
    if (!cleanName) return '??';
    let parts = cleanName.split(/\s+/);
    if (parts.length >= 2) {
        return (parts[0][0] + parts[1][0]).toUpperCase();
    }
    return parts[0].slice(0, 2).toUpperCase();
}

function getAvatarColorStyle(name) {
    if (!name) return 'background-color: #e2e8f0; color: #475569;';
    let colors = [
        { bg: '#fef3c7', text: '#b45309' }, // Amber
        { bg: '#e0f2fe', text: '#0369a1' }, // Sky
        { bg: '#dcfce7', text: '#15803d' }, // Green
        { bg: '#f3e8ff', text: '#7e22ce' }, // Purple
        { bg: '#ffe4e6', text: '#be123c' }, // Rose
        { bg: '#e0e7ff', text: '#4338ca' }, // Indigo
        { bg: '#f1f5f9', text: '#334155' }  // Slate
    ];
    let sum = 0;
    for (let i = 0; i < name.length; i++) {
        sum += name.charCodeAt(i);
    }
    let color = colors[sum % colors.length];
    return `background-color: ${color.bg}; color: ${color.text};`;
}

function formatCreatedDate(dateStr) {
    if (!dateStr || dateStr === 'N/A') return 'N/A';
    try {
        let parts = dateStr.trim().split(/\s+/);
        if (parts.length < 2) return dateStr;
        
        let dateParts = parts[0].split('-');
        let timeParts = parts[1].split(':');
        
        let monthIdx = parseInt(dateParts[1], 10) - 1;
        let day = parseInt(dateParts[2], 10);
        
        let hour = parseInt(timeParts[0], 10);
        let minute = parseInt(timeParts[1], 10);
        
        let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let month = months[monthIdx];
        
        let ampm = hour >= 12 ? 'PM' : 'AM';
        let displayHour = hour % 12;
        displayHour = displayHour ? displayHour : 12;
        
        let strMinute = minute < 10 ? '0' + minute : minute;
        let strHour = displayHour < 10 ? '0' + displayHour : displayHour;
        
        return `${month} ${day} at ${strHour}:${strMinute} ${ampm}`;
    } catch (e) {
        return dateStr;
    }
}

function getAmount(sub) {
    if (sub.user_name && sub.user_name.includes('Testing_@_9')) {
        return '$0.00';
    }
    let freq = (sub.frequency || '').toLowerCase();
    if (freq.includes('24') || freq.includes('24 month')) {
        return '$2,400.00';
    }
    if (freq.includes('12') || freq.includes('12 month')) {
        return '$1,200.00';
    }
    return '$1,200.00';
}

function getStatusBadge(status) {
    status = (status || '').toLowerCase();
    if (status === 'active') {
        return '<span class="status-badge status-active">Active</span>';
    } else if (status === 'expired' || status === 'cancelled' || status === 'canceled') {
        return '<span class="status-badge status-canceled">Canceled</span>';
    } else {
        return `<span class="status-badge status-pending">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
    }
}

// Custom Filtering function for DataTables (Date Range & Status)
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        // Status filter
        let selectedStatus = $('#statusFilterSelect').val();
        if (selectedStatus) {
            let statusCell = settings.aoData[dataIndex].anCells[5]; // index 5 is Status
            if (statusCell) {
                let statusText = statusCell.textContent.trim().toLowerCase();
                if (statusText !== selectedStatus) {
                    return false;
                }
            }
        }

        // Date Range filter
        let min = $('#startDateInput').val();
        let max = $('#endDateInput').val();
        
        let cell = settings.aoData[dataIndex].anCells[4]; // index 4 is End Date
        if (!cell) return true;
        let dateVal = cell.getAttribute('data-search') || cell.textContent.trim();
        
        if ((min || max) && (!dateVal || dateVal === 'N/A')) {
            return false;
        }
        
        if (dateVal && dateVal !== 'N/A') {
            let rowDateStr = dateVal.substring(0, 10);
            if (min && rowDateStr < min) {
                return false;
            }
            if (max && rowDateStr > max) {
                return false;
            }
        }
        return true;
    }
);

// Global action functions
window.cancelSubscription = function(stripeSubId) {
    if (!confirm('Are you sure you want to cancel this subscription?')) {
        return;
    }

    fetch(`https://app.californiatargetbook.com/api/ghl/subscriptions/${stripeSubId}/cancel`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || 'Subscription cancelled successfully.');
        location.reload();
    })
    .catch(error => {
        console.error(error);
        alert('Failed to cancel subscription.');
    });
};

window.pausedSubscription = function(stripeSubId) {
    if (!confirm('Are you sure you want to pause this subscription?')) {
        return;
    }

    fetch(`https://app.californiatargetbook.com/api/ghl/subscriptions/${stripeSubId}/pause`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || 'Subscription paused successfully.');
        location.reload();
    })
    .catch(error => {
        console.error(error);
        alert('Failed to pause subscription.');
    });
};

window.resumeSubscription = function(stripeSubId) {
    if (!confirm('Are you sure you want to resume this subscription?')) {
        return;
    }

    fetch(`https://app.californiatargetbook.com/api/ghl/subscriptions/${stripeSubId}/resume`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || 'Subscription resumed successfully.');
        location.reload();
    })
    .catch(error => {
        console.error(error);
        alert('Failed to resume subscription.');
    });
};
</script>

</body>
</html>