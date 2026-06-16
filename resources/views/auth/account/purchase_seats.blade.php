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
                    <span class="text-muted-fw-500">Seats used: <strong class="seats-count-bold"><span class="dynamic-seats-used">{{ 1 + count($sub['addons']) }}</span> of <span class="dynamic-seats-total">5</span></strong></span>
                    <span class="seats-available-green"><span class="dynamic-seats-available">{{ 5 - (1 + count($sub['addons'])) }}</span> available</span>
                </div>
                
                <div class="seats-progress-bar-track">
                    <div class="dynamic-seats-bar-fill seats-progress-bar-fill" style="width: {{ ((1 + count($sub['addons'])) / 5) * 100 }}%;"></div>
                </div>
                
                <div class="flex-row-gap-16-text-muted">
                    <div class="flex-center-gap-6">
                        <span class="legend-dot-primary"></span>
                        <span>Occupied (<span class="dynamic-seats-used">{{ 1 + count($sub['addons']) }}</span>)</span>
                    </div>
                    <div class="flex-center-gap-6">
                        <span class="legend-dot-muted"></span>
                        <span>Available (<span class="dynamic-seats-available">{{ 5 - (1 + count($sub['addons'])) }}</span>)</span>
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
                    Team Members (<span id="team-seats-count-badge">{{ 1 + count($sub['addons']) }}</span>)
                </div>
                
                <div class="flex-space-between-align-center-mb-8">
                    <span class="text-muted-fw-500">Seats: <strong class="seats-count-bold"><span class="dynamic-seats-used">{{ 1 + count($sub['addons']) }}</span> of <span class="dynamic-seats-total">5</span></strong></span>
                    <span class="seats-available-green"><span class="dynamic-seats-available">{{ 5 - (1 + count($sub['addons'])) }}</span> available</span>
                </div>
                
                <div class="seats-progress-bar-track-mb-20">
                    <div class="dynamic-seats-bar-fill seats-progress-bar-fill" style="width: {{ ((1 + count($sub['addons'])) / 5) * 100 }}%;"></div>
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
                            <td><span class="team-member-name team-member-name-13">{{ trim($sub['base_account']->name()) ?: 'Pending Profile' }}</span></td>
                            <td><span class="team-member-email team-member-email-13">{{ $sub['base_account']->email }}</span></td>
                            <td><span class="role-badge">Owner</span></td>
                            <td><span class="badge-team-active">Active</span></td>
                            <td></td>
                        </tr>
                        @foreach($sub['addons'] as $addon)
                        <tr data-addon-id="{{ $addon->id }}" data-user-email="{{ $addon->email }}">
                            <td><span class="team-member-name team-member-name-13">{{ trim($addon->name()) ?: 'Pending Profile' }}</span></td>
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
                                    <button type="button" class="btn-member-reassign btn-member-reassign-custom">
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
                            <tr data-addon-id="${response.addon.id}" data-user-email="${response.addon.email}">
                                <td><span class="team-member-name team-member-name-13">${response.addon.name}</span></td>
                                <td><span class="team-member-email team-member-email-13">${response.addon.email}</span></td>
                                <td><span class="role-badge">Member</span></td>
                                <td><span class="badge-team-pending">${response.addon.status}</span></td>
                                <td>
                                    <div class="flex-center-gap-12">
                                        <button type="button" class="btn-member-reassign btn-member-reassign-custom">
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
                        $messageDiv.html('<span class="text-danger">${response.message}</span>').show();
                        $('#invite-email').prop('disabled', false);
                        $('#btn-invite-submit').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Failed to send invitation. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $messageDiv.html(`<span class="text-danger">${errorMsg}</span>`).show();
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
