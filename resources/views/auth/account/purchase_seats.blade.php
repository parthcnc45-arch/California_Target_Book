@extends('layouts.portal')
@section('portal_content')
    <section id="section-purchase-seats" class="portal-section active">
        <!-- Header: Back Navigation -->
        <div class="flex-center-gap-12-mb-24">
            <a href="{{ route('auth.account.subscriptions') }}" class="back-nav-link">
                <i class="bi bi-arrow-left"></i>
                <span>Team & Seats</span>
            </a>
        </div>

        <div class="flex-column-gap-24">
            <!-- Card 1: Seat Usage -->
            <div class="portal-card portal-card-p24-mt0">
                <div class="flex-center-gap-8-mb-16">
                    <i class="bi bi-people people-icon"></i>
                    <span>Seat Usage</span>
                </div>
                
                <div class="flex-space-between-align-center-mb-8">
                    <span class="text-muted-fw-500">Seats used: <strong class="seats-count-bold"><span class="dynamic-seats-used">{{ count($sub['addons']) }}</span> of <span class="dynamic-seats-total">{{ (int) ($sub['base_account']->additional_online_users ?? 0) }}</span></strong></span>
                    <span class="seats-available-green"><span class="dynamic-seats-available">{{ max(0, (int) ($sub['base_account']->additional_online_users ?? 0) - count($sub['addons'])) }}</span> available</span>
                </div>
                
                <div class="seats-progress-bar-track">
                    <div class="dynamic-seats-bar-fill seats-progress-bar-fill" style="width: {{ (int) ($sub['base_account']->additional_online_users ?? 0) > 0 ? min(100, (count($sub['addons']) / (int) ($sub['base_account']->additional_online_users)) * 100) : 0 }}%;"></div>
                </div>
                
                <div class="flex-row-gap-16-text-muted">
                    <div class="flex-center-gap-6">
                        <span class="legend-dot-primary"></span>
                        <span>Occupied (<span class="dynamic-seats-used">{{ count($sub['addons']) }}</span>)</span>
                    </div>
                    <div class="flex-center-gap-6">
                        <span class="legend-dot-muted"></span>
                        <span>Available (<span class="dynamic-seats-available">{{ max(0, (int) ($sub['base_account']->additional_online_users ?? 0) - count($sub['addons'])) }}</span>)</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Purchase Additional Seats -->
            <div class="portal-card portal-card-p24">
                <div class="card-subheading">
                    Purchase Additional Seats
                </div>
                <p class="text-muted-135-mb-16">
                    Add more seats at $100/seat/year.
                </p>
                
                <form id="purchase-seats-form" class="flex-col-gap-16-align-start">
                    <div class="flex-col-gap-6-w-full">
                        <label class="form-label-custom-gray">Number of seats</label>
                        <div class="flex-center-gap-12">
                            <input type="number" id="purchase-seats-input" min="1" max="50" value="1" class="input-number-seats">
                            <span class="text-muted-135-fw-500">
                                = <strong class="text-dark-bold">$<span id="purchase-total-price">100</span></strong>/year
                            </span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-purchase-submit">
                        <i class="bi bi-person-plus"></i> Add Seats
                    </button>
                </form>
            </div>

            <!-- Card 3: Team Members -->
            <div class="portal-card portal-card-p24">
                <div class="card-subheading">
                    Team Members (<span id="team-seats-count-badge">{{ count($sub['addons']) }}</span>)
                </div>
                
                <div class="flex-space-between-align-center-mb-8">
                    <span class="text-muted-fw-500">Seats: <strong class="seats-count-bold"><span class="dynamic-seats-used">{{ count($sub['addons']) }}</span> of <span class="dynamic-seats-total">{{ (int) ($sub['base_account']->additional_online_users ?? 0) }}</span></strong></span>
                    <span class="seats-available-green"><span class="dynamic-seats-available">{{ max(0, (int) ($sub['base_account']->additional_online_users ?? 0) - count($sub['addons'])) }}</span> available</span>
                </div>
                
                <div class="seats-progress-bar-track-mb-20">
                    <div class="dynamic-seats-bar-fill seats-progress-bar-fill" style="width: {{ (int) ($sub['base_account']->additional_online_users ?? 0) > 0 ? min(100, (count($sub['addons']) / (int) ($sub['base_account']->additional_online_users)) * 100) : 0 }}%;"></div>
                </div>

                <!-- Invite Colleague Form -->
                <div class="invite-container invite-container-col-mb-24">
                    <div class="flex-row-gap-12">
                        <input type="email" id="invite-email" class="form-input invite-input invite-email-input" placeholder="colleague@example.com">
                        <button type="button" class="btn-invite btn-invite-action" id="btn-invite-submit">
                            <i class="bi bi-envelope"></i> Invite
                        </button>
                    </div>
                    <div id="invite-message" style="display:none; font-size:12.5px; margin-top: 4px; font-weight: 500;"></div>
                </div>

                <!-- Table of Team Members -->
                <table class="team-table" id="team-members-table">
                    <thead>
                        <tr class="border-bottom-cbd5e1">
                            <th class="th-w-20">Name</th>
                            <th class="th-w-30">Email</th>
                            <th class="th-w-15">Role</th>
                            <th class="th-w-15">Status</th>
                            <th class="th-w-20">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-user-email="{{ $sub['base_account']->email }}">
                            <td><span class="team-member-name team-member-name-13">{{ trim($sub['base_account']->name()) ?: '' }}</span></td>
                            <td><span class="team-member-email team-member-email-13">{{ $sub['base_account']->email }}</span></td>
                            <td><span class="role-badge">Owner</span></td>
                            <td><span class="badge-team-active">Active</span></td>
                            <td></td>
                        </tr>
                        @foreach($sub['addons'] as $addon)
                        <tr data-addon-id="{{ $addon->id }}" data-user-email="{{ $addon->email }}">
                            <td><span class="team-member-name team-member-name-13">{{ trim($addon->name()) ?: '' }}</span></td>
                            <td><span class="team-member-email team-member-email-13">{{ $addon->email }}</span></td>
                            <td><span class="role-badge">Member</span></td>
                            <td>
                                @if($addon->verified)
                                    <span class="badge-team-active">Active</span>
                                @else
                                    <span class="badge-team-pending">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex-center-gap-12">
                                    <button type="button" class="btn-member-reassign btn-member-reassign-custom" data-id="{{ $addon->id }}" data-name="{{ trim($addon->name()) ?: '' }}">
                                        <i class="bi bi-arrow-repeat"></i> Reassign
                                    </button>
                                    <button type="button" class="btn-member-remove btn-remove-addon btn-member-remove-custom" data-id="{{ $addon->id }}">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Reassign Seat Modal -->
        <div id="reassign-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card modal-card-sm">
                <div class="modal-header modal-header-confirm">
                    <div class="flex-column-gap-4">
                        <h3 class="modal-title">Reassign Seat</h3>
                        <p class="modal-header-subtext">Replace <strong>Sarah Johnson</strong> with a new team member.</p>
                    </div>
                </div>
                <div class="modal-body modal-body-mt-16">
                    <div class="form-group form-group-mb-24">
                        <label class="form-label-custom-gray">Email</label>
                        <input type="email" id="reassign-new-email" class="form-input form-input-custom" placeholder="jane@example.com">
                    </div>
                    <div id="reassign-message" style="display:none; font-size:12.5px; margin-top: 4px; font-weight: 500;"></div>
                </div>
                <div class="modal-footer modal-footer-confirm-sm">
                    <button type="button" class="btn-cancel btn-modal-cancel" id="btn-cancel-reassign">
                        Cancel
                    </button>
                    <button type="button" class="btn-reassign btn-modal-primary" id="btn-reassign-submit">
                        Reassign
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div id="custom-toast" class="portal-toast" style="display: none;">
            <h4 class="portal-toast-title" id="toast-title"></h4>
            <p class="portal-toast-body" id="toast-body"></p>
        </div>

    </section>
@endsection

@section('portal_scripts')
<script>
    $(document).ready(function() {
        function showToast(title, body, isError = false) {
            $('#toast-title').text(title).css('color', isError ? '#ef4444' : '#10b981');
            $('#toast-body').text(body);
            $('#custom-toast').stop(true, true).fadeIn(300).delay(4000).fadeOut(300);
        }

        // Seat price dynamic calculator
        $('#purchase-seats-input').on('input change', function() {
            var count = parseInt($(this).val()) || 1;
            if (count < 1) count = 1;
            var total = count * 100;
            $('#purchase-total-price').text(total);
        });

        // Form Submission Alert
        $('#purchase-seats-form').on('submit', function(e) {
            e.preventDefault();
            var count = $('#purchase-seats-input').val();
            showToast('Success', 'Successfully requested to purchase ' + count + ' additional seat(s). We will process the request shortly.', false);
        });

        // Check seat limit function
        function checkSeatLimit() {
            var count = $('#team-members-table tbody tr[data-addon-id]').length;
            var maxSeats = {{ (int) ($sub['base_account']->additional_online_users ?? 0) }};
            var available = maxSeats - count;
            if (available < 0) available = 0;

            // Update progress bar UI elements
            $('.dynamic-seats-used').text(count);
            $('.dynamic-seats-available').text(available);
            $('#team-seats-count-badge').text(count);
            var percent = maxSeats > 0 ? (count / maxSeats) * 100 : 0;
            if (percent > 100) percent = 100;
            $('.dynamic-seats-bar-fill').css('width', percent + '%');

            if (count >= maxSeats) {
                $('#invite-email').prop('disabled', true);
                $('#btn-invite-submit').prop('disabled', true);
                $('#invite-message').html('<span style="color:#ef4444;">You have reached the limit of ' + maxSeats + ' seats. Remove a member to invite more.</span>').show();
            } else {
                $('#invite-email').prop('disabled', false);
                $('#btn-invite-submit').prop('disabled', false);
                
                var currentHtml = $('#invite-message').html() || '';
                if (currentHtml.indexOf('color:#ef4444') !== -1 || currentHtml.indexOf('limit') !== -1) {
                    $('#invite-message').hide();
                }
            }
        }

        $('#invite-email').on('input', function() {
            $('#invite-message').hide();
        });

        // Call initially
        checkSeatLimit();

        // Invite Colleague Handler
        $('#btn-invite-submit').on('click', function(e) {
            e.preventDefault();
            var email = $.trim($('#invite-email').val());
            var $messageDiv = $('#invite-message');

            if (!email) {
                showToast('Validation Error', 'Please enter an email address.', true);
                return;
            }

            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(email)) {
                showToast('Validation Error', 'Please enter a valid email address.', true);
                return;
            }

            $('#invite-email').prop('disabled', true);
            $('#btn-invite-submit').prop('disabled', true);
            $messageDiv.html('<span style="color:#475569;"><i class="bi bi-hourglass-split"></i> Sending invitation...</span>').show();

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.invite") }}',
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $messageDiv.hide();
                    if (response.success) {
                        $('#invite-email').val('');
                        showToast('Success', response.message, false);
                        
                        var newRow = `
                            <tr data-addon-id="${response.addon.id}" data-user-email="${response.addon.email}">
                                <td><span class="team-member-name team-member-name-13">${response.addon.name}</span></td>
                                <td><span class="team-member-email team-member-email-13">${response.addon.email}</span></td>
                                <td><span class="role-badge">Member</span></td>
                                <td><span class="badge-team-pending">${response.addon.status}</span></td>
                                <td>
                                    <div class="flex-center-gap-12">
                                        <button type="button" class="btn-member-reassign btn-member-reassign-custom" data-id="${response.addon.id}" data-name="${response.addon.name}">
                                            <i class="bi bi-arrow-repeat"></i> Reassign
                                        </button>
                                        <button type="button" class="btn-member-remove btn-remove-addon btn-member-remove-custom" data-id="${response.addon.id}">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        $('#team-members-table tbody').append(newRow);
                        checkSeatLimit();
                    } else {
                        showToast('Error', response.message || 'Failed to send invitation.', true);
                        $('#invite-email').prop('disabled', false);
                        $('#btn-invite-submit').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $messageDiv.hide();
                    var errorMsg = 'Failed to send invitation. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showToast('Error', errorMsg, true);
                    $('#invite-email').prop('disabled', false);
                    $('#btn-invite-submit').prop('disabled', false);
                    checkSeatLimit();
                }
            });
        });

        // Remove Member Handler
        $('#team-members-table').on('click', '.btn-remove-addon', function(e) {
            e.preventDefault();
            var $button = $(this);
            var addonId = $button.data('id');
            var $row = $button.closest('tr');
            var email = $row.data('user-email');

            if (!confirm('Are you sure you want to remove ' + email + ' from your subscription team?')) {
                return;
            }

            $button.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.remove") }}',
                method: 'POST',
                data: {
                    id: addonId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $row.fadeOut(300, function() {
                            $(this).remove();
                            checkSeatLimit();
                        });
                        showToast('Success', response.message || 'User removed successfully.', false);
                    } else {
                        showToast('Error', response.message || 'Failed to remove user.', true);
                        $button.prop('disabled', false).html('<i class="bi bi-trash"></i> Remove');
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Failed to remove user. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showToast('Error', errorMsg, true);
                    $button.prop('disabled', false).html('<i class="bi bi-trash"></i> Remove');
                }
            });
        });

        // Reassign modal event listeners
        var addonIdToReassign = null;
        var $rowToReassign = null;
        $(document).on('click', '.btn-member-reassign', function(e) {
            e.preventDefault();
            addonIdToReassign = $(this).data('id');
            var name = $(this).data('name');
            $rowToReassign = $(this).closest('tr');
            
            var email = $rowToReassign.attr('data-user-email') || '';
            
            $('#reassign-modal').find('.modal-header-subtext').html('Replace <strong>' + name + '</strong> with a new team member.');
            $('#reassign-new-email').val(email);
            $('#reassign-message').hide().empty();
            $('#reassign-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-cancel-reassign, #btn-close-reassign-modal').on('click', function(e) {
            e.preventDefault();
            $('#reassign-modal').fadeOut(150);
        });

        $('#reassign-modal').on('click', function(e) {
            if ($(e.target).is('#reassign-modal')) {
                $('#reassign-modal').fadeOut(150);
            }
        });

        $('#btn-reassign-submit').on('click', function(e) {
            e.preventDefault();
            if (!addonIdToReassign) return;
            
            var email = $.trim($('#reassign-new-email').val());
            var $messageDiv = $('#reassign-message');

            if (!email) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter an email address.</span>').show();
                return;
            }

            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(email)) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter a valid email address.</span>').show();
                return;
            }

            var $btn = $(this);
            $btn.prop('disabled', true).text('Reassigning...');
            $messageDiv.html('<span style="color:#475569;">Reassigning seat...</span>').show();

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.reassign") }}',
                method: 'POST',
                data: {
                    id: addonIdToReassign,
                    name: '',
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $btn.prop('disabled', false).text('Reassign');
                    if (response.success) {
                        $('#reassign-modal').fadeOut(150);
                        showToast('Success', response.message || 'Seat reassigned successfully.', false);
                        
                        // Update the row values dynamically in the table
                        $rowToReassign.attr('data-addon-id', response.addon.id);
                        $rowToReassign.attr('data-user-email', response.addon.email);
                        $rowToReassign.find('.team-member-name').text(response.addon.name);
                        $rowToReassign.find('.team-member-email').text(response.addon.email);
                        
                        var $statusSpan = $rowToReassign.find('td:nth-child(4) span');
                        if (response.addon.status === 'Active') {
                            $statusSpan.attr('class', 'badge-team-active').text('Active');
                        } else {
                            $statusSpan.attr('class', 'badge-team-pending').text('Pending');
                        }

                        // Update data attributes on reassign button
                        var $reassignBtn = $rowToReassign.find('.btn-member-reassign');
                        $reassignBtn.attr('data-id', response.addon.id);
                        $reassignBtn.attr('data-name', response.addon.name);

                        // Update delete button data ID
                        $rowToReassign.find('.btn-remove-addon').attr('data-id', response.addon.id);

                        checkSeatLimit();
                    } else {
                        $messageDiv.html('<span style="color:#ef4444;">' + response.message + '</span>').show();
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).text('Reassign');
                    var errorMsg = 'Failed to reassign seat.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $messageDiv.html('<span style="color:#ef4444;">' + errorMsg + '</span>').show();
                }
            });
        });
    });
</script>
@endsection
