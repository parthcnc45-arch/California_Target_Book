@extends('layouts.portal')
@section('portal_content')
    <section id="section-settings" class="portal-section active">
        <header class="section-header">
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Settings</h1>
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
                                <h4 class="settings-row-title">Email Notifications</h4>
                                <p class="settings-row-description">Receive runtime event alerts and information</p>
                            </div>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" id="settings-release-notif" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="settings-row">
                            <div>
                                <h4 class="settings-row-title">Renewal Reminders</h4>
                                <p class="settings-row-description">Get notifications for plan renewal</p>
                            </div>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" id="settings-billing-reminders" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="settings-row">
                            <div>
                                <h4 class="settings-row-title">Marketing Emails</h4>
                                <p class="settings-row-description">Product updates and newsletters</p>
                            </div>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" id="settings-marketing-emails">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portal-card portal-mt-0">
                <div class="card-header-custom card-header-no-border">
                    <h2 class="card-title-custom text-red-danger">Danger Zone</h2>
                </div>
                <div class="card-body-custom settings-danger-body">
                    <p class="settings-danger-text">
                        Permanently delete your account and all associated data. This action cannot be undone.
                    </p>
                    <button type="button" class="btn-delete-account" id="open-delete-modal">Delete account</button>
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
                        alert('Failed to delete account.');
                        $btn.prop('disabled', false).text('Delete');
                        $deleteModal.fadeOut(200);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting your account.');
                    $btn.prop('disabled', false).text('Delete');
                    $deleteModal.fadeOut(200);
                }
            });
        });

        // Close modal when clicking outside the card
        $deleteModal.on('click', function(e) {
            if (e.target === this) {
                $deleteModal.fadeOut(200);
            }
        });
    });
</script>
@endsection
