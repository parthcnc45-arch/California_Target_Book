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
        .password-input-wrapper input.input-invalid {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 1px #fecaca;
        }
        .password-input-wrapper input.input-valid {
            border-color: #86efac !important;
        }
        .field-hint {
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 5px;
            display: flex;
            justify-content: space-between;
        }
        .field-hint.hint-error {
            color: #ef4444;
        }
        .field-hint.hint-ok {
            color: #16a34a;
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
                        <th style="width: 15%;">Email</th>
                        <th style="width: 20%;">Company</th>
                        <th style="width: 15%;">Role</th>
                        <th style="width: 15%;">Subscribed On</th>
                        <th style="width: 120px; text-align: center;">Action</th>
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
    
    <div id="contactModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
      <div style="background:#fff; width:900px; max-width:95%; border-radius:8px; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.15); max-height:90vh; overflow-y:auto;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
              <div>
                  <div style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;" id="modal-role-label">SUBSCRIBER</div>
                  <h2 id="modal-name" style="font-size:24px; font-weight:700; color:#b91c1c; margin:0;">Name</h2>
              </div>
              <button type="button" onclick="$('#contactModal').css('display','none');" style="background:none; border:none; font-size:28px; cursor:pointer; color:#64748b;">&times;</button>
          </div>
          
          <div style="margin-top: 16px;">
              <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin-top:0; margin-bottom:24px;">Account</h3>
              
              <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px 64px;">
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Name</span>
                      <span id="modal-name-val" style="color:#0f172a; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Email</span>
                      <span id="modal-email" style="color:#b91c1c; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Subscribed On</span>
                      <span id="modal-subscribed-on" style="color:#0f172a; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Account Type</span>
                      <span id="modal-account-type" style="color:#0f172a; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Company</span>
                      <span id="modal-company" style="color:#b91c1c; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Phone Number</span>
                      <span id="modal-phone" style="color:#0f172a; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Stripe Customer ID</span>
                      <span id="modal-stripe-id" style="color:#b91c1c; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Account Id</span>
                      <span id="modal-account-id" style="color:#0f172a; font-size:14px; font-weight:500;"></span>
                  </div>
                  <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px;">
                      <span style="color:#475569; font-size:14px; font-weight:600;">Subscription ID</span>
                      <span id="modal-subscription-id" style="color:#b91c1c; font-size:14px; font-weight:500;"></span>
                  </div>
              </div>
              
              <div style="display:flex; justify-content:space-between; border-bottom:1px solid #e2e8f0; padding-bottom:12px; margin-top:24px;">
                  <span style="color:#475569; font-size:14px; font-weight:600; min-width:120px;">Notes</span>
                  <span id="modal-notes" style="color:#0f172a; font-size:14px; font-weight:500; text-align:right;">No notes available.</span>
              </div>
          </div>
      </div>
    </div>

    <!-- Change Password Modal -->
    <div id="change-password-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center;">
        <div class="modal-box" style="background: #ffffff; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); max-width: 440px; width: 100%; overflow: hidden; animation: modalFadeIn 0.2s ease-out; margin: 16px;">
            <div style="padding: 24px;">
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">Change Password</h3>
                <div style="font-size: 13.5px; font-weight: 600; color: #b91c1c; margin-bottom: 24px;" id="change-password-name">Subscriber</div>

                <form id="change-password-form" novalidate>
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Password *</label>
                        <div class="password-input-wrapper" style="position: relative;">
                            <input type="password" id="new-password" required minlength="6" maxlength="72" autocomplete="new-password" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 36px 8px 12px; box-sizing: border-box; font-size: 14px;">
                            <button type="button" class="toggle-password-visibility" data-target="new-password" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b; padding: 4px;">
                                <i class="bi bi-eye" style="font-size: 16px;"></i>
                            </button>
                        </div>
                        <div class="field-hint" id="password-hint">
                            <span id="password-hint-text">Minimum 6, maximum 72 characters</span>
                            <span id="password-char-count">0 / 72</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Password Confirmation *</label>
                        <div class="password-input-wrapper" style="position: relative;">
                            <input type="password" id="new-password-confirmation" required minlength="6" maxlength="72" autocomplete="new-password" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 36px 8px 12px; box-sizing: border-box; font-size: 14px;">
                            <button type="button" class="toggle-password-visibility" data-target="new-password-confirmation" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b; padding: 4px;">
                                <i class="bi bi-eye" style="font-size: 16px;"></i>
                            </button>
                        </div>
                        <div class="field-hint" id="confirmation-hint" style="display: none;"></div>
                    </div>

                    <div id="modal-error-message" style="color: #ef4444; font-size: 13px; margin-bottom: 16px; display: none; background: #fef2f2; border: 1px solid #fecaca; padding: 10px; border-radius: 6px;"></div>
                    <div id="modal-success-message" style="color: #16a34a; font-size: 13px; margin-bottom: 16px; display: none; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px; border-radius: 6px;"></div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
                        <button type="button" id="btn-cancel-password" style="background: none; border: none; color: #64748b; font-weight: 600; font-size: 13px; padding: 8px 16px; cursor: pointer; text-transform: uppercase; border-radius: 4px; transition: background 0.15s;">CANCEL</button>
                        <button type="submit" id="btn-submit-password" style="background: #b91c1c; border: 1px solid #b91c1c; color: #ffffff; font-weight: 600; font-size: 13px; padding: 8px 20px; cursor: pointer; text-transform: uppercase; border-radius: 6px; transition: opacity 0.15s;">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Account Modal -->
    <div id="edit-account-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center;">
        <div class="modal-box" style="background: #ffffff; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); max-width: 520px; width: 100%; overflow: hidden; animation: modalFadeIn 0.2s ease-out; margin: 16px;">
            <div style="padding: 24px;">
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 20px 0;">Update Account</h3>

                <form id="edit-account-form" novalidate>
                    <div style="display: flex; gap: 16px; margin-bottom: 18px;">
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">First Name *</label>
                            <input type="text" id="edit-first-name" required maxlength="255" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Last Name</label>
                            <input type="text" id="edit-last-name" maxlength="255" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                    </div>

                    <div style="display: flex; gap: 16px; margin-bottom: 18px;">
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Email *</label>
                            <input type="email" id="edit-email" required maxlength="255" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Phone Number</label>
                            <input type="text" id="edit-phone-number" maxlength="30" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Notes</label>
                        <textarea id="edit-notes" rows="3" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px; resize: vertical; font-family: inherit;"></textarea>
                    </div>

                    <div id="edit-modal-error-message" style="color: #ef4444; font-size: 13px; margin-bottom: 16px; display: none; background: #fef2f2; border: 1px solid #fecaca; padding: 10px; border-radius: 6px;"></div>
                    <div id="edit-modal-success-message" style="color: #16a34a; font-size: 13px; margin-bottom: 16px; display: none; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px; border-radius: 6px;"></div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
                        <button type="button" id="btn-cancel-edit-account" style="background: none; border: none; color: #64748b; font-weight: 600; font-size: 13px; padding: 8px 16px; cursor: pointer; text-transform: uppercase; border-radius: 4px; transition: background 0.15s;">CANCEL</button>
                        <button type="submit" id="btn-submit-edit-account" style="background: #b91c1c; border: 1px solid #b91c1c; color: #ffffff; font-weight: 600; font-size: 13px; padding: 8px 20px; cursor: pointer; text-transform: uppercase; border-radius: 6px; transition: opacity 0.15s;">SAVE</button>
                    </div>
                </form>
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
                    $tbody.append(`<tr><td colspan="7" style="text-align: center; color: #64748b; padding: 24px;">No contacts found</td></tr>`);
                } else {
                    const pageRows = filteredRows.slice(startIndex, endIndex);
                    pageRows.forEach(item => {
                        const statusStyle = item.hasActiveSubscription ? '' : 'background-color: #fef2f2; color: #ef4444;';
                        const roleText = item.role ? item.role.charAt(0).toUpperCase() + item.role.slice(1) : 'Subscriber';
                        
                        const rowHtml = `
                            <tr data-id="${item.id}">
                                <td><span class="status-pill-completed" style="${statusStyle}">${item.hasActiveSubscription ? 'Active' : 'Inactive'}</span></td>
                                <td class="fw-semibold" style="color: #0f172a !important;">${item.name || 'Not Specified'}</td>
                                <td><a href="mailto:${item.email}" style="color: #0f172a !important;">${item.email}</a></td>
                                <td style="color: #0f172a !important;">${item.company || 'Not Specified'}</td>
                                <td style="color: #0f172a !important;">${roleText}</td>
                                <td style="color: #0f172a !important;">${formatDate(item.createdAt)}</td>
                                <td style="text-align: center;">
                                    <a href="javascript:void(0)" class="action-icon view-contact-btn" data-id="${item.id}" style="color: #64748b; margin-right: 12px; font-size: 16px;" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="javascript:void(0)" class="action-icon edit-contact-btn" data-id="${item.id}" style="color: #64748b; margin-right: 12px; font-size: 16px;" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="action-icon change-password-btn" data-id="${item.id}" style="color: #64748b; font-size: 16px;" title="Change Password"><i class="bi bi-key"></i></a>
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
                    const $link = $('<a>', {
                        href: URL.createObjectURL(blob),
                        download: filename
                    }).hide().appendTo('body');
                    if ($link[0].download !== undefined) {
                        $link[0].click();
                        $link.remove();
                    }
                }
            });

            // View Contact Modal Logic
            $tbody.on('click', '.view-contact-btn', function() {
                const id = $(this).data('id');
                
                // Show loading state first
                $('#modal-role-label').text('LOADING...');
                $('#modal-name').text('Loading...');
                $('#modal-name-val, #modal-email, #modal-subscribed-on, #modal-account-type, #modal-company, #modal-phone, #modal-stripe-id, #modal-account-id, #modal-subscription-id, #modal-notes').text('...');
                $('#contactModal').css('display', 'flex');

                $.ajax({
                    url: `/api/users/${id}`,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function(res) {
                        let contact = res.data || res;
                        const roleText = contact.role ? contact.role.charAt(0).toUpperCase() + contact.role.slice(1) : 'Subscriber';
                        
                        // Build full name
                        let fullName = contact.name;
                        if (!fullName && (contact.first_name || contact.last_name)) {
                            fullName = [contact.first_name, contact.last_name].filter(Boolean).join(' ');
                        }

                        // Extract company name
                        let companyName = contact.company;
                        if (typeof contact.company === 'object' && contact.company !== null) {
                            companyName = contact.company.name;
                        }

                        // Extract subscription id
                        let subId = contact.subscriptionId || contact.subscription_id;
                        if (!subId && contact.subscriptions && contact.subscriptions.length > 0) {
                            subId = contact.subscriptions[contact.subscriptions.length - 1].id;
                        }

                        $('#modal-role-label').text(roleText.toUpperCase());
                        $('#modal-name').text(fullName || 'Not Specified');
                        $('#modal-name-val').text(fullName || 'Not Specified');
                        $('#modal-email').text(contact.email || 'N/A');
                        $('#modal-subscribed-on').text(formatDate(contact.createdAt || contact.created_at));
                        $('#modal-account-type').text(roleText);
                        $('#modal-company').text(companyName || 'Not Specified');
                        $('#modal-phone').text(contact.phone_number || contact.phone || 'N/A');
                        $('#modal-stripe-id').text(contact.stripe_id || contact.stripeCustomerId || contact.stripe_customer_id || 'N/A');
                        $('#modal-account-id').text(contact.id);
                        $('#modal-subscription-id').text(subId || 'N/A');
                        $('#modal-notes').text(contact.notes || 'No notes available.');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching contact details:', error);
                        $('#modal-name').text('Error loading details');
                        $('#modal-role-label').text('ERROR');
                        $('#modal-notes').text('Failed to load contact data. Please try again.');
                    }
                });
            });

            // Edit Account Modal Logic
            let currentEditContactId = null;
            const $editModal = $('#edit-account-modal');
            const $editForm = $('#edit-account-form');
            const $firstNameInput = $('#edit-first-name');
            const $lastNameInput = $('#edit-last-name');
            const $emailInput = $('#edit-email');
            const $phoneInput = $('#edit-phone-number');
            const $notesInput = $('#edit-notes');
            const $editErrorDiv = $('#edit-modal-error-message');
            const $editSuccessDiv = $('#edit-modal-success-message');
            const $editSubmitBtn = $('#btn-submit-edit-account');

            $tbody.on('click', '.edit-contact-btn', function() {
                const id = $(this).data('id');
                currentEditContactId = id;
                
                $editErrorDiv.hide().text('');
                $editSuccessDiv.hide().text('');
                
                // Show loading state by clearing inputs and disabling them briefly
                $firstNameInput.val('Loading...').prop('disabled', true);
                $lastNameInput.val('Loading...').prop('disabled', true);
                $emailInput.val('Loading...').prop('disabled', true);
                $phoneInput.val('Loading...').prop('disabled', true);
                $notesInput.val('Loading...').prop('disabled', true);
                $editSubmitBtn.prop('disabled', true);
                
                $editModal.css('display', 'flex');

                $.ajax({
                    url: `/api/users/${id}`,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function(res) {
                        let contact = res.data || res;

                        let fName = contact.first_name || '';
                        let lName = contact.last_name || '';
                        if (!fName && !lName && contact.name) {
                            let parts = contact.name.split(' ');
                            fName = parts[0];
                            lName = parts.slice(1).join(' ');
                        }

                        $firstNameInput.val(fName).prop('disabled', false);
                        $lastNameInput.val(lName).prop('disabled', false);
                        $emailInput.val(contact.email || '').prop('disabled', false);
                        $phoneInput.val(contact.phone_number || contact.phone || '').prop('disabled', false);
                        $notesInput.val(contact.notes || '').prop('disabled', false);
                        $editSubmitBtn.prop('disabled', false);
                        
                        $firstNameInput.focus();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching contact details for edit:', error);
                        $editErrorDiv.text('Failed to load contact data. Please try again.').show();
                        // Re-enable to allow cancel
                        $firstNameInput.prop('disabled', false).val('');
                        $lastNameInput.prop('disabled', false).val('');
                        $emailInput.prop('disabled', false).val('');
                        $phoneInput.prop('disabled', false).val('');
                        $notesInput.prop('disabled', false).val('');
                    }
                });
            });

            function closeEditModal() {
                $editModal.hide();
                $editErrorDiv.hide().text('');
                $editSuccessDiv.hide().text('');
            }

            $('#btn-cancel-edit-account').on('click', closeEditModal);

            $editForm.on('submit', function(e) {
                e.preventDefault();
                $editErrorDiv.hide().text('');
                $editSuccessDiv.hide().text('');

                const firstName = $firstNameInput.val().trim();
                const lastName = $lastNameInput.val().trim();
                const email = $emailInput.val().trim();
                const phoneNumber = $phoneInput.val().trim();
                const notes = $notesInput.val().trim();

                if (!firstName) {
                    $editErrorDiv.text('First Name is required.').show();
                    $firstNameInput.trigger('focus');
                    return;
                }

                if (!email) {
                    $editErrorDiv.text('Email is required.').show();
                    $emailInput.trigger('focus');
                    return;
                }

                $editSubmitBtn.prop('disabled', true).css('opacity', '0.6');

                $.ajax({
                    url: `/api/users/${currentEditContactId}`,
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        phone_number: phoneNumber,
                        notes: notes
                    }),
                    success: function(res) {
                        $editSuccessDiv.text('Account updated successfully.').show();
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $editSubmitBtn.prop('disabled', false).css('opacity', '1');
                        let errorMsg = 'Failed to update account. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errs = xhr.responseJSON.errors;
                            const firstErr = Object.keys(errs)[0];
                            errorMsg = errs[firstErr][0] || errorMsg;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        $editErrorDiv.text(errorMsg).show();
                    }
                });
            });

            // Change Password Modal Logic
            let currentPasswordContactId = null;
            const MIN_LEN = 6;
            const MAX_LEN = 72;
            const $pwdModal = $('#change-password-modal');
            const $pwdForm = $('#change-password-form');
            const $passwordInput = $('#new-password');
            const $confirmationInput = $('#new-password-confirmation');
            const $errorDiv = $('#modal-error-message');
            const $successDiv = $('#modal-success-message');
            const $submitBtn = $('#btn-submit-password');
            const $charCount = $('#password-char-count');
            const $passwordHintText = $('#password-hint-text');
            const $confirmationHint = $('#confirmation-hint');
            
            $tbody.on('click', '.change-password-btn', function() {
                const id = $(this).data('id');
                const contact = allContacts.find(c => String(c.id) === String(id));
                currentPasswordContactId = id;
                if(contact) {
                    let fullName = contact.name;
                    if (!fullName && (contact.first_name || contact.last_name)) {
                        fullName = [contact.first_name, contact.last_name].filter(Boolean).join(' ');
                    }
                    $('#change-password-name').text(fullName || 'Subscriber');
                }
                $pwdModal.css('display', 'flex');
                $passwordInput.focus();
            });

            function closePwdModal() {
                $pwdModal.hide();
                $passwordInput.val('').removeClass('input-invalid input-valid');
                $confirmationInput.val('').removeClass('input-invalid input-valid');
                $passwordInput.attr('type', 'password');
                $confirmationInput.attr('type', 'password');
                $('.toggle-password-visibility i').removeClass('bi-eye-slash').addClass('bi-eye');
                $errorDiv.hide().text('');
                $successDiv.hide().text('');
                $confirmationHint.hide().text('');
                $charCount.text('0 / ' + MAX_LEN);
                $passwordHintText.text('Minimum ' + MIN_LEN + ', maximum ' + MAX_LEN + ' characters').removeClass('hint-error hint-ok');
            }

            $('#btn-cancel-password').on('click', closePwdModal);

            $('.toggle-password-visibility').on('click', function() {
                const targetId = $(this).data('target');
                const $input = $('#' + targetId);
                const $icon = $(this).find('i');

                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('bi-eye').addClass('bi-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('bi-eye-slash').addClass('bi-eye');
                }
            });

            function validatePasswords() {
                const pass = $passwordInput.val();
                const conf = $confirmationInput.val();
                let isValid = true;

                $charCount.text(pass.length + ' / ' + MAX_LEN);

                if (pass.length === 0) {
                    $passwordInput.removeClass('input-invalid input-valid');
                    $passwordHintText.text('Minimum ' + MIN_LEN + ', maximum ' + MAX_LEN + ' characters').removeClass('hint-error hint-ok');
                } else if (pass.length < MIN_LEN) {
                    $passwordInput.addClass('input-invalid').removeClass('input-valid');
                    $passwordHintText.text('Too short — needs at least ' + MIN_LEN + ' characters').addClass('hint-error').removeClass('hint-ok');
                    isValid = false;
                } else if (pass.length > MAX_LEN) {
                    $passwordInput.addClass('input-invalid').removeClass('input-valid');
                    $passwordHintText.text('Too long — maximum is ' + MAX_LEN + ' characters').addClass('hint-error').removeClass('hint-ok');
                    isValid = false;
                } else {
                    $passwordInput.addClass('input-valid').removeClass('input-invalid');
                    $passwordHintText.text('Looks good').addClass('hint-ok').removeClass('hint-error');
                }

                if (conf.length === 0) {
                    $confirmationInput.removeClass('input-invalid input-valid');
                    $confirmationHint.hide().text('');
                } else if (pass !== conf) {
                    $confirmationInput.addClass('input-invalid').removeClass('input-valid');
                    $confirmationHint.show().text('Passwords do not match').removeClass('hint-ok').addClass('hint-error');
                    isValid = false;
                } else {
                    $confirmationInput.addClass('input-valid').removeClass('input-invalid');
                    $confirmationHint.show().text('Passwords match').removeClass('hint-error').addClass('hint-ok');
                }

                $errorDiv.hide().text('');
                return isValid;
            }

            $passwordInput.on('input', validatePasswords);
            $confirmationInput.on('input', validatePasswords);

            $pwdForm.on('submit', function(e) {
                e.preventDefault();
                $errorDiv.hide().text('');
                $successDiv.hide().text('');

                const password = $passwordInput.val();
                const confirmation = $confirmationInput.val();

                if (password.length < MIN_LEN) {
                    $errorDiv.text('Password must be at least ' + MIN_LEN + ' characters long.').show();
                    $passwordInput.trigger('focus');
                    return;
                }

                if (password.length > MAX_LEN) {
                    $errorDiv.text('Password must not exceed ' + MAX_LEN + ' characters.').show();
                    $passwordInput.trigger('focus');
                    return;
                }

                if (password !== confirmation) {
                    $errorDiv.text('Password and Password Confirmation do not match.').show();
                    $confirmationInput.trigger('focus');
                    return;
                }

                $submitBtn.prop('disabled', true).css('opacity', '0.6');

                $.ajax({
                    url: `/api/users/${currentPasswordContactId}/password`,
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        password: password,
                        password_confirmation: confirmation
                    }),
                    success: function(res) {
                        $successDiv.text('Password updated successfully.').show();
                        setTimeout(function() {
                            closePwdModal();
                            $submitBtn.prop('disabled', false).css('opacity', '1');
                        }, 1500);
                    },
                    error: function(xhr) {
                        $submitBtn.prop('disabled', false).css('opacity', '1');
                        let errorMsg = 'Failed to update password. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errs = xhr.responseJSON.errors;
                            const firstErr = Object.keys(errs)[0];
                            errorMsg = errs[firstErr][0] || errorMsg;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        $errorDiv.text(errorMsg).show();
                    }
                });
            });

            // Load data from API
            $tbody.html(`<tr><td colspan="7" style="text-align: center; color: #64748b; padding: 24px;"><i class="bi bi-arrow-repeat spin" style="font-size: 20px; display: inline-block; animation: spin 1s linear infinite; margin-right: 8px;"></i> Loading contacts...</td></tr>`);

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
                    $tbody.html(`<tr><td colspan="7" style="text-align: center; color: #ef4444; padding: 24px;">Failed to load contacts. Please try again later.</td></tr>`);
                }
            });
        });
    </script>
@endsection
