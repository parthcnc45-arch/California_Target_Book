@extends('layouts.portal')

@section('portal_styles')
    <style>
        .table-action-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            transition: all 0.15s ease-in-out;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            cursor: pointer;
        }
        .table-action-edit:hover {
            background-color: #f8fafc;
            color: #1e3a8a;
            border-color: #94a3b8;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            line-height: 1;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0;
        }
        .status-pending {
            background-color: #fefcbf;
            color: #b45309;
            border: 1px solid #fef08a;
        }
        .status-active {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .status-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        .status-expired {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }
        .text-muted-expired {
            opacity: 0.65;
        }
        .stats-card-classified {
            background: #ffffff !important;
            padding: 20px 24px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05) !important;
            margin-bottom: 0 !important;
            text-align: left !important;
        }
        
        /* Mobile responsive utilities */
        .stats-grid-classifieds {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 1024px) {
            .stats-grid-classifieds {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        @media (max-width: 768px) {
            .filter-row-classifieds {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .filter-row-classifieds > div {
                width: 100% !important;
                max-width: 100% !important;
            }
            .filter-row-classifieds select, .filter-row-classifieds input {
                width: 100% !important;
                max-width: 100% !important;
            }
            .filter-row-classifieds button {
                width: 100% !important;
                justify-content: center !important;
            }
        }
        @media (max-width: 576px) {
            .stats-grid-classifieds {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }
            .stats-card-classified {
                padding: 16px !important;
            }
            #classified-modal {
                padding: 12px !important;
            }
            .form-input-style {
                padding: 8px 10px !important;
            }
        }

        /* Custom modal animation styles */
        #classified-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 24px;
            transition: all 0.3s ease;
            opacity: 0;
        }
        #classified-modal.modal-open {
            opacity: 1;
        }
        #modal-container {
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        #classified-modal.modal-open #modal-container {
            transform: translateY(0);
        }
        
        .btn-export-csv {
            background-color: #ffffff;
            border: 1.5px solid #c52026;
            color: #c52026;
            padding: 8px 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-export-csv:hover {
            background-color: #fee2e2;
            color: #a91b21;
            border-color: #a91b21;
        }
    </style>
@endsection

@section('portal_content')
    <div class="section-header" style="justify-content: space-between; display: flex; align-items: center; margin-bottom: 24px;">
        <div class="header-title-container">
            <h1 class="header-title">Classifieds</h1>
        </div>
        <button type="button" id="btn-add-classified" class="btn-add-subscription" style="border: none; outline: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
            <i class="bi bi-plus-lg"></i> ADD
        </button>
    </div>

    <!-- Stats Grid Row -->
    <div class="stats-grid-classifieds">
        <!-- Card 1: Active Ads -->
        <div class="stats-card-classified">
            <div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.05em; text-transform: uppercase;">Active Ads</div>
                <div style="font-family: Georgia, serif; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 4px; line-height: 1;" id="stat-active">-</div>
                <div style="font-size: 11.5px; color: #94a3b8; margin-top: 6px;">Currently live</div>
            </div>
            <div style="width: 44px; height: 44px; background-color: #eff6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #1d4ed8; font-size: 20px;">
                <i class="bi bi-pencil-square"></i>
            </div>
        </div>

        <!-- Card 2: Pending Review -->
        <div class="stats-card-classified">
            <div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.05em; text-transform: uppercase;">Pending Review</div>
                <div style="font-family: Georgia, serif; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 4px; line-height: 1;" id="stat-pending">-</div>
                <div style="font-size: 11.5px; color: #94a3b8; margin-top: 6px;">Awaiting approval</div>
            </div>
            <div style="width: 44px; height: 44px; background-color: #fffbeb; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #b45309; font-size: 20px;">
                <i class="bi bi-clock"></i>
            </div>
        </div>

        <!-- Card 3: Expiring Soon -->
        <div class="stats-card-classified">
            <div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.05em; text-transform: uppercase;">Expiring Soon</div>
                <div style="font-family: Georgia, serif; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 4px; line-height: 1;" id="stat-expiring">-</div>
                <div style="font-size: 11.5px; color: #94a3b8; margin-top: 6px;">Within 3 days</div>
            </div>
            <div style="width: 44px; height: 44px; background-color: #fef2f2; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #b91c1c; font-size: 20px;">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
        </div>

        <!-- Card 4: Revenue -->
        <div class="stats-card-classified">
            <div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.05em; text-transform: uppercase;">Revenue (Month)</div>
                <div style="font-family: Georgia, serif; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 4px; line-height: 1;" id="stat-revenue">-</div>
                <div style="font-size: 11.5px; color: #94a3b8; margin-top: 6px;" id="stat-revenue-month-label">{{ date('F Y') }}</div>
            </div>
            <div style="width: 44px; height: 44px; background-color: #ecfeff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #0891b2; font-size: 20px;">
                <i class="bi bi-currency-dollar"></i>
            </div>
        </div>
    </div>

    <!-- Pending Alert Banner -->
    <div id="pending-alert-banner" style="display: none; background-color: #fffbeb; border: 1px solid #fef3c7; color: #b45309; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 13.5px; font-weight: 600; align-items: center; justify-content: space-between;">
        <div>
            <i class="bi bi-exclamation-circle-fill" style="margin-right: 8px; font-size: 15px;"></i>
            <span id="pending-alert-text">0 ads are pending review. New submissions require approval before going live.</span>
            <a href="#" id="btn-review-now" style="color: #b45309; text-decoration: underline; margin-left: 4px;">Review now &rarr;</a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="portal-card" style="padding: 0; margin-bottom: 32px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05);">
        <div class="card-header-custom" style="display: flex; flex-direction: column; gap: 16px; padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; width: 100%;">
                <h2 class="card-title-custom" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">All Classified Ads</h2>
            </div>
            
            <!-- Filters Row -->
            <div class="filter-row-classifieds" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; width: 100%;">
                <div style="position: relative; flex: 1; min-width: 200px; max-width: 320px;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 14px;"></i>
                    <input type="text" class="form-input-style" id="search-classifieds" placeholder="Search ads..." style="padding-left: 36px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px; width: 100%;">
                </div>
                
                <div>
                    <select class="form-input-style" id="filter-status" style="width: 140px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <div>
                    <select class="form-input-style" id="filter-category" style="width: 140px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Categories</option>
                        <option value="Jobs">Jobs</option>
                        <option value="Office Space">Office Space</option>
                        <option value="Consulting">Consulting</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <select class="form-input-style" id="filter-date-range" style="width: 140px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                        <option value="all">All Time</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                    </select>
                </div>

                <div style="margin-left: auto; display: flex; gap: 12px; align-items: center;">
                    <button id="btn-clear-filters" style="display: none; height: 36px; background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 0 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; align-items: center; gap: 6px; transition: all 0.15s ease-in-out;">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                    <button type="button" class="btn-export-csv" id="btn-export-csv" style="height: 36px; border: 1.5px solid #c52026; color: #c52026; background-color: #ffffff; padding: 0 16px; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease-in-out;">
                        <i class="bi bi-download"></i> Export CSV
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body-custom" style="overflow-x: auto;">
            <table class="portal-grid-table" id="classifieds-table" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th>Ad</th>
                        <th style="width: 110px;">Category</th>
                        <th style="width: 170px;">Advertiser</th>
                        <th style="width: 120px;">Start Date</th>
                        <th style="width: 135px;">End Date</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 130px;">Payment Status</th>
                        <th style="width: 100px;">Rate</th>
                        <th style="width: 60px; text-align: center; padding-right: 16px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS loaded data -->
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Footer -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-top: 1px solid #f1f5f9; background-color: #ffffff; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 13.5px; color: #64748b;" id="pagination-info">
                Showing 0 to 0 of 0 entries
            </div>
            <div style="display: flex; gap: 8px; align-items: center;" id="pagination-buttons">
                <!-- Pagination buttons -->
            </div>
        </div>
    </div>

    <!-- Modal Popup for Add/Edit Classified -->
    <div id="classified-modal">
        <div class="portal-card" style="width: 100%; max-width: 650px; max-height: calc(100vh - 48px); overflow-y: auto; padding: 0; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border-radius: 12px; background: #ffffff;" id="modal-container">
            <!-- Modal Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #e2e8f0; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h3 id="modal-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Add Classified Ad</h3>
                <button type="button" id="btn-close-modal" style="background: transparent; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center;"><i class="bi bi-x-lg"></i></button>
            </div>
            
            <!-- Error Banner -->
            <div id="modal-error-banner" style="display: none; background-color: #fef2f2; color: #ef4444; border-bottom: 1px solid #fca5a5; padding: 12px 24px; font-weight: 600; font-size: 13.0px; line-height: 1.5;"></div>

            <!-- Form -->
            <form id="classified-form" novalidate style="padding: 24px; display: flex; flex-direction: column; gap: 18px; margin: 0;">
                <input type="hidden" id="classified_id">

                <!-- Status & Category Select dropdowns -->
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label-style">Category *</label>
                        <select class="form-input-style" id="category" required>
                            <option value="Jobs" selected>Jobs</option>
                            <option value="Office Space">Office Space</option>
                            <option value="Consulting">Consulting</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label-style">Status *</label>
                        <select class="form-input-style" id="status" required>
                            <option value="Pending" selected>Pending</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Organization Name -->
                <div>
                    <label class="form-label-style">Organization Name *</label>
                    <input type="text" id="organization_name" class="form-input-style" placeholder="e.g. Department of Finance" required>
                </div>

                <!-- Ad Headline / Title -->
                <div>
                    <label class="form-label-style">Ad Headline / Title *</label>
                    <input type="text" id="title" class="form-input-style" placeholder="e.g. Senior Policy Analyst" required>
                </div>

                <!-- Ad Body Text -->
                <div>
                    <label class="form-label-style">Ad Body Text *</label>
                    <textarea id="body" class="form-input-style" placeholder="Ad description, salary, qualifications, how to apply..." style="height: 120px; padding: 10px 12px; resize: vertical;" required></textarea>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 4px;">
                        <span style="font-size: 12px; color: #64748b;" id="body-helper-text">Maximum 100 words.</span>
                        <span style="font-size: 12px; font-weight: 600; color: #64748b;" id="word-count-badge">0 / 100 words</span>
                    </div>
                </div>

                <!-- Link URL -->
                <div>
                    <label class="form-label-style">Link URL</label>
                    <input type="text" id="link_url" class="form-input-style" placeholder="https://...">
                </div>

                <!-- Start Date & End Date -->
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label-style">Start Date *</label>
                        <input type="date" id="starts_on" class="form-input-style" placeholder="mm/dd/yyyy" required>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label-style">End Date *</label>
                        <input type="date" id="ends_on" class="form-input-style" placeholder="mm/dd/yyyy" required>
                    </div>
                </div>

                <!-- Advertiser Email & Payment Status & Rate -->
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 180px;">
                        <label class="form-label-style">Advertiser Email *</label>
                        <input type="email" id="advertiser_email" class="form-input-style" placeholder="contact@org.com" required>
                    </div>
                    <div style="flex: 1; min-width: 180px;">
                        <label class="form-label-style">Payment Status *</label>
                        <select class="form-input-style" id="payment_status" required>
                            <option value="Paid (via GHL)" selected>Paid (via GHL)</option>
                            <option value="Pending Payment">Pending Payment</option>
                            <option value="Invoiced">Invoiced</option>
                            <option value="Complimentary">Complimentary</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 180px;">
                        <label class="form-label-style">Rate Options *</label>
                        <select class="form-input-style" id="rate_type" required>
                            <option value="weekly" selected>$165/week</option>
                            <option value="monthly">$585/month</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                </div>

                <!-- Custom Rate Input Row (hidden by default) -->
                <div id="custom-rate-row" style="display: none; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label-style" id="custom_rate_amount_label">Weekly Rate ($) *</label>
                        <input type="number" id="custom_rate_amount" class="form-input-style" placeholder="e.g. 250.00" min="0" step="0.01">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label-style">Custom Rate Type *</label>
                        <select class="form-input-style" id="custom_rate_type">
                            <option value="weekly" selected>Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                </div>

                <!-- Admin Notes -->
                <div>
                    <label class="form-label-style">Admin Notes</label>
                    <textarea id="admin_notes" class="form-input-style" placeholder="Internal notes (not shown publicly)..." style="height: 100px; padding: 10px 12px; resize: vertical;"></textarea>
                </div>

                <!-- Actions Button Row -->
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 8px;">
                    <button type="button" id="btn-delete-classified" style="display: none; background-color: #fef2f2; border: 1px solid #fca5a5; color: #ef4444; padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 13.5px; cursor: pointer; transition: all 0.15s ease-in-out; align-items: center; gap: 6px;">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                    <div style="display: flex; gap: 12px; margin-left: auto;">
                        <button type="button" id="btn-cancel-modal" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 10px 20px; border-radius: 6px; font-weight: 600; font-size: 13.5px; cursor: pointer; transition: all 0.15s ease-in-out;">Cancel</button>
                        <button type="submit" id="btn-save-classified" style="background-color: #4f46e5; border: none; color: #ffffff; padding: 10px 24px; border-radius: 6px; font-weight: 600; font-size: 13.5px; cursor: pointer; transition: all 0.15s ease-in-out;">Save</button>
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
            const pageSize = 8; // Screen lists 8 items in example page size.

            function loadRateOptions(callback) {
                $.ajax({
                    url: '/api/classifieds/rates/options',
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
                            $select.append(`<option value="${r.id}">${r.name}</option>`);
                        });
                        $select.append(`<option value="custom">Custom</option>`);
                        if (callback) callback();
                    },
                    error: function() {
                        console.error('Failed to load rate options from DB. Falling back.');
                        rateOptions = [
                            { id: 1, name: '$165/week', rate: '$165/wk', rate_amount: 165.00, type: 'weekly' },
                            { id: 2, name: '$585/month', rate: '$585/mo', rate_amount: 585.00, type: 'monthly' }
                        ];
                        const $select = $('#rate_type');
                        $select.empty();
                        $select.append(`<option value="1">$165/week</option>`);
                        $select.append(`<option value="2">$585/month</option>`);
                        $select.append(`<option value="custom">Custom</option>`);
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
                $tbody.html(`<tr><td colspan="9" style="text-align: center; color: #64748b; padding: 24px;"><i class="bi bi-arrow-repeat spin" style="font-size: 20px; display: inline-block; animation: spin 1s linear infinite; margin-right: 8px;"></i> Loading classifieds...</td></tr>`);

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
                        $tbody.html(`<tr><td colspan="10" style="text-align: center; color: #c52026; padding: 24px;">Failed to load classifieds. Please try again.</td></tr>`);
                    }
                });
            }

            function renderClassifieds(data, pagination) {
                const todayStr = new Date().toISOString().split('T')[0];
                $tbody.empty();

                if (!data || data.length === 0) {
                    $tbody.append(`<tr><td colspan="9" style="text-align: center; color: #64748b; padding: 24px;">No classified ads found</td></tr>`);
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

                    const displayStart = isPending ? '—' : formatDate(ad.starts_on);
                    const displayEnd = isPending ? '—' : formatDate(ad.ends_on);
                    
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
                    
                    let startSubText = isPending ? '' : '<div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Start</div>';
                    let endSubText = '';
                    if (!isPending && endsOnStr) {
                        if (isExpired) {
                            endSubText = '<div style="font-size: 11px; color: #ef4444; font-weight: 600; margin-top: 2px;">Expired</div>';
                        } else {
                            const diffTime = Math.abs(new Date(endsOnStr + 'T00:00:00') - new Date(todayStr + 'T00:00:00'));
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                            if (diffDays === 0) {
                                endSubText = '<div style="font-size: 11px; color: #d97706; font-weight: 600; margin-top: 2px;">Expires today</div>';
                            } else {
                                endSubText = `<div style="font-size: 11px; color: #64748b; margin-top: 2px;">Expires in ${diffDays} days</div>`;
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
                                <div style="font-size: 10px; font-weight: 700; color: #2E7D9A; text-transform: uppercase; margin-bottom: 2px;">${categoryTag}</div>
                                <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; line-height: 1.3;">${headline}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">${orgName}</div>
                            </td>
                            <td style="color: #475569; font-weight: 500; font-size: 13px;">${ad.category || 'Jobs'}</td>
                            <td>
                                <div style="font-size: 13px; font-weight: 600; color: #0f172a;">${ad.advertiser_email || '—'}</div>
                            </td>
                            <td style="color: #475569; font-size: 13px;">
                                <div style="font-weight: 600; color: #0f172a;">${displayStart}</div>
                                ${startSubText}
                            </td>
                            <td style="color: #475569; font-size: 13px;">
                                <div style="font-weight: 600; color: #0f172a;">${displayEnd}</div>
                                ${endSubText}
                            </td>
                            <td><span class="${badgeClass}">${displayStatus}</span></td>
                            <td><span style="${paymentBadgeStyle}">${pStatus}</span></td>
                            <td style="color: #0f172a; font-weight: 700; font-size: 13px;">${ad.rate_option ? ad.rate_option.rate : (ad.rate || '—')}</td>
                            <td style="text-align: center; padding-right: 16px;">
                                <button class="table-action-edit btn-edit-row" data-id="${ad.id}">
                                    <i class="bi bi-three-dots"></i>
                                </button>
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
            const $customRateRow = $('#custom-rate-row');
            const $customRateText = $('#custom_rate_text');
            const $customRateAmount = $('#custom_rate_amount');
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
                $('#category').val('Jobs');
                $('#payment_status').val('Pending Payment');
                $modalErrorBanner.hide().html('');
                $customRateRow.hide();
                $customRateAmount.val('');
                $('#custom_rate_type').val('weekly');
                $('#custom_rate_amount_label').text('Weekly Rate ($) *');
                $('#custom_rate_amount').attr('placeholder', 'e.g. 250.00');
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

            // Toggle custom rate details
            $rateType.on('change', function() {
                if ($(this).val() === 'custom') {
                    $customRateRow.css('display', 'flex');
                    $('#custom_rate_type').trigger('change');
                } else {
                    $customRateRow.hide();
                    $customRateText.val('');
                    $customRateAmount.val('');
                }
            });

            // Toggle label based on custom rate type
            $('#custom_rate_type').on('change', function() {
                if ($(this).val() === 'weekly') {
                    $('#custom_rate_amount_label').text('Weekly Rate ($) *');
                    $('#custom_rate_amount').attr('placeholder', 'e.g. 250.00');
                } else {
                    $('#custom_rate_amount_label').text('Monthly Rate ($) *');
                    $('#custom_rate_amount').attr('placeholder', 'e.g. 500.00');
                }
            });

            $('#btn-add-classified').on('click', () => {
                resetForm();
                $modalTitle.text('Add Classified Ad');
                openModal();
            });

            $('#btn-close-modal, #btn-cancel-modal').on('click', closeModal);
            $modal.on('click', function(e) {
                if (e.target === this) closeModal();
            });

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
                        $('#category').val(ad.category || 'Jobs');
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
                        $('#payment_status').val(ad.payment_status || 'Pending Payment');
                        $('#admin_notes').val(ad.admin_notes || '');

                        // Sync Rates
                        const rateId = ad.classified_rate_id;
                        const rate = ad.rate;
                        const rateAmount = ad.rate_amount || 0;
                        const standardIds = [1, 2];

                        if (rateId && standardIds.includes(rateId)) {
                            $rateType.val(rateId);
                            $customRateRow.hide();
                        } else {
                            // Custom or legacy matching
                            $rateType.val('custom');
                            $customRateAmount.val(rateAmount || '');
                            
                            // Determine type based on rateOption or ad rate text
                            let cType = 'weekly';
                            if (ad.rate_option) {
                                cType = ad.rate_option.type;
                            } else {
                                const isWeekly = rate && (rate.includes('/wk') || rate.toLowerCase().includes('week'));
                                cType = isWeekly ? 'weekly' : 'monthly';
                            }
                            
                            $('#custom_rate_type').val(cType);
                            if (cType === 'weekly') {
                                $('#custom_rate_amount_label').text('Weekly Rate ($) *');
                                $('#custom_rate_amount').attr('placeholder', 'e.g. 250.00');
                            } else {
                                $('#custom_rate_amount_label').text('Monthly Rate ($) *');
                                $('#custom_rate_amount').attr('placeholder', 'e.g. 500.00');
                            }

                            $customRateRow.css('display', 'flex');
                        }

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
                    { id: 'status', label: 'Status' },
                    { id: 'category', label: 'Category' },
                    { id: 'organization_name', label: 'Organization Name' },
                    { id: 'title', label: 'Ad Headline / Title' },
                    { id: 'body', label: 'Ad Body Text', type: 'body' },
                    { id: 'starts_on', label: 'Start Date' },
                    { id: 'ends_on', label: 'End Date' },
                    { id: 'advertiser_email', label: 'Advertiser Email', type: 'email' }
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

                // Custom Rate validations
                if ($rateType.val() === 'custom') {
                    const custAmt = $customRateAmount.val().trim();
                    if (!custAmt) {
                        showError($customRateAmount, 'This field is required.');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    showModalError('Please fix the highlighted errors below.');
                    return;
                }

                // Compute rates
                let rateAmountVal = 0.00;
                let rateIdVal = null;
                const rType = $rateType.val();
                
                if (rType === 'custom') {
                    rateAmountVal = parseFloat($customRateAmount.val()) || 0.00;
                    rateIdVal = 'custom';
                } else {
                    const matchedOption = rateOptions.find(o => String(o.id) === String(rType));
                    if (matchedOption) {
                        rateIdVal = matchedOption.id;
                    }
                }

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
                    payment_status: $('#payment_status').val(),
                    classified_rate_id: rateIdVal,
                    custom_rate_amount: rType === 'custom' ? rateAmountVal : null,
                    custom_rate_type: rType === 'custom' ? $('#custom_rate_type').val() : null,
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
                            let errorList = '<ul style="margin:0; padding-left: 20px;">';
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

            function showError($el, msg) {
                $el.css('border-color', '#ef4444');
                $el.after(`<div class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; font-weight: 500;">${msg}</div>`);
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
