@extends('layouts.portal')



@section('portal_content')
    <div class="details-container">
        <!-- Header -->
        <div class="as-sub-detail-1">
            <div>
                <div class="subscriber-tag">Subscription</div>
                <h1 class="subscriber-name" id="page-subscriber-name"><div class="skeleton-line short as-sub-detail-2"></div></h1>
            </div>
            <a href="/ctb-admin/new/subscriptions" class="btn-premium-secondary">
                <i class="bi bi-arrow-left"></i> BACK TO LIST
            </a>
        </div>
        
        <div class="red-divider"></div>

        <!-- Subscription Card -->
        <div class="premium-card">
            <div class="premium-card-header">
                <h2 class="premium-card-title">
                    <i class="bi bi-building text-brand-red as-sub-detail-3"></i> Organization Info
                </h2>
                <button type="button" class="btn-premium" id="btn-trigger-edit-company">EDIT</button>
            </div>
            <div class="premium-card-body" id="company-details-container">
                <div class="skeleton-line medium"></div>
                <div class="skeleton-line short"></div>
            </div>
        </div>

        <!-- Subscription Cycles Card -->
        <div class="premium-card">
            <div class="premium-card-header">
                <h2 class="premium-card-title">
                    <i class="bi bi-arrow-repeat text-brand-red as-sub-detail-3"></i> Subscription Cycles
                </h2>
                <button type="button" class="btn-premium" id="btn-trigger-create-cycle">CREATE</button>
            </div>
            <div class="cycle-list" id="cycles-list-container">
                <div class="as-sub-detail-4">
                    <div class="skeleton-line medium"></div>
                    <div class="skeleton-line short"></div>
                </div>
            </div>
        </div>

        <!-- Subscribers Card -->
        <div class="premium-card">
            <div class="premium-card-header">
                <h2 class="premium-card-title">
                    <i class="bi bi-people text-brand-red as-sub-detail-3"></i> Subscribers
                </h2>
                <button type="button" class="btn-premium" id="btn-trigger-create-addon">CREATE</button>
            </div>
            <div class="subscriber-list" id="subscribers-list-container">
                <div class="as-sub-detail-4">
                    <div class="skeleton-line medium"></div>
                    <div class="skeleton-line short"></div>
                </div>
            </div>
        </div>

        <!-- Book Subscriptions Card -->
        <div class="premium-card">
            <div class="premium-card-header">
                <h2 class="premium-card-title">
                    <i class="bi bi-book text-brand-red as-sub-detail-3"></i> Book Subscriptions
                </h2>
                <button type="button" class="btn-premium" id="btn-trigger-create-book-sub">CREATE</button>
            </div>
            <div class="book-subs-grid" id="book-subs-list-container">
                <div class="as-sub-detail-5">
                    <div class="skeleton-line medium as-sub-detail-6"></div>
                    <div class="skeleton-line short as-sub-detail-7"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Company Modal -->
    <div id="edit-company-modal" class="ctb-modal">
        <div class="ctb-modal-box">
            <div class="modal-body">
                <h3 class="modal-title">Update Organization</h3>
                <form id="edit-company-form" novalidate>
                    <div class="form-group">
                        <label class="form-label">Company Name *</label>
                        <input type="text" id="company-edit-name" class="form-input" required maxlength="255">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address Line 1 *</label>
                        <input type="text" id="company-edit-line1" class="form-input" required maxlength="255">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" id="company-edit-line2" class="form-input" maxlength="255">
                    </div>
                    <div class="form-row">
                        <div class="form-col as-sub-detail-8">
                            <label class="form-label">City *</label>
                            <input type="text" id="company-edit-city" class="form-input" required maxlength="255">
                        </div>
                        <div class="form-col">
                            <label class="form-label">State *</label>
                            <select id="company-edit-state" class="form-select" required>
                                <option value="CA" selected>CA</option>
                                <option value="AL">AL</option><option value="AK">AK</option><option value="AZ">AZ</option>
                                <option value="AR">AR</option><option value="CO">CO</option><option value="CT">CT</option>
                                <option value="DE">DE</option><option value="FL">FL</option><option value="GA">GA</option>
                                <option value="HI">HI</option><option value="ID">ID</option><option value="IL">IL</option>
                                <option value="IN">IN</option><option value="IA">IA</option><option value="KS">KS</option>
                                <option value="KY">KY</option><option value="LA">LA</option><option value="ME">ME</option>
                                <option value="MD">MD</option><option value="MA">MA</option><option value="MI">MI</option>
                                <option value="MN">MN</option><option value="MS">MS</option><option value="MO">MO</option>
                                <option value="MT">MT</option><option value="NE">NE</option><option value="NV">NV</option>
                                <option value="NH">NH</option><option value="NJ">NJ</option><option value="NM">NM</option>
                                <option value="NY">NY</option><option value="NC">NC</option><option value="ND">ND</option>
                                <option value="OH">OH</option><option value="OK">OK</option><option value="OR">OR</option>
                                <option value="PA">PA</option><option value="RI">RI</option><option value="SC">SC</option>
                                <option value="SD">SD</option><option value="TN">TN</option><option value="TX">TX</option>
                                <option value="UT">UT</option><option value="VT">VT</option><option value="VA">VA</option>
                                <option value="WA">WA</option><option value="WV">WV</option><option value="WI">WI</option>
                                <option value="WY">WY</option>
                            </select>
                        </div>
                        <div class="form-col as-sub-detail-9">
                            <label class="form-label">Zip Code *</label>
                            <input type="text" id="company-edit-zip" class="form-input" required maxlength="15">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Special Instructions</label>
                        <textarea id="company-edit-instructions" class="form-textarea" rows="2" maxlength="255"></textarea>
                    </div>
                    <div id="company-edit-error" class="modal-error"></div>
                    <div id="company-edit-success" class="modal-success"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" id="btn-cancel-edit-company">Cancel</button>
                        <button type="submit" class="btn-modal-submit" id="btn-submit-edit-company">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Renewal/Cycle Modal -->
    <div id="create-cycle-modal" class="ctb-modal">
        <div class="ctb-modal-box as-sub-detail-10">
            <div class="modal-body">
                <h3 class="modal-title">Create Renewal</h3>
                <form id="create-cycle-form" novalidate>
                    <div class="form-group">
                        <label class="form-label">Subscription Term *</label>
                        <select id="cycle-create-length" class="form-select" required>
                            <option value="12" selected>12 Months</option>
                            <option value="24">24 Months</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Starts On *</label>
                        <input type="date" id="cycle-create-starts" class="form-input" required>
                    </div>
                    <div id="cycle-create-error" class="modal-error"></div>
                    <div id="cycle-create-success" class="modal-success"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" id="btn-cancel-create-cycle">Cancel</button>
                        <button type="submit" class="btn-modal-submit" id="btn-submit-create-cycle">Renew</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Cycle Modal -->
    <div id="edit-cycle-modal" class="ctb-modal">
        <div class="ctb-modal-box as-sub-detail-10">
            <div class="modal-body">
                <h3 class="modal-title">Change Subscription Expiration</h3>
                <form id="edit-cycle-form" novalidate>
                    <input type="hidden" id="cycle-edit-id">
                    <div class="form-group">
                        <label class="form-label">Starts On *</label>
                        <input type="date" id="cycle-edit-starts" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ends On *</label>
                        <input type="date" id="cycle-edit-ends" class="form-input" required>
                    </div>
                    <div id="cycle-edit-error" class="modal-error"></div>
                    <div id="cycle-edit-success" class="modal-success"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" id="btn-cancel-edit-cycle">Cancel</button>
                        <button type="submit" class="btn-modal-submit" id="btn-submit-edit-cycle">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Addon/Subscriber Modal -->
    <div id="create-addon-modal" class="ctb-modal">
        <div class="ctb-modal-box as-sub-detail-10">
            <div class="modal-body">
                <h3 class="modal-title">Create Addon Account</h3>
                <form id="create-addon-form" novalidate>
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" id="addon-create-first" class="form-input" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" id="addon-create-last" class="form-input" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" id="addon-create-email" class="form-input" required maxlength="255">
                    </div>
                    <div id="addon-create-error" class="modal-error"></div>
                    <div id="addon-create-success" class="modal-success"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" id="btn-cancel-create-addon">Cancel</button>
                        <button type="submit" class="btn-modal-submit" id="btn-submit-create-addon">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Upsert Book Subscription Modal -->
    <div id="upsert-book-sub-modal" class="ctb-modal">
        <div class="ctb-modal-box">
            <div class="modal-body">
                <h3 class="modal-title" id="book-sub-modal-title">Add Book Subscription</h3>
                <form id="upsert-book-sub-form" novalidate>
                    <input type="hidden" id="book-sub-edit-id">
                    <div class="form-group">
                        <label class="form-label">Address Line 1 *</label>
                        <input type="text" id="book-sub-line1" class="form-input" required maxlength="255">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" id="book-sub-line2" class="form-input" maxlength="255">
                    </div>
                    <div class="form-row">
                        <div class="form-col as-sub-detail-8">
                            <label class="form-label">City *</label>
                            <input type="text" id="book-sub-city" class="form-input" required maxlength="255">
                        </div>
                        <div class="form-col">
                            <label class="form-label">State *</label>
                            <select id="book-sub-state" class="form-select" required>
                                <option value="CA" selected>CA</option>
                                <option value="AL">AL</option><option value="AK">AK</option><option value="AZ">AZ</option>
                                <option value="AR">AR</option><option value="CO">CO</option><option value="CT">CT</option>
                                <option value="DE">DE</option><option value="FL">FL</option><option value="GA">GA</option>
                                <option value="HI">HI</option><option value="ID">ID</option><option value="IL">IL</option>
                                <option value="IN">IN</option><option value="IA">IA</option><option value="KS">KS</option>
                                <option value="KY">KY</option><option value="LA">LA</option><option value="ME">ME</option>
                                <option value="MD">MD</option><option value="MA">MA</option><option value="MI">MI</option>
                                <option value="MN">MN</option><option value="MS">MS</option><option value="MO">MO</option>
                                <option value="MT">MT</option><option value="NE">NE</option><option value="NV">NV</option>
                                <option value="NH">NH</option><option value="NJ">NJ</option><option value="NM">NM</option>
                                <option value="NY">NY</option><option value="NC">NC</option><option value="ND">ND</option>
                                <option value="OH">OH</option><option value="OK">OK</option><option value="OR">OR</option>
                                <option value="PA">PA</option><option value="RI">RI</option><option value="SC">SC</option>
                                <option value="SD">SD</option><option value="TN">TN</option><option value="TX">TX</option>
                                <option value="UT">UT</option><option value="VT">VT</option><option value="VA">VA</option>
                                <option value="WA">WA</option><option value="WV">WV</option><option value="WI">WI</option>
                                <option value="WY">WY</option>
                            </select>
                        </div>
                        <div class="form-col as-sub-detail-9">
                            <label class="form-label">Zip Code *</label>
                            <input type="text" id="book-sub-zip" class="form-input" required maxlength="15">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Special Instructions</label>
                        <textarea id="book-sub-instructions" class="form-textarea" rows="2" maxlength="255"></textarea>
                    </div>
                    <div id="book-sub-error" class="modal-error"></div>
                    <div id="book-sub-success" class="modal-success"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" id="btn-cancel-book-sub">Cancel</button>
                        <button type="submit" class="btn-modal-submit" id="btn-submit-book-sub">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Remove Book Subscription Modal -->
    <div id="remove-book-sub-modal" class="ctb-modal">
        <div class="ctb-modal-box as-sub-detail-10">
            <div class="modal-body">
                <h3 class="modal-title">Remove Book Subscription</h3>
                <p class="as-sub-detail-11">
                    Are you sure you want remove this hard copy subscription for <span class="as-sub-detail-12" id="remove-book-sub-company"></span>?
                </p>
                <div class="as-sub-detail-13" id="remove-book-sub-address">
                </div>
                <div id="remove-book-sub-error" class="modal-error"></div>
                <div id="remove-book-sub-success" class="modal-success"></div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel-grey" id="btn-cancel-remove-book-sub">Cancel</button>
                    <button type="button" class="btn-modal-submit as-sub-detail-14" id="btn-submit-remove-book-sub">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove Addon Modal -->
    <div id="remove-addon-modal" class="ctb-modal">
        <div class="ctb-modal-box as-sub-detail-10">
            <div class="modal-body">
                <h3 class="modal-title">Remove Addon</h3>
                <p class="as-sub-detail-15">
                    This will remove the addon from the <span class="as-sub-detail-12" id="remove-addon-company-name"></span> subscription.
                </p>
                <div id="remove-addon-error" class="modal-error"></div>
                <div id="remove-addon-success" class="modal-success"></div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel-grey" id="btn-cancel-remove-addon">Cancel</button>
                    <button type="button" class="btn-modal-submit as-sub-detail-14" id="btn-submit-remove-addon">Remove</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('portal_scripts')
    <script>
        $(document).ready(function() {
            const apiToken = "{{ Auth::user()->api_token }}";
            const subscriptionId = "{{ $subscription->id }}";
            
            let currentSubscription = null;
            let currentCompany = null;

            // Utilities
            function formatDate(dateStr) {
                if (!dateStr) return 'TBD';
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

            function getCycleStatus(startsOn, endsOn) {
                const now = new Date();
                now.setHours(0,0,0,0);
                
                const start = startsOn ? new Date(startsOn) : null;
                if (start) start.setHours(0,0,0,0);
                
                const end = endsOn ? new Date(endsOn) : null;
                if (end) end.setHours(0,0,0,0);

                if (start && end && now >= start && now <= end) {
                    return 'active';
                }
                if (start && now < start) {
                    return 'upcoming';
                }
                return 'expired';
            }

            // Fetch Subscription Details
            function fetchSubscriptionDetails() {
                $.ajax({
                    url: `/api/subscriptions/${subscriptionId}`,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function(res) {
                        const sub = res.data || res;
                        currentSubscription = sub;
                        currentCompany = sub.company;
                        
                        // Populate Subscription Header & Card
                        const companyName = currentCompany ? currentCompany.name : 'Subscription Details';
                        $('#page-subscriber-name').text(companyName);
                        $('#card-company-name').html(`<i class="bi bi-building as-sub-detail-16"></i> ${companyName}`);

                        let companyDetailsHtml = '';
                        if (currentCompany) {
                            const addr = currentCompany.address;
                            const line1 = addr ? (addr.line1 || addr.address_1 || '') : (currentCompany.address_1 || '');
                            const line2 = addr ? (addr.line2 || addr.address_2 || '') : (currentCompany.address_2 || '');
                            const city = addr ? (addr.city || '') : (currentCompany.city || '');
                            const state = addr ? (addr.state || '') : (currentCompany.state || '');
                            const zip = addr ? (addr.zip_code || addr.zip || '') : (currentCompany.zip || '');
                            const instructions = addr ? (addr.special_instructions || '') : '';
                            
                            companyDetailsHtml = `
                                <div class="company-card-layout">
                                    <div class="company-avatar">
                                        <i class="bi bi-building-fill"></i>
                                    </div>
                                    <div class="company-details-block">
                                        <div class="as-sub-detail-17">${companyName}</div>
                                        <div class="as-sub-detail-18">
                                            ${line1 ? `<div>${line1}</div>` : ''}
                                            ${line2 ? `<div>${line2}</div>` : ''}
                                            ${(city || state || zip) ? `<div>${city}, ${state} ${zip}</div>` : ''}
                                            ${instructions ? `
                                                <div class="as-sub-detail-19">
                                                    <b class="as-sub-detail-20"><i class="bi bi-info-circle"></i> Instructions:</b> ${instructions}
                                                </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            companyDetailsHtml = '<div class="as-sub-detail-21">No company details available.</div>';
                        }
                        $('#company-details-container').html(companyDetailsHtml);

                        // Populate Subscription Cycles
                        let cyclesHtml = '';
                        if (sub.cycles && sub.cycles.length > 0) {
                            sub.cycles.forEach(cycle => {
                                const status = getCycleStatus(cycle.starts_on, cycle.ends_on);
                                let statusIcon = '';
                                let statusBadge = '';
                                if (status === 'active') {
                                    statusIcon = '<div class="cycle-status-icon active" title="Active"><i class="bi bi-check-lg"></i></div>';
                                    statusBadge = '<span class="premium-badge active"><i class="bi bi-check-circle-fill"></i> Active</span>';
                                } else if (status === 'upcoming') {
                                    statusIcon = '<div class="cycle-status-icon upcoming" title="Upcoming"><i class="bi bi-calendar2-week"></i></div>';
                                    statusBadge = '<span class="premium-badge upcoming"><i class="bi bi-calendar-event"></i> Upcoming</span>';
                                } else {
                                    statusIcon = '<div class="cycle-status-icon expired" title="Expired"><i class="bi bi-hourglass-bottom"></i></div>';
                                    statusBadge = '<span class="premium-badge expired"><i class="bi bi-hourglass-split"></i> Expired</span>';
                                }

                                let invoiceHtml = '';
                                if (cycle.invoice && cycle.invoice.lines && cycle.invoice.lines.data) {
                                    invoiceHtml += `
                                        <table class="premium-invoice-table">
                                            <tbody>
                                    `;
                                    cycle.invoice.lines.data.forEach(line => {
                                        const amt = (line.amount / 100).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
                                        invoiceHtml += `
                                            <tr>
                                                <td class="as-sub-detail-22">${line.description || 'Line Item'}</td>
                                                <td class="as-sub-detail-23">${amt}</td>
                                            </tr>
                                        `;
                                    });
                                    const totalDue = (cycle.invoice.amount_due / 100).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
                                    invoiceHtml += `
                                                <tr class="as-sub-detail-24">
                                                    <td class="as-sub-detail-25">Total Amount</td>
                                                    <td class="as-sub-detail-26">${totalDue}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    `;
                                } else if (cycle.amount) {
                                    const amt = parseFloat(cycle.amount).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
                                    invoiceHtml += `
                                        <table class="premium-invoice-table">
                                            <tbody>
                                                <tr>
                                                    <td class="as-sub-detail-22">Subscription Base</td>
                                                    <td class="as-sub-detail-23">${amt}</td>
                                                </tr>
                                                <tr class="as-sub-detail-24">
                                                    <td class="as-sub-detail-25">Total Amount</td>
                                                    <td class="as-sub-detail-26">${amt}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    `;
                                }

                                const paymentInfo = cycle.payment_method 
                                    ? `<div class="as-sub-detail-27"><i class="bi bi-credit-card-2-front"></i> Paid by <b>${cycle.payment_method}</b> on ${formatDate(cycle.created_at)}</div>`
                                    : '';

                                const isPending = !cycle.starts_on && !cycle.ends_on;
                                const showMarkPaid = isPending || cycle.isPending;

                                cyclesHtml += `
                                    <div class="cycle-card-item">
                                        <div class="as-sub-detail-28">
                                            ${statusIcon}
                                            <div class="cycle-content">
                                                <div class="as-sub-detail-29">
                                                    <span class="as-sub-detail-30">From <b>${formatDate(cycle.starts_on)}</b> to <b>${formatDate(cycle.ends_on)}</b></span>
                                                    ${statusBadge}
                                                </div>
                                                ${paymentInfo}
                                                ${invoiceHtml}
                                            </div>
                                        </div>
                                        <div class="cycle-actions-container">
                                            ${cycle.invoice_id ? `<a href="https://dashboard.stripe.com/invoices/${cycle.invoice_id}" target="_blank" class="btn-premium-secondary as-sub-detail-31"><i class="bi bi-stripe"></i> STRIPE</a>` : ''}
                                            <button type="button" class="btn-premium-secondary btn-edit-cycle as-sub-detail-32" data-id="${cycle.id}" data-starts="${cycle.starts_on || ''}" data-ends="${cycle.ends_on || ''}"><i class="bi bi-pencil"></i> EDIT</button>
                                            ${showMarkPaid ? `<button type="button" class="btn-premium-teal btn-pay-cycle as-sub-detail-32" data-id="${cycle.id}"><i class="bi bi-check-circle"></i> MARK PAID</button>` : ''}
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            cyclesHtml = '<div class="as-sub-detail-33">No cycles found.</div>';
                        }
                        $('#cycles-list-container').html(cyclesHtml);

                        // Populate Subscribers/Addons List
                        let subsHtml = '';
                        if (sub.users && sub.users.length > 0) {
                            sub.users.forEach(user => {
                                const role = user.pivot ? user.pivot.role : 'subscriber';
                                const fullName = `${user.first_name || ''} ${user.last_name || ''}`.trim();
                                const displayName = fullName || user.email;
                                const initials = fullName 
                                    ? ((user.first_name || '').substring(0, 1) + (user.last_name || '').substring(0, 1)).toUpperCase() 
                                    : user.email.substring(0, 2).toUpperCase();
                                const avatarClass = role === 'subscriber' ? 'subscriber' : 'addon';
                                const roleText = role === 'subscriber' ? 'Subscriber' : 'Add-On';
                                const badgeClass = role === 'subscriber' ? 'subscriber' : 'addon';
                                
                                const removeButton = role === 'addon'
                                    ? `<button type="button" class="btn-text-delete btn-remove-addon" data-id="${user.id}" data-name="${fullName || user.email}" title="Remove Addon"><i class="bi bi-dash-circle"></i> Remove</button>`
                                    : '';

                                subsHtml += `
                                    <div class="subscriber-item">
                                        <div class="user-profile-block">
                                            <div class="user-avatar ${avatarClass}">${initials}</div>
                                            <div class="user-info">
                                                <div class="user-name-wrapper">
                                                    <span class="as-sub-detail-34">${displayName}</span>
                                                    <span class="badge-role ${badgeClass}">${roleText}</span>
                                                </div>
                                                <a href="mailto:${user.email}" class="user-email-link">
                                                    <i class="bi bi-envelope as-sub-detail-35"></i> ${user.email}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="as-sub-detail-36">
                                            <a href="/ctb-admin/new/contacts/${user.id}" class="btn-premium-secondary as-sub-detail-32" title="Go To Subscriber">
                                                <i class="bi bi-link-45deg"></i> View Profile
                                            </a>
                                            ${removeButton}
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            subsHtml = '<div class="as-sub-detail-33">No subscribers found.</div>';
                        }
                        $('#subscribers-list-container').html(subsHtml);

                        // Populate Book Subscriptions (Hard Copies)
                        let bookSubsHtml = '';
                        if (sub.bookSubscriptions && sub.bookSubscriptions.length > 0) {
                            sub.bookSubscriptions.forEach(b => {
                                const addr = b.address;
                                if (addr) {
                                    const line1 = addr.line1 || addr.address_1 || '';
                                    const line2 = addr.line2 || addr.address_2 || '';
                                    const city = addr.city || '';
                                    const state = addr.state || '';
                                    const zip = addr.zip_code || addr.zip || '';
                                    
                                    bookSubsHtml += `
                                        <div class="book-sub-card">
                                            <div>
                                                <div class="book-sub-card-header">
                                                    <div class="book-sub-avatar">
                                                        <i class="bi bi-box-seam"></i>
                                                    </div>
                                                    <div class="as-sub-detail-37">Book Recipient</div>
                                                </div>
                                                <div class="book-sub-address-info">
                                                    ${line1 ? `<div>${line1}</div>` : ''}
                                                    ${line2 ? `<div>${line2}</div>` : ''}
                                                    ${(city || state || zip) ? `<div>${city}, ${state} ${zip}</div>` : ''}
                                                    ${addr.special_instructions ? `
                                                        <div class="as-sub-detail-38">
                                                            <b class="as-sub-detail-20"><i class="bi bi-info-circle"></i> Instructions:</b> ${addr.special_instructions}
                                                        </div>
                                                    ` : ''}
                                                </div>
                                            </div>
                                            <div class="book-sub-card-actions">
                                                <button type="button" class="btn-text-delete btn-delete-book-sub" data-id="${b.id}" data-line1="${line1}" data-line2="${line2}" data-city="${city}" data-state="${state}" data-zip="${zip}"><i class="bi bi-trash"></i> Delete</button>
                                                <button type="button" class="btn-text-edit btn-edit-book-sub" data-id="${b.id}" data-line1="${addr.line1 || ''}" data-line2="${addr.line2 || ''}" data-city="${addr.city || ''}" data-state="${addr.state || 'CA'}" data-zip="${addr.zip_code || ''}" data-instructions="${addr.special_instructions || ''}"><i class="bi bi-pencil"></i> Edit</button>
                                            </div>
                                        </div>
                                    `;
                                }
                            });
                        } else {
                            bookSubsHtml = '<div class="as-sub-detail-39">No book subscriptions found.</div>';
                        }
                        $('#book-subs-list-container').html(bookSubsHtml);
                    },
                    error: function(xhr) {
                        console.error('Error fetching subscription details:', xhr);
                        alert('Failed to load subscription details. Please refresh the page.');
                    }
                });
            }

            // Init call
            fetchSubscriptionDetails();

            // ---------- 1. EDIT COMPANY ----------
            $('#btn-trigger-edit-company').on('click', function() {
                if (!currentCompany) return;
                const addr = currentCompany.address;
                $('#company-edit-name').val(currentCompany.name);
                $('#company-edit-line1').val(addr ? (addr.line1 || addr.address_1 || '') : (currentCompany.address_1 || ''));
                $('#company-edit-line2').val(addr ? (addr.line2 || addr.address_2 || '') : (currentCompany.address_2 || ''));
                $('#company-edit-city').val(addr ? (addr.city || '') : (currentCompany.city || ''));
                $('#company-edit-state').val(addr ? (addr.state || 'CA') : (currentCompany.state || 'CA'));
                $('#company-edit-zip').val(addr ? (addr.zip_code || addr.zip || '') : (currentCompany.zip || ''));
                $('#company-edit-instructions').val(addr ? (addr.special_instructions || '') : '');
                
                $('#company-edit-error').hide().text('');
                $('#company-edit-success').hide().text('');
                $('#edit-company-modal').css('display', 'flex');
            });

            $('#btn-cancel-edit-company').on('click', function() {
                $('#edit-company-modal').hide();
                $('#company-edit-name').val('');
                $('#company-edit-stripe-id').val('');
                $('#company-edit-phone').val('');
                $('#company-edit-notes').val('');
                $('#company-edit-line1').val('');
                $('#company-edit-line2').val('');
                $('#company-edit-city').val('');
                $('#company-edit-state').val('CA');
                $('#company-edit-zip').val('');
                $('#company-edit-instructions').val('');
                $('#company-edit-error').hide().text('');
                $('#company-edit-success').hide().text('');
            });

            $('#edit-company-form').on('submit', function(e) {
                e.preventDefault();
                const name = $('#company-edit-name').val().trim();
                const line1 = $('#company-edit-line1').val().trim();
                const line2 = $('#company-edit-line2').val().trim();
                const city = $('#company-edit-city').val().trim();
                const state = $('#company-edit-state').val();
                const zip = $('#company-edit-zip').val().trim();
                const instructions = $('#company-edit-instructions').val().trim();

                if (!name || !line1 || !city || !state || !zip) {
                    $('#company-edit-error').text('All starred (*) fields are required.').show();
                    return;
                }

                $('#btn-submit-edit-company').prop('disabled', true).text('SAVING...');

                $.ajax({
                    url: `/api/companies/${currentCompany.id}`,
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        name: name,
                        address: {
                            line1: line1,
                            line2: line2,
                            city: city,
                            state: state,
                            zip_code: zip,
                            special_instructions: instructions
                        }
                    }),
                    success: function() {
                        $('#company-edit-success').text('Company details updated successfully.').show();
                        setTimeout(function() {
                            $('#edit-company-modal').hide();
                            $('#btn-submit-edit-company').prop('disabled', false).text('Save');
                            fetchSubscriptionDetails();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#btn-submit-edit-company').prop('disabled', false).text('Save');
                        let msg = 'Failed to update company details.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        $('#company-edit-error').text(msg).show();
                    }
                });
            });

            // ---------- 2. CREATE CYCLE / RENEWAL ----------
            $('#btn-trigger-create-cycle').on('click', function() {
                $('#cycle-create-starts').val(new Date().toISOString().substring(0, 10));
                $('#cycle-create-error').hide().text('');
                $('#cycle-create-success').hide().text('');
                $('#create-cycle-modal').css('display', 'flex');
            });

            $('#btn-cancel-create-cycle').on('click', function() {
                $('#create-cycle-modal').hide();
                $('#cycle-create-starts').val('');
                $('#cycle-create-error').hide().text('');
                $('#cycle-create-success').hide().text('');
            });

            $('#create-cycle-form').on('submit', function(e) {
                e.preventDefault();
                const length = $('#cycle-create-length').val();
                const starts_on = $('#cycle-create-starts').val();

                if (!starts_on) {
                    $('#cycle-create-error').text('Starts On date is required.').show();
                    return;
                }

                $('#btn-submit-create-cycle').prop('disabled', true).text('RENEWING...');

                $.ajax({
                    url: `/api/subscriptions/${subscriptionId}/cycles`,
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        length: parseInt(length),
                        starts_on: starts_on
                    }),
                    success: function() {
                        $('#cycle-create-success').text('Renewal cycle created successfully.').show();
                        setTimeout(function() {
                            $('#create-cycle-modal').hide();
                            $('#btn-submit-create-cycle').prop('disabled', false).text('Renew');
                            fetchSubscriptionDetails();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#btn-submit-create-cycle').prop('disabled', false).text('Renew');
                        let msg = 'Failed to create renewal cycle.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        $('#cycle-create-error').text(msg).show();
                    }
                });
            });

            // ---------- 3. EDIT CYCLE ----------
            $(document).on('click', '.btn-edit-cycle', function() {
                const id = $(this).data('id');
                const starts = $(this).data('starts');
                const ends = $(this).data('ends');
                
                $('#cycle-edit-id').val(id);
                $('#cycle-edit-starts').val(starts ? starts.substring(0, 10) : '');
                $('#cycle-edit-ends').val(ends ? ends.substring(0, 10) : '');
                
                $('#cycle-edit-error').hide().text('');
                $('#cycle-edit-success').hide().text('');
                $('#edit-cycle-modal').css('display', 'flex');
            });

            $('#btn-cancel-edit-cycle').on('click', function() {
                $('#edit-cycle-modal').hide();
                $('#cycle-edit-id').val('');
                $('#cycle-edit-starts').val('');
                $('#cycle-edit-ends').val('');
                $('#cycle-edit-error').hide().text('');
                $('#cycle-edit-success').hide().text('');
            });

            $('#edit-cycle-form').on('submit', function(e) {
                e.preventDefault();
                const id = $('#cycle-edit-id').val();
                const starts_on = $('#cycle-edit-starts').val();
                const ends_on = $('#cycle-edit-ends').val();

                if (!starts_on || !ends_on) {
                    $('#cycle-edit-error').text('Both start and end dates are required.').show();
                    return;
                }

                $('#btn-submit-edit-cycle').prop('disabled', true).text('SAVING...');

                $.ajax({
                    url: `/api/cycles/${id}`,
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        starts_on: starts_on,
                        ends_on: ends_on
                    }),
                    success: function() {
                        $('#cycle-edit-success').text('Cycle dates updated successfully.').show();
                        setTimeout(function() {
                            $('#edit-cycle-modal').hide();
                            $('#btn-submit-edit-cycle').prop('disabled', false).text('Save');
                            fetchSubscriptionDetails();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#btn-submit-edit-cycle').prop('disabled', false).text('Save');
                        let msg = 'Failed to update cycle dates.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        $('#cycle-edit-error').text(msg).show();
                    }
                });
            });

            // ---------- 4. MARK CYCLE PAID ----------
            $(document).on('click', '.btn-pay-cycle', function() {
                const id = $(this).data('id');
                if (!confirm('Are you sure you want to mark this cycle as paid? This will activate the subscription.')) return;

                const $btn = $(this);
                $btn.prop('disabled', true).text('WAIT...');

                $.ajax({
                    url: `/api/cycles/${id}/markPaid`,
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function() {
                        alert('Cycle marked as paid successfully!');
                        fetchSubscriptionDetails();
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('MARK PAID');
                        let msg = 'Failed to mark cycle as paid.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        alert(msg);
                    }
                });
            });

            // ---------- 5. CREATE ADDON/SUBSCRIBER ----------
            $('#btn-trigger-create-addon').on('click', function() {
                $('#addon-create-first').val('');
                $('#addon-create-last').val('');
                $('#addon-create-email').val('');
                $('#addon-create-error').hide().text('');
                $('#addon-create-success').hide().text('');
                $('#create-addon-modal').css('display', 'flex');
            });

            $('#btn-cancel-create-addon').on('click', function() {
                $('#create-addon-modal').hide();
                $('#addon-create-first').val('');
                $('#addon-create-last').val('');
                $('#addon-create-email').val('');
                $('#addon-create-error').hide().text('');
                $('#addon-create-success').hide().text('');
            });

            $('#create-addon-form').on('submit', function(e) {
                e.preventDefault();
                const first = $('#addon-create-first').val().trim();
                const last = $('#addon-create-last').val().trim();
                const email = $('#addon-create-email').val().trim();

                if (!email) {
                    $('#addon-create-error').text('Email address is required.').show();
                    return;
                }

                $('#btn-submit-create-addon').prop('disabled', true).text('SUBMITTING...');

                $.ajax({
                    url: `/api/subscriptions/${subscriptionId}/addons`,
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        first_name: first,
                        last_name: last,
                        email: email
                    }),
                    success: function() {
                        $('#addon-create-success').text('Addon subscriber added successfully.').show();
                        setTimeout(function() {
                            $('#create-addon-modal').hide();
                            $('#btn-submit-create-addon').prop('disabled', false).text('Submit');
                            fetchSubscriptionDetails();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#btn-submit-create-addon').prop('disabled', false).text('Submit');
                        let msg = 'Failed to add addon subscriber.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        $('#addon-create-error').text(msg).show();
                    }
                });
            });

            // ---------- 6. REMOVE ADDON ----------
            $(document).on('click', '.btn-remove-addon', function() {
                const id = $(this).data('id');
                
                $('#btn-submit-remove-addon').data('id', id);
                $('#remove-addon-company-name').text(currentCompany ? currentCompany.name : 'this');
                
                $('#remove-addon-error').hide().text('');
                $('#remove-addon-success').hide().text('');
                $('#remove-addon-modal').css('display', 'flex');
            });

            $('#btn-cancel-remove-addon').on('click', function() {
                $('#remove-addon-modal').hide();
            });

            $('#btn-submit-remove-addon').on('click', function() {
                const id = $(this).data('id');
                const $btn = $(this);
                $btn.prop('disabled', true).text('REMOVING...');

                $.ajax({
                    url: `/api/subscriptions/${subscriptionId}/addons/${id}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function() {
                        $('#remove-addon-success').text('Addon subscriber removed successfully.').show();
                        setTimeout(function() {
                            $('#remove-addon-modal').hide();
                            $btn.prop('disabled', false).text('Remove');
                            fetchSubscriptionDetails();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('Remove');
                        let msg = 'Failed to remove addon subscriber.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        $('#remove-addon-error').text(msg).show();
                    }
                });
            });

            // ---------- 7. CREATE / EDIT BOOK SUBSCRIPTION ----------
            $('#btn-trigger-create-book-sub').on('click', function() {
                $('#book-sub-edit-id').val('');
                $('#book-sub-line1').val('');
                $('#book-sub-line2').val('');
                $('#book-sub-city').val('');
                $('#book-sub-state').val('CA');
                $('#book-sub-zip').val('');
                $('#book-sub-instructions').val('');
                
                $('#book-sub-modal-title').text('Create Hard Copy Subscription');
                $('#book-sub-error').hide().text('');
                $('#book-sub-success').hide().text('');
                $('#upsert-book-sub-modal').css('display', 'flex');
            });

            $(document).on('click', '.btn-edit-book-sub', function() {
                const id = $(this).data('id');
                const line1 = $(this).data('line1');
                const line2 = $(this).data('line2');
                const city = $(this).data('city');
                const state = $(this).data('state');
                const zip = $(this).data('zip');
                const instructions = $(this).data('instructions');

                $('#book-sub-edit-id').val(id);
                $('#book-sub-line1').val(line1);
                $('#book-sub-line2').val(line2);
                $('#book-sub-city').val(city);
                $('#book-sub-state').val(state);
                $('#book-sub-zip').val(zip);
                $('#book-sub-instructions').val(instructions);

                $('#book-sub-modal-title').text('Edit Hard Copy Subscription');
                $('#book-sub-error').hide().text('');
                $('#book-sub-success').hide().text('');
                $('#upsert-book-sub-modal').css('display', 'flex');
            });

            $('#btn-cancel-book-sub').on('click', function() {
                $('#upsert-book-sub-modal').hide();
                $('#book-sub-edit-id').val('');
                $('#book-sub-line1').val('');
                $('#book-sub-line2').val('');
                $('#book-sub-city').val('');
                $('#book-sub-state').val('CA');
                $('#book-sub-zip').val('');
                $('#book-sub-instructions').val('');
                $('#book-sub-error').hide().text('');
                $('#book-sub-success').hide().text('');
            });

            $('#upsert-book-sub-form').on('submit', function(e) {
                e.preventDefault();
                const id = $('#book-sub-edit-id').val();
                const line1 = $('#book-sub-line1').val().trim();
                const line2 = $('#book-sub-line2').val().trim();
                const city = $('#book-sub-city').val().trim();
                const state = $('#book-sub-state').val();
                const zip = $('#book-sub-zip').val().trim();
                const instructions = $('#book-sub-instructions').val().trim();

                if (!line1 || !city || !state || !zip) {
                    $('#book-sub-error').text('All starred (*) fields are required.').show();
                    return;
                }

                const isEdit = !!id;
                const ajaxUrl = isEdit 
                    ? `/api/subscriptions/${subscriptionId}/hard-copies/${id}` 
                    : `/api/subscriptions/${subscriptionId}/hard-copies`;
                const ajaxMethod = isEdit ? 'PUT' : 'POST';

                $('#btn-submit-book-sub').prop('disabled', true).text('SAVING...');

                $.ajax({
                    url: ajaxUrl,
                    method: ajaxMethod,
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        address: {
                            line1: line1,
                            line2: line2,
                            city: city,
                            state: state,
                            zip_code: zip,
                            special_instructions: instructions
                        }
                    }),
                    success: function() {
                        const successMsg = isEdit 
                            ? 'Book subscription updated successfully.' 
                            : 'Book subscription added successfully.';
                        $('#book-sub-success').text(successMsg).show();
                        setTimeout(function() {
                            $('#upsert-book-sub-modal').hide();
                            $('#btn-submit-book-sub').prop('disabled', false).text('Save');
                            fetchSubscriptionDetails();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#btn-submit-book-sub').prop('disabled', false).text('Save');
                        let msg = 'Failed to save book subscription.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        $('#book-sub-error').text(msg).show();
                    }
                });
            });

            // ---------- 8. DELETE BOOK SUBSCRIPTION ----------
            $(document).on('click', '.btn-delete-book-sub', function() {
                const id = $(this).data('id');
                const line1 = $(this).data('line1') || '';
                const line2 = $(this).data('line2') || '';
                const city = $(this).data('city') || '';
                const state = $(this).data('state') || '';
                const zip = $(this).data('zip') || '';
                
                $('#btn-submit-remove-book-sub').data('id', id);
                $('#remove-book-sub-company').text(currentCompany ? currentCompany.name : 'this subscriber');
                
                const addressHtml = `${line1}${line2 ? '\n' + line2 : ''}\n${city}, ${state} ${zip}`;
                $('#remove-book-sub-address').text(addressHtml);
                
                $('#remove-book-sub-error').hide().text('');
                $('#remove-book-sub-success').hide().text('');
                $('#remove-book-sub-modal').css('display', 'flex');
            });

            $('#btn-cancel-remove-book-sub').on('click', function() {
                $('#remove-book-sub-modal').hide();
            });

            $('#btn-submit-remove-book-sub').on('click', function() {
                const id = $(this).data('id');
                const $btn = $(this);
                $btn.prop('disabled', true).text('REMOVING...');

                $.ajax({
                    url: `/api/subscriptions/${subscriptionId}/hard-copies/${id}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    success: function() {
                        $('#remove-book-sub-success').text('Book subscription removed successfully.').show();
                        setTimeout(function() {
                            $('#remove-book-sub-modal').hide();
                            $btn.prop('disabled', false).text('Remove');
                            fetchSubscriptionDetails();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('Remove');
                        let msg = 'Failed to remove book subscription.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    }
                });
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
