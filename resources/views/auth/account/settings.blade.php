@extends('layouts.portal')

@section('portal_styles')
<style>
    /* Modal Styles */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-card {
        background: #ffffff;
        border-radius: 8px;
        width: 650px;
        max-width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        animation: modalScaleUp 0.15s ease-out;
    }
    @keyframes modalScaleUp {
        from {
            transform: scale(0.95);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 36px;
        height: 20px;
        flex-shrink: 0;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .2s ease;
        border-radius: 20px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .2s ease;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: var(--primary-color);
    }
    input:checked + .slider:before {
        transform: translateX(16px);
    }
    .btn-delete-account {
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .btn-delete-account:hover {
        background-color: #dc2626;
    }
</style>
@endsection

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

        <div style="display: flex; flex-direction: column; gap: 24px; width: 100%;">
            <div class="portal-card" style="margin-top: 0;">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Notifications</h2>
                </div>
                <div class="card-body-custom" style="padding: 4px 24px 12px 24px;">
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #f1f5f9;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Email Notifications</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Receive runtime event alerts and information</p>
                            </div>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" id="settings-release-notif" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #f1f5f9;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Renewal Reminders</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Get notifications for plan renewal</p>
                            </div>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" id="settings-billing-reminders" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Marketing Emails</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Product updates and newsletters</p>
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

            <div class="portal-card" style="margin-top: 0;">
                <div class="card-header-custom" style="border-bottom: none; padding-bottom: 0;">
                    <h2 class="card-title-custom" style="color: #ef4444;">Danger Zone</h2>
                </div>
                <div class="card-body-custom" style="padding: 12px 24px 24px 24px;">
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px; margin-top: 0;">
                        Permanently delete your account and all associated data. This action cannot be undone.
                    </p>
                    <button type="button" class="btn-delete-account" id="open-delete-modal">Delete account</button>
                </div>
            </div>
        </div>
        <!-- Delete Account Modal -->
        <div id="delete-account-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card" style="max-width: 500px;">
                <div class="modal-header" style="justify-content: space-between; align-items: flex-start; border-bottom: none; padding-bottom: 0; padding: 24px 24px 0 24px;">
                    <div style="display:flex; flex-direction:column; gap:4px;">
                        <h3 class="modal-title" style="font-size: 18px; color: var(--text-main); margin: 0; font-weight: 600;">Delete Account</h3>
                        <p style="font-size: 14px; color: #64748b; margin: 8px 0 0 0; line-height: 1.5;">Are you sure you want to permanently delete your account? This action is irreversible.</p>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding: 20px 24px 24px 24px; border-top: none;">
                    <button type="button" class="btn-cancel" id="btn-cancel-delete" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.15s;">
                        Cancel
                    </button>
                    <button type="button" class="btn-delete-confirm" id="btn-confirm-delete" style="background: #ef4444; color: #ffffff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.15s;">
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
