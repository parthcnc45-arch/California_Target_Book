@extends('layouts.portal')

@section('portal_styles')
<style>
    .portal-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }
    .btn-invite:hover:not(:disabled) {
        background-color: #f8fafc;
        border-color: #94a3b8;
    }
    .btn-invite:disabled, .invite-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Team Table Styles from Subscriptions page */
    .team-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: transparent !important;
    }
    .team-table thead,
    .team-table thead tr {
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
        border-bottom: 1px solid #cbd5e1 !important;
    }
    /* Use high-specificity selector to override ctb_styles.css gradient on table:not(.table) th */
    .portal-card .team-table th,
    #section-purchase-seats .team-table th,
    .team-table th {
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
        color: var(--text-muted) !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        text-transform: none !important;
        letter-spacing: normal !important;
        padding: 12px 10px !important;
        border: none !important;
        border-bottom: 1px solid #cbd5e1 !important;
        text-align: left !important;
        box-sizing: border-box;
    }
    .team-table td {
        padding: 12px 10px !important;
        font-size: 13px !important;
        color: #334155 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle !important;
        background-color: transparent !important;
        background: transparent !important;
        box-sizing: border-box;
    }
    .team-table tr:last-child td {
        border-bottom: none !important;
    }

    .team-member-name {
        font-weight: 600;
        color: #0f172a;
    }
    .team-member-email {
        color: var(--text-muted);
    }
    .team-member-role {
        color: #475569;
        font-weight: 500;
    }
    .badge-team-active {
        background-color: #e6f4ea;
        color: #137333;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }
    .badge-team-pending {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }

    .btn-member-manage {
        background: none;
        border: none;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 0;
        transition: color 0.15s ease;
    }
    .btn-member-manage:hover {
        color: #0f172a;
    }
    .btn-member-manage i {
        font-size: 14px;
    }
    .btn-member-remove {
        background: none;
        border: none;
        color: var(--primary-color);
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 0;
        transition: color 0.15s ease;
    }
    .btn-member-remove:hover {
        color: #b91c1c;
    }
    .btn-member-remove i {
        font-size: 14px;
    }
</style>
@endsection

@section('portal_content')
    <section id="section-purchase-seats" class="portal-section active">
        <!-- Header: Back Navigation -->
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
            <a href="{{ route('auth.account.subscriptions') }}" style="color: #0f172a; text-decoration: none; font-size: 20px; display: inline-flex; align-items: center; font-weight: 700; gap: 10px;">
                <i class="bi bi-arrow-left"></i>
                <span>Team & Seats</span>
            </a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px; width: 100%;">
            <!-- Card 1: Seat Usage -->
            <div class="portal-card" style="margin-top: 0; padding: 24px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; color: #0f172a; font-weight: 600; font-size: 15px;">
                    <i class="bi bi-people" style="font-size: 18px; color: #475569;"></i>
                    <span>Seat Usage</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 13.5px;">
                    <span style="color: #475569; font-weight: 500;">Seats used: <strong style="color: #0f172a; font-weight: 700;"><span class="dynamic-seats-used">{{ 1 + count($sub['addons']) }}</span> of <span class="dynamic-seats-total">5</span></strong></span>
                    <span style="color: #16a34a; font-weight: 600;"><span class="dynamic-seats-available">{{ 5 - (1 + count($sub['addons'])) }}</span> available</span>
                </div>
                
                <div style="width: 100%; height: 8px; background-color: #e2e8f0; border-radius: 9999px; overflow: hidden; margin-bottom: 16px;">
                    <div class="dynamic-seats-bar-fill" style="height: 100%; background-color: var(--primary-color); border-radius: 9999px; width: {{ ((1 + count($sub['addons'])) / 5) * 100 }}%; transition: width 0.3s ease-in-out;"></div>
                </div>
                
                <div style="display: flex; gap: 16px; font-size: 12.5px; color: #64748b;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 8px; height: 8px; background-color: var(--primary-color); border-radius: 50%; display: inline-block;"></span>
                        <span>Occupied (<span class="dynamic-seats-used">{{ 1 + count($sub['addons']) }}</span>)</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 8px; height: 8px; background-color: #cbd5e1; border-radius: 50%; display: inline-block;"></span>
                        <span>Available (<span class="dynamic-seats-available">{{ 5 - (1 + count($sub['addons'])) }}</span>)</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Purchase Additional Seats -->
            <div class="portal-card" style="padding: 24px;">
                <div style="color: #0f172a; font-weight: 600; font-size: 15px; margin-bottom: 8px;">
                    Purchase Additional Seats
                </div>
                <p style="font-size: 13.5px; color: #475569; margin: 0 0 16px 0;">
                    Add more seats at $100/seat/year.
                </p>
                
                <form id="purchase-seats-form" style="display: flex; flex-direction: column; gap: 16px; align-items: flex-start;">
                    <div style="display: flex; flex-direction: column; gap: 6px; width: 100%;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Number of seats</label>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <input type="number" id="purchase-seats-input" min="1" max="50" value="1" style="width: 80px; padding: 8px 12px; font-size: 13.5px; border-radius: 6px; border: 1px solid #cbd5e1; box-sizing: border-box; font-weight: 600; text-align: center;">
                            <span style="font-size: 13.5px; color: #475569; font-weight: 500;">
                                = <strong style="color: #0f172a;">$<span id="purchase-total-price">100</span></strong>/year
                            </span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-purchase-submit" style="display: inline-flex; align-items: center; gap: 6px; background-color: var(--primary-color); color: #ffffff !important; border: none; border-radius: 6px; padding: 10px 18px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background-color 0.15s ease-in-out;">
                        <i class="bi bi-person-plus"></i> Add Seats
                    </button>
                </form>
            </div>

            <!-- Card 3: Team Members -->
            <div class="portal-card" style="padding: 24px;">
                <div style="color: #0f172a; font-weight: 600; font-size: 15px; margin-bottom: 16px;">
                    Team Members (<span id="team-seats-count-badge">{{ 1 + count($sub['addons']) }}</span>)
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 13.5px;">
                    <span style="color: #475569; font-weight: 500;">Seats: <strong style="color: #0f172a; font-weight: 700;"><span class="dynamic-seats-used">{{ 1 + count($sub['addons']) }}</span> of <span class="dynamic-seats-total">5</span></strong></span>
                    <span style="color: #16a34a; font-weight: 600;"><span class="dynamic-seats-available">{{ 5 - (1 + count($sub['addons'])) }}</span> available</span>
                </div>
                
                <div style="width: 100%; height: 8px; background-color: #e2e8f0; border-radius: 9999px; overflow: hidden; margin-bottom: 20px;">
                    <div class="dynamic-seats-bar-fill" style="height: 100%; background-color: var(--primary-color); border-radius: 9999px; width: {{ ((1 + count($sub['addons'])) / 5) * 100 }}%; transition: width 0.3s ease-in-out;"></div>
                </div>

                <!-- Invite Colleague Form -->
                <div class="invite-container" style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; margin-bottom: 24px;">
                    <div style="display: flex; gap: 12px; width: 100%; max-width: 480px;">
                        <input type="email" id="invite-email" class="form-input invite-input" placeholder="colleague@example.com" style="flex: 1; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 0 12px; font-size: 13.5px; box-sizing: border-box;">
                        <button type="button" class="btn-invite" id="btn-invite-submit" style="display: inline-flex; align-items: center; gap: 6px; background-color: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; border-radius: 6px; padding: 0 16px; font-size: 13px; font-weight: 600; cursor: pointer; height: 38px; box-sizing: border-box;">
                            <i class="bi bi-envelope"></i> Invite
                        </button>
                    </div>
                    <div id="invite-message" style="display:none; font-size:12.5px; margin-top: 4px; font-weight: 500;"></div>
                </div>

                <!-- Table of Team Members -->
                <table class="team-table" id="team-members-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #cbd5e1;">
                            <th style="width: 20%; padding: 12px 10px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: none; letter-spacing: normal; background-color: #ffffff;">Name</th>
                            <th style="width: 30%; padding: 12px 10px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: none; letter-spacing: normal; background-color: #ffffff;">Email</th>
                            <th style="width: 15%; padding: 12px 10px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: none; letter-spacing: normal; background-color: #ffffff;">Role</th>
                            <th style="width: 15%; padding: 12px 10px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: none; letter-spacing: normal; background-color: #ffffff;">Status</th>
                            <th style="width: 20%; padding: 12px 10px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: none; letter-spacing: normal; background-color: #ffffff;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-user-email="{{ $sub['base_account']->email }}" style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 10px; vertical-align: middle;"><span class="team-member-name" style="font-weight: 600; color: #0f172a; font-size: 13px;">{{ trim($sub['base_account']->name()) ?: 'Pending Profile' }}</span></td>
                            <td style="padding: 12px 10px; vertical-align: middle;"><span class="team-member-email" style="color: var(--text-muted); font-size: 13px;">{{ $sub['base_account']->email }}</span></td>
                            <td style="padding: 12px 10px; vertical-align: middle;"><span class="role-badge">Owner</span></td>
                            <td style="padding: 12px 10px; vertical-align: middle;"><span class="badge-team-active">Active</span></td>
                            <td style="padding: 12px 10px; vertical-align: middle;"></td>
                        </tr>
                        @foreach($sub['addons'] as $addon)
                        <tr data-addon-id="{{ $addon->id }}" data-user-email="{{ $addon->email }}" style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 10px; vertical-align: middle;"><span class="team-member-name" style="font-weight: 600; color: #0f172a; font-size: 13px;">{{ trim($addon->name()) ?: 'Pending Profile' }}</span></td>
                            <td style="padding: 12px 10px; vertical-align: middle;"><span class="team-member-email" style="color: var(--text-muted); font-size: 13px;">{{ $addon->email }}</span></td>
                            <td style="padding: 12px 10px; vertical-align: middle;"><span class="role-badge">Member</span></td>
                            <td style="padding: 12px 10px; vertical-align: middle;">
                                @if($addon->verified)
                                    <span class="badge-team-active">Active</span>
                                @else
                                    <span class="badge-team-pending">Pending</span>
                                @endif
                            </td>
                            <td style="padding: 12px 10px; vertical-align: middle;">
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <button type="button" class="btn-member-reassign" style="color: #475569; font-weight: 600; border: none; background: none; display: inline-flex; align-items: center; gap: 4px; font-size: 12.5px; cursor: pointer; transition: color 0.15s ease;">
                                        <i class="bi bi-arrow-repeat"></i> Reassign
                                    </button>
                                    <button type="button" class="btn-member-remove btn-remove-addon" data-id="{{ $addon->id }}" style="color: var(--primary-color); font-weight: 600; border: none; background: none; display: inline-flex; align-items: center; gap: 4px; font-size: 12.5px; cursor: pointer; transition: color 0.15s ease;">
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
    </section>
@endsection

@section('portal_scripts')
<script>
    $(document).ready(function() {
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
            alert('Successfully requested to purchase ' + count + ' additional seat(s). We will process the request shortly.');
        });

        // Check seat limit function
        function checkSeatLimit() {
            var count = $('#team-members-table tbody tr').length;
            var maxSeats = 5;
            var available = maxSeats - count;
            if (available < 0) available = 0;

            // Update progress bar UI elements
            $('.dynamic-seats-used').text(count);
            $('.dynamic-seats-available').text(available);
            $('#team-seats-count-badge').text(count);
            var percent = (count / maxSeats) * 100;
            if (percent > 100) percent = 100;
            $('.dynamic-seats-bar-fill').css('width', percent + '%');

            if (count >= maxSeats) {
                $('#invite-email').prop('disabled', true);
                $('#btn-invite-submit').prop('disabled', true);
                $('#invite-message').html('<span style="color:#ef4444;">You have reached the limit of ' + maxSeats + ' seats. Remove a member to invite more.</span>').show();
            } else {
                $('#invite-email').prop('disabled', false);
                $('#btn-invite-submit').prop('disabled', false);
                $('#invite-message').hide();
            }
        }

        // Call initially
        checkSeatLimit();

        // Invite Colleague Handler
        $('#btn-invite-submit').on('click', function(e) {
            e.preventDefault();
            var email = $.trim($('#invite-email').val());
            var $messageDiv = $('#invite-message');

            if (!email) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter an email address.</span>').show();
                return;
            }

            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(email)) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter a valid email address.</span>').show();
                return;
            }

            $('#invite-email').prop('disabled', true);
            $('#btn-invite-submit').prop('disabled', true);
            $messageDiv.html('<span style="color:#475569;">Sending invitation...</span>').show();

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.invite") }}',
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#invite-email').val('');
                        $messageDiv.html('<span style="color:#16a34a;">' + response.message + '</span>').show();
                        
                        var newRow = `
                            <tr data-addon-id="${response.addon.id}" data-user-email="${response.addon.email}" style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 10px; vertical-align: middle;"><span class="team-member-name" style="font-weight: 600; color: #0f172a; font-size: 13px;">${response.addon.name}</span></td>
                                <td style="padding: 12px 10px; vertical-align: middle;"><span class="team-member-email" style="color: var(--text-muted); font-size: 13px;">${response.addon.email}</span></td>
                                <td style="padding: 12px 10px; vertical-align: middle;"><span class="role-badge">Member</span></td>
                                <td style="padding: 12px 10px; vertical-align: middle;"><span class="badge-team-pending">${response.addon.status}</span></td>
                                <td style="padding: 12px 10px; vertical-align: middle;">
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <button type="button" class="btn-member-reassign" style="color: #475569; font-weight: 600; border: none; background: none; display: inline-flex; align-items: center; gap: 4px; font-size: 12.5px; cursor: pointer; transition: color 0.15s ease;">
                                            <i class="bi bi-arrow-repeat"></i> Reassign
                                        </button>
                                        <button type="button" class="btn-member-remove btn-remove-addon" data-id="${response.addon.id}" style="color: var(--primary-color); font-weight: 600; border: none; background: none; display: inline-flex; align-items: center; gap: 4px; font-size: 12.5px; cursor: pointer; transition: color 0.15s ease;">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        $('#team-members-table tbody').append(newRow);
                        checkSeatLimit();
                    } else {
                        $messageDiv.html('<span style="color:#ef4444;">' + response.message + '</span>').show();
                        $('#invite-email').prop('disabled', false);
                        $('#btn-invite-submit').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Failed to send invitation. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $messageDiv.html('<span style="color:#ef4444;">' + errorMsg + '</span>').show();
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
                    } else {
                        alert(response.message || 'Failed to remove user.');
                        $button.prop('disabled', false).html('<i class="bi bi-trash"></i> Remove');
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Failed to remove user. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                    $button.prop('disabled', false).html('<i class="bi bi-trash"></i> Remove');
                }
            });
        });
    });
</script>
@endsection
