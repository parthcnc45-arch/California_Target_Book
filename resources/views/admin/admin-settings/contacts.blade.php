@extends('layouts.portal')



@section('portal_content')
    <div class="section-header as-contacts-1">
        <div class="header-title-container">
            <h1 class="header-title">Contacts</h1>
        </div>
        <button class="btn-export-csv">
            <i class="bi bi-download"></i> EXPORT
        </button>
    </div>

    <!-- Stats Row -->
    <div class="as-contacts-2">
        <div class="portal-card as-contacts-3">
            <div class="as-contacts-4">Total Contacts</div>
            <div class="as-contacts-5" id="stat-total">-</div>
        </div>
        <div class="portal-card as-contacts-6">
            <div class="as-contacts-4">Active</div>
            <div class="as-contacts-5" id="stat-active">-</div>
        </div>
        <div class="portal-card as-contacts-7">
            <div class="as-contacts-4">Inactive</div>
            <div class="as-contacts-5" id="stat-inactive">-</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card as-contacts-8">
        <div class="card-header-custom as-contacts-9">
            <div class="as-contacts-10">
                <h2 class="card-title-custom as-contacts-11">Contact List</h2>
                <div class="as-contacts-12">
                    <i class="bi bi-search as-contacts-13"></i>
                    <input type="text" class="form-input-style as-contacts-14" id="search-contacts" placeholder="Search contacts, emails or companies...">
                </div>
            </div>
            
            <!-- Filters Row -->
            <div class="as-contacts-15">
                <div class="as-contacts-16">
                    <span class="as-contacts-17">Status</span>
                    <select class="form-input-style as-contacts-18" id="filter-status">
                        <option value="all">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="as-contacts-16">
                    <span class="as-contacts-17">Role</span>
                    <select class="form-input-style as-contacts-18" id="filter-role">
                        <option value="all">All Roles</option>
                        <option value="subscriber">Subscriber</option>
                        <option value="editor">Editor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <!-- Clear Filters Button -->
                <div class="as-contacts-19">
                    <button class="as-contacts-20" id="btn-clear-filters" onmouseenter="this.style.backgroundColor='#e2e8f0'" onmouseleave="this.style.backgroundColor='#f1f5f9'">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table" id="contacts-table">
                <thead>
                    <tr>
                        <th class="as-contacts-21">Status</th>
                        <th class="as-contacts-22">Name</th>
                        <th class="as-contacts-23">Email</th>
                        <th class="as-contacts-22">Company</th>
                        <th class="as-contacts-23">Role</th>
                        <th class="as-contacts-23">Subscribed On</th>
                        <th class="as-contacts-24">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS loaded data will be injected here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Footer -->
        <div class="as-contacts-25">
            <div class="as-contacts-26" id="pagination-info">
                Showing 1 to 5 of 8 entries
            </div>
            <div class="as-contacts-27" id="pagination-buttons">
                <!-- Pagination buttons will be dynamically injected -->
            </div>
        </div>
    </div>
    
    <div class="as-contacts-28" id="contactModal">
      <div class="as-contacts-29">
          <div class="as-contacts-30">
              <div>
                  <div class="as-contacts-31" id="modal-role-label">SUBSCRIBER</div>
                  <h2 class="as-contacts-32" id="modal-name">Name</h2>
              </div>
              <button class="as-contacts-33" type="button" onclick="$('#contactModal').css('display','none');">&times;</button>
          </div>
          
          <div class="as-contacts-34">
              <h3 class="as-contacts-35">Account</h3>
              
              <div class="as-contacts-36">
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Name</span>
                      <span class="as-contacts-39" id="modal-name-val"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Email</span>
                      <span class="as-contacts-40" id="modal-email"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Subscribed On</span>
                      <span class="as-contacts-39" id="modal-subscribed-on"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Account Type</span>
                      <span class="as-contacts-39" id="modal-account-type"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Company</span>
                      <span class="as-contacts-40" id="modal-company"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Phone Number</span>
                      <span class="as-contacts-39" id="modal-phone"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Stripe Customer ID</span>
                      <span class="as-contacts-40" id="modal-stripe-id"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Account Id</span>
                      <span class="as-contacts-39" id="modal-account-id"></span>
                  </div>
                  <div class="as-contacts-37">
                      <span class="as-contacts-38">Subscription ID</span>
                      <span class="as-contacts-40" id="modal-subscription-id"></span>
                  </div>
              </div>
              
              <div class="as-contacts-41">
                  <span class="as-contacts-42">Notes</span>
                  <span class="as-contacts-43" id="modal-notes">No notes available.</span>
              </div>
          </div>
      </div>
    </div>

    <!-- Change Password Modal -->
    <div class="as-contacts-44" id="change-password-modal">
        <div class="modal-box as-contacts-45">
            <div class="as-contacts-46">
                <h3 class="as-contacts-47">Change Password</h3>
                <div class="as-contacts-48" id="change-password-name">Subscriber</div>

                <form id="change-password-form" novalidate>
                    <div class="as-contacts-49">
                        <label class="as-contacts-50">Password *</label>
                        <div class="password-input-wrapper as-contacts-12">
                            <input class="as-contacts-51" type="password" id="new-password" required minlength="6" maxlength="72" autocomplete="new-password">
                            <button type="button" class="toggle-password-visibility as-contacts-52" data-target="new-password">
                                <i class="bi bi-eye as-contacts-53"></i>
                            </button>
                        </div>
                        <div class="field-hint" id="password-hint">
                            <span id="password-hint-text">Minimum 6, maximum 72 characters</span>
                            <span id="password-char-count">0 / 72</span>
                        </div>
                    </div>

                    <div class="as-contacts-54">
                        <label class="as-contacts-50">Password Confirmation *</label>
                        <div class="password-input-wrapper as-contacts-12">
                            <input class="as-contacts-51" type="password" id="new-password-confirmation" required minlength="6" maxlength="72" autocomplete="new-password">
                            <button type="button" class="toggle-password-visibility as-contacts-52" data-target="new-password-confirmation">
                                <i class="bi bi-eye as-contacts-53"></i>
                            </button>
                        </div>
                        <div class="field-hint as-contacts-55" id="confirmation-hint"></div>
                    </div>

                    <div class="as-contacts-56" id="modal-error-message"></div>
                    <div class="as-contacts-57" id="modal-success-message"></div>

                    <div class="as-contacts-58">
                        <button class="as-contacts-59" type="button" id="btn-cancel-password">CANCEL</button>
                        <button class="as-contacts-60" type="submit" id="btn-submit-password">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Account Modal -->
    <div class="as-contacts-44" id="edit-account-modal">
        <div class="modal-box as-contacts-61">
            <div class="as-contacts-46">
                <h3 class="as-contacts-62">Update Account</h3>

                <form id="edit-account-form" novalidate>
                    <div class="as-contacts-63">
                        <div class="as-contacts-64">
                            <label class="as-contacts-50">First Name *</label>
                            <input class="as-contacts-65" type="text" id="edit-first-name" required maxlength="255">
                        </div>
                        <div class="as-contacts-64">
                            <label class="as-contacts-50">Last Name</label>
                            <input class="as-contacts-65" type="text" id="edit-last-name" maxlength="255">
                        </div>
                    </div>

                    <div class="as-contacts-63">
                        <div class="as-contacts-64">
                            <label class="as-contacts-50">Email *</label>
                            <input class="as-contacts-65" type="email" id="edit-email" required maxlength="255">
                        </div>
                        <div class="as-contacts-64">
                            <label class="as-contacts-50">Phone Number</label>
                            <input class="as-contacts-65" type="text" id="edit-phone-number" maxlength="30">
                        </div>
                    </div>

                    <div class="as-contacts-54">
                        <label class="as-contacts-50">Notes</label>
                        <textarea class="as-contacts-66" id="edit-notes" rows="3"></textarea>
                    </div>

                    <div class="as-contacts-56" id="edit-modal-error-message"></div>
                    <div class="as-contacts-57" id="edit-modal-success-message"></div>

                    <div class="as-contacts-58">
                        <button class="as-contacts-59" type="button" id="btn-cancel-edit-account">CANCEL</button>
                        <button class="as-contacts-60" type="submit" id="btn-submit-edit-account">SAVE</button>
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

                // Toggle Clear Filters button visibility
                const isFiltered = searchVal !== '' || statusVal !== 'all' || roleVal !== 'all';
                if (isFiltered) {
                    $clearFiltersBtn.css('display', 'inline-flex');
                } else {
                    $clearFiltersBtn.css('display', 'none');
                }

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
                    $tbody.append(`<tr><td class="as-contacts-67" colspan="7">No contacts found</td></tr>`);
                } else {
                    const pageRows = filteredRows.slice(startIndex, endIndex);
                    pageRows.forEach(item => {
                        const statusStyle = item.hasActiveSubscription ? '' : 'background-color: #fef2f2; color: #ef4444;';
                        const roleText = item.role ? item.role.charAt(0).toUpperCase() + item.role.slice(1) : 'Subscriber';
                        
                        const rowHtml = `
                            <tr data-id="${item.id}">
                                <td><span class="status-pill-completed" style="${statusStyle}">${item.hasActiveSubscription ? 'Active' : 'Inactive'}</span></td>
                                <td class="fw-semibold as-contacts-68">${item.name || 'Not Specified'}</td>
                                <td><a class="as-contacts-68" href="mailto:${item.email}">${item.email}</a></td>
                                <td class="as-contacts-68">${item.company || 'Not Specified'}</td>
                                <td class="as-contacts-68">${roleText}</td>
                                <td class="as-contacts-68">${formatDate(item.createdAt)}</td>
                                <td class="as-classifieds-76">
                                    <div class="dropdown table-dropdown-container">
                                        <button class="table-action-edit" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end as-classifieds-77">
                                            <li><a class="dropdown-item view-contact-btn as-classifieds-78" href="javascript:void(0)" data-id="${item.id}"><i class="bi bi-eye as-classifieds-79"></i> View</a></li>
                                            <li><a class="dropdown-item edit-contact-btn as-classifieds-78" href="javascript:void(0)" data-id="${item.id}"><i class="bi bi-pencil as-classifieds-79"></i> Edit</a></li>
                                            <li><a class="dropdown-item change-password-btn as-classifieds-78" href="javascript:void(0)" data-id="${item.id}"><i class="bi bi-key as-classifieds-79"></i> Change Password</a></li>
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
                $firstNameInput.val('');
                $lastNameInput.val('');
                $emailInput.val('');
                $phoneInput.val('');
                $notesInput.val('');
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
            $tbody.html(`<tr><td class="as-contacts-67" colspan="7"><i class="bi bi-arrow-repeat spin as-contacts-72"></i> Loading contacts...</td></tr>`);

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
                    $tbody.html(`<tr><td class="as-contacts-73" colspan="7">Failed to load contacts. Please try again later.</td></tr>`);
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
