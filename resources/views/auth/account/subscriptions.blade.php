@extends('layouts.portal')

@section('portal_content')
    <section id="section-subscriptions" class="portal-section active">
        <header class="section-header section-header-flex">
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Subscriptions</h1>
                </div>
                <p class="header-subtitle">Manage your subscriptions, book recipients, and add-ons.</p>
            </div>
            <a href="{{ route('auth.account.subscriptions.add') }}" class="btn-add-subscription">
                <i class="bi bi-plus-lg"></i> Add Subscription
            </a>
        </header>

        @if($sub['status'] !== 'None')
        <!-- Card 1: One-Year Subscription -->
        <div class="subscription-card">
            <div class="subscription-card-header">
                <div class="subscription-card-title-container">
                    <h2 class="subscription-card-title">{{ $sub['stripe_product_name'] ?? '' }}</h2>
                </div>
                @php
                    $status = 'Active';
                    $statusClass = 'badge-active';
                    
                    if (isset($sub['stripe_data']) && $sub['stripe_data']) {
                        $status = ucfirst($sub['stripe_data']->status);
                        if (strtolower($status) !== 'active' && strtolower($status) !== 'trialing') {
                            $statusClass = 'badge-inactive';
                        }
                    } else {
                        $status = ucfirst($sub['status'] ?? 'Active');
                        if (strtolower($status) !== 'active' && strtolower($status) !== 'trialing') {
                            $statusClass = 'badge-inactive';
                        }
                    }
                @endphp
                <span class="{{ $statusClass }}">{{ $status }}</span>
            </div>
            <div class="subscription-card-body">
                <table class="subscription-info-table">
                    <tbody>
                        <tr>
                            <td class="subscription-info-label">Started</td>
                            <td class="subscription-info-value">{{ $sub['start'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Expires</td>
                            <td class="subscription-info-value">{{ $sub['end'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Renewal</td>
                            <td class="subscription-info-value">{{ $sub['end'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Seats</td>
                            <td class="subscription-info-value"><span id="seats-summary-count">{{ count($sub['addons']) }}</span> of {{ (int) ($sub['base_account']->additional_online_users ?? 0) }} used</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Add-ons</td>
                            <td class="subscription-info-value text-normal-lh-14">
                                @php
                                    $addonsList = [];
                                    if (!empty($sub['books']) && count($sub['books']) > 0) {
                                        $addonsList[] = "Print Edition (" . count($sub['books']) . " " . (count($sub['books']) === 1 ? 'copy' : 'copies') . ")";
                                    }
                                    $totalSeats = (int) ($sub['base_account']->additional_online_users ?? 0);
                                    if ($totalSeats > 0) {
                                        $addonsList[] = "Additional Seats (" . $totalSeats . ")";
                                    }
                                    $addonsText = !empty($addonsList) ? implode(' + ', $addonsList) : '';
                                @endphp
                                {{ $addonsText }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="subscription-card-footer">
                <div class="subscription-footer-left">
                    <a href="{{ route('auth.account.manage_billing') }}" class="btn-manage-billing">
                        <i class="bi bi-credit-card"></i> Manage Billing
                    </a>
                </div>
                <div class="subscription-footer-right">
                    <button type="button" class="btn-cancel-subscription btn-trigger-cancel">
                        Cancel
                    </button>
                </div>
            </div>

            <!-- Team Members Accordion -->
            <button class="accordion-toggle" type="button" data-target="#team-list-1">
                <span>Team Members (<span id="team-seats-count">{{ count($sub['addons']) }}</span> of {{ (int) ($sub['base_account']->additional_online_users ?? 0) }} seats)</span>
                <i class="bi bi-chevron-down accordion-chevron"></i>
            </button>
            <div id="team-list-1" class="accordion-content">
                <div class="accordion-content-inner">
                    <!-- Seats Progress Bar -->
                    <div class="seats-progress-container">
                        <div class="seats-progress-header">
                            <span class="seats-progress-text">Seats: <strong id="progress-seats-used">{{ count($sub['addons']) }}</strong> of <strong id="progress-seats-total">{{ (int) ($sub['base_account']->additional_online_users ?? 0) }}</strong></span>
                            <span class="seats-progress-available"><span id="progress-seats-available">{{ max(0, (int) ($sub['base_account']->additional_online_users ?? 0) - count($sub['addons'])) }}</span> available</span>
                        </div>
                        <div class="seats-progress-bar-track">
                            <div class="seats-progress-bar-fill" style="width: {{ (int) ($sub['base_account']->additional_online_users ?? 0) > 0 ? min(100, (count($sub['addons']) / (int) ($sub['base_account']->additional_online_users)) * 100) : 0 }}%;"></div>
                        </div>
                    </div>

                    <!-- Invite Colleague Form -->
                    <div class="invite-container invite-container-col">
                        <div class="flex-row-gap-12">
                            <input type="email" id="invite-email" class="form-input invite-input" placeholder="colleague@example.com">
                            <button type="button" class="btn-invite" id="btn-invite-submit"><i class="bi bi-envelope"></i> Invite</button>
                        </div>
                        <div id="invite-message" style="display:none; font-size:12.5px; margin-top: 4px; font-weight: 500;"></div>
                    </div>

                    <!-- Team Members Header -->
                    <div class="team-header-container">
                        <span class="team-header-title">Team Members</span>
                        <span class="team-header-badge" id="team-active-badge">{{ 1 + $sub['addons']->where('verified', 1)->count() }} active</span>
                    </div>

                    <table class="team-table" id="team-members-table">
                        <thead>
                            <tr>
                                <th class="th-w-20">Name</th>
                                <th class="th-w-30">Email</th>
                                <th class="th-w-15">Role</th>
                                <th class="th-w-15">Status</th>
                                <th class="th-w-20">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-user-email="{{ $sub['base_account']->email }}">
                                <td><span class="team-member-name">{{ $sub['base_account']->name() }}</span></td>
                                <td><span class="team-member-email">{{ $sub['base_account']->email }}</span></td>
                                <td><span class="team-member-role">Owner</span></td>
                                <td><span class="badge-team-active">Active</span></td>
                                <td></td>
                            </tr>
                            @foreach($sub['addons'] as $addon)
                            <tr data-addon-id="{{ $addon->id }}" data-user-email="{{ $addon->email }}">
                                <td><span class="team-member-name">{{ trim($addon->name()) ?: '' }}</span></td>
                                <td><span class="team-member-email">{{ $addon->email }}</span></td>
                                <td><span class="team-member-role">Member</span></td>
                                <td>
                                    @if($addon->verified)
                                        <span class="badge-team-active">Active</span>
                                    @else
                                        <span class="badge-team-pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex-center-gap-12">
                                        <button type="button" class="btn-member-manage btn-reassign-addon" data-id="{{ $addon->id }}" data-name="{{ trim($addon->name()) ?: '' }}">
                                            <i class="bi bi-arrow-repeat"></i> Reassign
                                        </button>
                                        <button type="button" class="btn-member-remove btn-remove-addon" data-id="{{ $addon->id }}">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Purchase Additional Seats -->
                    <div class="purchase-seats-container">
                        <a href="{{ route('auth.account.subscriptions.seats') }}" class="purchase-seats-link">
                            <i class="bi bi-person-plus"></i> Purchase Additional Seats
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="subscription-card subscription-card-empty">
            <p class="subscription-card-empty-text">You do not have an active subscription.</p>
            <a href="{{ route('auth.account.subscriptions.add') }}" class="btn-add-subscription">
                <i class="bi bi-cart"></i> Purchase Subscription
            </a>
        </div>
        @endif

        <!-- Cancel Subscription Modal -->
        <div id="cancel-sub-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 class="modal-title">Cancel Subscription</h3>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel your subscription? You will lose access to all portal features at the end of your current billing period.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-keep-subscription" id="btn-keep-sub-btn">
                        KEEP SUBSCRIPTION
                    </button>
                    <form action="{{ route('auth.account.subscriptions.cancel') }}" method="POST" class="form-inline-m0">
                        {{ csrf_field() }}
                        <button type="submit" class="btn-confirm-cancel">
                            YES, CANCEL SUBSCRIPTION
                        </button>
                    </form>
                </div>
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
                        <label class="form-label-custom-sm">Email</label>
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

        <!-- Remove Team Member Modal -->
        <div id="remove-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card modal-card-sm">
                <div class="modal-header modal-header-confirm">
                    <div class="flex-column-gap-4">
                        <h3 class="modal-title">Remove Team Member</h3>
                        <p class="modal-body-text-confirm-p">Remove <strong>Sarah Johnson</strong> (sarah@example.com) from this subscription? They will lose access immediately.</p>
                    </div>
                </div>
                <div class="modal-footer modal-footer-confirm">
                    <button type="button" class="btn-cancel btn-modal-cancel" id="btn-cancel-remove">
                        Cancel
                    </button>
                    <button type="button" class="btn-reassign btn-modal-danger" id="btn-remove-submit">
                        Remove
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

        $('.accordion-toggle').on('click', function(e) {
            e.preventDefault();
            var $button = $(this);
            var targetSelector = $button.data('target');
            var $content = $(targetSelector);
            var isActive = $button.hasClass('active');

            if (isActive) {
                $button.removeClass('active');
                $content.animate({ maxHeight: 0 }, 200);
            } else {
                $button.addClass('active');
                $content.css('max-height', 'none');
                var scrollHeight = $content.height();
                $content.css('max-height', 0);
                $content.animate({ maxHeight: scrollHeight }, 200, function() {
                    $content.css('max-height', 'none');
                });
            }
        });

        // Cancel modal event listeners
        $('.btn-trigger-cancel').on('click', function(e) {
            e.preventDefault();
            $('#cancel-sub-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-keep-sub-btn, #btn-close-modal-x').on('click', function(e) {
            e.preventDefault();
            $('#cancel-sub-modal').fadeOut(150);
        });

        $('#cancel-sub-modal').on('click', function(e) {
            if ($(e.target).is('#cancel-sub-modal')) {
                $('#cancel-sub-modal').fadeOut(150);
            }
        });

        // Reassign modal event listeners
        var addonIdToReassign = null;
        var $rowToReassign = null;
        $(document).on('click', '.btn-reassign-addon', function(e) {
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
                        var $reassignBtn = $rowToReassign.find('.btn-reassign-addon');
                        $reassignBtn.attr('data-id', response.addon.id);
                        $reassignBtn.attr('data-name', response.addon.name);

                        // Update delete button data ID
                        $rowToReassign.find('.btn-remove-addon').attr('data-id', response.addon.id);

                        // Update active badge count
                        var activeBadgeCount = 0;
                        $('#team-members-table tbody tr').each(function() {
                            if ($(this).find('.badge-team-active').length > 0) {
                                activeBadgeCount++;
                            }
                        });
                        $('#team-active-badge').text(activeBadgeCount + ' active');
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

        // Remove modal event listeners
        var addonIdToRemove = null;
        var $rowToRemove = null;
        $(document).on('click', '.btn-remove-addon', function(e) {
            e.preventDefault();
            addonIdToRemove = $(this).data('id');
            $rowToRemove = $(this).closest('tr');
            var name = $rowToRemove.find('.team-member-name').text();
            var email = $rowToRemove.find('.team-member-email').text();
            $('#remove-modal').find('.modal-body-text-confirm-p').html('Remove <strong>' + name + '</strong> (' + email + ') from this subscription? They will lose access immediately.');
            $('#remove-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-cancel-remove, #btn-close-remove-modal').on('click', function(e) {
            e.preventDefault();
            $('#remove-modal').fadeOut(150);
        });

        $('#remove-modal').on('click', function(e) {
            if ($(e.target).is('#remove-modal')) {
                $('#remove-modal').fadeOut(150);
            }
        });

        $('#btn-remove-submit').on('click', function(e) {
            e.preventDefault();
            if (!addonIdToRemove) return;
            
            var $btn = $(this);
            $btn.prop('disabled', true).text('Removing...');

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.remove") }}',
                method: 'POST',
                data: {
                    id: addonIdToRemove,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $btn.prop('disabled', false).text('Remove');
                    $('#remove-modal').fadeOut(150);
                    if (response.success) {
                        $rowToRemove.remove();
                        showToast('Success', response.message || 'User removed successfully.', false);
                        // Update counts
                        var totalSeats = $('#team-members-table tbody tr[data-addon-id]').length;
                        $('#team-seats-count').text(totalSeats);
                        $('#seats-summary-count').text(totalSeats);
                        
                        // Update active badge count
                        var activeBadgeCount = 0;
                        $('#team-members-table tbody tr').each(function() {
                            if ($(this).find('.badge-team-active').length > 0) {
                                activeBadgeCount++;
                            }
                        });
                        $('#team-active-badge').text(activeBadgeCount + ' active');

                        checkSeatLimit();
                    } else {
                        showToast('Error', response.message || 'Failed to remove user.', true);
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).text('Remove');
                    var errorMsg = 'Failed to remove user.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showToast('Error', errorMsg, true);
                }
            });
        });

        // Check seat limit function
        function checkSeatLimit() {
            var count = $('#team-members-table tbody tr[data-addon-id]').length;
            var maxSeats = {{ (int) ($sub['base_account']->additional_online_users ?? 0) }};
            var available = maxSeats - count;
            if (available < 0) available = 0;

            // Update progress bar UI
            $('#progress-seats-used').text(count);
            $('#progress-seats-available').text(available);
            var percent = maxSeats > 0 ? (count / maxSeats) * 100 : 0;
            if (percent > 100) percent = 100;
            $('.seats-progress-bar-fill').css('width', percent + '%');

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

            // Simple email format check
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(email)) {
                showToast('Validation Error', 'Please enter a valid email address.', true);
                return;
            }

            // Disable UI
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
                        
                        // Append new member to table
                        var newRow = `
                            <tr data-addon-id="${response.addon.id}" data-user-email="${response.addon.email}">
                                <td><span class="team-member-name">${response.addon.name}</span></td>
                                <td><span class="team-member-email">${response.addon.email}</span></td>
                                <td><span class="team-member-role">${response.addon.role}</span></td>
                                <td>
                                    <span class="${response.addon.status === 'Active' ? 'badge-team-active' : 'badge-team-pending'}">
                                        ${response.addon.status}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex-center-gap-12">
                                        <button type="button" class="btn-member-manage btn-reassign-addon" data-id="${response.addon.id}" data-name="${response.addon.name}">
                                            <i class="bi bi-arrow-repeat"></i> Reassign
                                        </button>
                                        <button type="button" class="btn-member-remove btn-remove-addon" data-id="${response.addon.id}">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        $('#team-members-table tbody').append(newRow);

                        // Update Counts
                        var totalSeats = $('#team-members-table tbody tr[data-addon-id]').length;
                        $('#team-seats-count').text(totalSeats);
                        $('#seats-summary-count').text(totalSeats);

                        // Update active badge count
                        var activeBadgeCount = 0;
                        $('#team-members-table tbody tr').each(function() {
                            if ($(this).find('.badge-team-active').length > 0) {
                                activeBadgeCount++;
                            }
                        });
                        $('#team-active-badge').text(activeBadgeCount + ' active');

                        // Re-enable/Check Limits
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
                    } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
                        errorMsg = xhr.responseJSON.errors.email[0];
                    }
                    showToast('Error', errorMsg, true);
                    $('#invite-email').prop('disabled', false);
                    $('#btn-invite-submit').prop('disabled', false);
                    checkSeatLimit();
                }
            });
        });
    });
</script>
@endsection

