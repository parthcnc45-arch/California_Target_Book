@php
    $notificationSettings = $user->notificationSettings()->first();
    $renewalRemindersVal = $notificationSettings ? $notificationSettings->renewal_reminders : 1;
    $shippingEmailsVal = $notificationSettings ? $notificationSettings->shipping_emails : 1;
@endphp

@extends('layouts.portal')
@section('portal_content')
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
            margin-right: 8px;
            vertical-align: middle;
        }
    </style>

    <section id="section-settings" class="portal-section active">
        <header class="section-header">
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Notifications</h1>
                </div>
                <p class="header-subtitle">Configure notification and account preferences.</p>
            </div>
        </header>

        <div class="flex-column-gap-24">
            <div class="portal-card portal-mt-0">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Notifications</h2>
                </div>
                <div class="card-body-custom settings-card-body">
                    <div class="portal-flex-col">
                        <div class="settings-row">
                            <div>
                                <h4 class="settings-row-title">Renewal Reminders</h4>
                                <p class="settings-row-description">Get notifications for plan renewal</p>
                            </div>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" id="settings-billing-reminders" {{ $renewalRemindersVal ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="settings-row">
                            <div>
                                <h4 class="settings-row-title">Shipping Emails</h4>
                                <p class="settings-row-description">Shipping updates notifications</p>
                            </div>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" id="settings-shipping-emails" {{ $shippingEmailsVal ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Save Actions -->
                        <div style="display: flex; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                            <button type="button" id="btn-save-notifications" class="btn-save-changes" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Account Modal -->
        <div id="delete-account-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card modal-card-sm">
                <div class="modal-header modal-header-confirm">
                    <div class="flex-column-gap-4">
                        <h3 class="modal-title modal-title-confirm">Delete Account</h3>
                        <p class="modal-body-text-confirm-p">Are you sure you want to permanently delete your account? This action is irreversible.</p>
                    </div>
                </div>
                <div class="modal-footer modal-footer-no-border">
                    <button type="button" class="btn-cancel btn-modal-cancel" id="btn-cancel-delete">
                        Cancel
                    </button>
                    <button type="button" class="btn-delete-confirm btn-modal-danger" id="btn-confirm-delete">
                        Delete
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
        var $deleteModal = $('#delete-account-modal');
        
        $('#open-delete-modal').on('click', function(e) {
            e.preventDefault();
            $deleteModal.css('display', 'flex').hide().fadeIn(200);
        });
        
        $('#btn-cancel-delete').on('click', function() {
            $deleteModal.fadeOut(200);
        });

        $('#btn-confirm-delete').on('click', function() {
            var $btn = $(this);
            $btn.prop('disabled', true).text('Deleting...');
            
            $.ajax({
                url: '/account/delete',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = '/'; // Redirect to home page
                    } else {
                        showToast('Error', 'Failed to delete account.', true);
                        $btn.prop('disabled', false).text('Delete');
                        $deleteModal.fadeOut(200);
                    }
                },
                error: function() {
                    showToast('Error', 'An error occurred while deleting your account.', true);
                    $btn.prop('disabled', false).text('Delete');
                    $deleteModal.fadeOut(200);
                }
            });
        });

        function showToast(title, body, isError = false) {
            $('#toast-title').text(title).css('color', isError ? '#ef4444' : '#10b981');
            $('#toast-body').text(body);
            $('#custom-toast').stop(true, true).fadeIn(300).delay(4000).fadeOut(300);
        }

        function updateNotificationSettings() {
            var renewalReminders = $('#settings-billing-reminders').is(':checked') ? 1 : 0;
            var shippingEmails = $('#settings-shipping-emails').is(':checked') ? 1 : 0;
            var $btn = $('#btn-save-notifications');

            // Disable UI inputs and show loading state
            $('#settings-billing-reminders, #settings-shipping-emails').prop('disabled', true);
            $btn.prop('disabled', true).html('<span class="loading-spinner"></span>Saving...');

            $.ajax({
                url: '{{ route("auth.account.notification_settings.update") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    renewal_reminders: renewalReminders,
                    shipping_emails: shippingEmails
                },
                success: function(response) {
                    // Re-enable UI inputs
                    $('#settings-billing-reminders, #settings-shipping-emails').prop('disabled', false);
                    $btn.prop('disabled', false).html('Save Changes');

                    if (response.success) {
                        showToast('Success', 'Notification settings updated successfully.', false);
                    } else {
                        showToast('Error', response.message || 'Failed to update notification settings.', true);
                    }
                },
                error: function() {
                    // Re-enable UI inputs
                    $('#settings-billing-reminders, #settings-shipping-emails').prop('disabled', false);
                    $btn.prop('disabled', false).html('Save Changes');
                    showToast('Error', 'An error occurred while updating your notification settings.', true);
                }
            });
        }

        $('#btn-save-notifications').on('click', function() {
            updateNotificationSettings();
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
