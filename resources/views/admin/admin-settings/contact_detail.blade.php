@extends('layouts.portal')

@section('portal_styles')
    <style>
        .details-container {
            width: 100%;
        }
        .subscriber-tag {
            font-size: 13.5px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .subscriber-name {
            font-size: 26px;
            font-weight: 700;
            color: #b91c1c;
            margin: 4px 0 16px 0;
        }
        .red-divider {
            height: 3px;
            width: 48px;
            background-color: #b91c1c;
            margin-bottom: 24px;
            border-radius: 2px;
        }
        .detail-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .detail-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
        }
        .detail-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-table td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px;
            vertical-align: middle;
        }
        .detail-table tr:last-child td {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #475569;
            width: 25%;
        }
        .detail-value {
            color: #0f172a;
            width: 25%;
        }
        .detail-value-span {
            font-weight: 500;
        }
        .text-brand-red {
            color: #b91c1c !important;
            font-weight: 600;
            text-decoration: none !important;
        }
        .text-brand-red:hover {
            text-decoration: underline !important;
        }
        .btn-edit-contact {
            background-color: #b91c1c;
            border: 1px solid #b91c1c;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-edit-contact:hover {
            background-color: #991b1b;
            border-color: #991b1b;
        }
        .detail-card-footer {
            padding: 16px 24px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
        }
        .password-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-edit-password {
            background: none;
            border: none;
            color: #b91c1c;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
            transition: opacity 0.15s;
        }
        .btn-edit-password:hover {
            opacity: 1;
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
        .password-input-wrapper input.input-invalid {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 1px #fecaca;
        }
        .password-input-wrapper input.input-valid {
            border-color: #86efac !important;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
@endsection

@section('portal_content')
    <div class="details-container">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
            <div>
                <div class="subscriber-tag">Subscriber</div>
                <h1 class="subscriber-name">{{ $contact->name() }}</h1>
            </div>
            <a href="/ctb-admin/new/contacts" class="btn-export-csv" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 13px; padding: 8px 16px;">
                <i class="bi bi-arrow-left"></i> BACK TO LIST
            </a>
        </div>

        <div class="red-divider"></div>

        <!-- Details Card -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h2 class="detail-card-title">Account</h2>
            </div>

            <table class="detail-table">
                <tbody>
                    <tr>
                        <td class="detail-label">Name</td>
                        <td class="detail-value"><span class="detail-value-span">{{ $contact->name() }}</span></td>
                        <td class="detail-label">Email</td>
                        <td class="detail-value">
                            <a href="mailto:{{ $contact->email }}" class="text-brand-red">{{ $contact->email }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label">Password</td>
                        <td class="detail-value">
                            <div class="password-container">
                                <span class="detail-value-span">******</span>
                                <button class="btn-edit-password" id="btn-trigger-change-password" title="Edit password">
                                    <i class="bi bi-pencil-fill" style="font-size: 13px;"></i>
                                </button>
                            </div>
                        </td>
                        <td class="detail-label">Subscribed On</td>
                        <td class="detail-value">
                            <span class="detail-value-span">{{ $contact->created_at ? $contact->created_at->format('M jS, Y') : 'N/A' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label">Account Type</td>
                        <td class="detail-value">
                            <span class="detail-value-span" style="text-transform: capitalize;">{{ $contact->role ?? 'Subscriber' }}</span>
                        </td>
                        <td class="detail-label">Company</td>
                        <td class="detail-value">
                            @if($contact->company)
                                <span class="text-brand-red">{{ $contact->company->name }}</span>
                            @else
                                <span class="detail-value-span" style="color: #64748b;">Not Specified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label">Phone Number</td>
                        <td class="detail-value">
                            <span class="detail-value-span">{{ $contact->phone_number ?? 'Not Specified' }}</span>
                        </td>
                        <td class="detail-label">Stripe Customer ID</td>
                        <td class="detail-value">
                            @if($contact->stripe_id)
                                <a href="https://dashboard.stripe.com/customers/{{ $contact->stripe_id }}" target="_blank" class="text-brand-red">{{ $contact->stripe_id }}</a>
                            @else
                                <span class="detail-value-span" style="color: #64748b;">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label">Account Id</td>
                        <td class="detail-value">
                            <span class="detail-value-span">{{ $contact->id }}</span>
                        </td>
                        <td class="detail-label">Subscription ID</td>
                        <td class="detail-value">
                            @php
                                $sub = $contact->latestSubscription();
                            @endphp
                            @if($sub)
                                <span class="text-brand-red">{{ $sub->id }}</span>
                            @else
                                <span class="detail-value-span" style="color: #64748b;">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label" style="vertical-align: top;">Notes</td>
                        <td colspan="3" class="detail-value" style="width: 75%; line-height: 1.5; white-space: pre-wrap;">
                            <span class="detail-value-span">{{ $contact->notes ?? 'No notes available.' }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="detail-card-footer">
                <button type="button" class="btn-edit-contact" id="btn-trigger-edit-account">
                    <i class="bi bi-pencil-fill"></i> Edit
                </button>
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
                            <input type="text" id="edit-first-name" required maxlength="255" value="{{ $contact->first_name }}" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Last Name</label>
                            <input type="text" id="edit-last-name" maxlength="255" value="{{ $contact->last_name }}" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                    </div>

                    <div style="display: flex; gap: 16px; margin-bottom: 18px;">
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Email *</label>
                            <input type="email" id="edit-email" required maxlength="255" value="{{ $contact->email }}" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Phone Number</label>
                            <input type="text" id="edit-phone-number" maxlength="30" value="{{ $contact->phone_number }}" style="width: 100%; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Notes</label>
                        <textarea id="edit-notes" rows="3" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-sizing: border-box; font-size: 14px; resize: vertical; font-family: inherit;">{{ $contact->notes }}</textarea>
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

    <!-- Change Password Modal -->
    <div id="change-password-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center;">
        <div class="modal-box" style="background: #ffffff; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); max-width: 440px; width: 100%; overflow: hidden; animation: modalFadeIn 0.2s ease-out; margin: 16px;">
            <div style="padding: 24px;">
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">Change Subscriber Password</h3>
                <div style="font-size: 13.5px; font-weight: 600; color: #b91c1c; margin-bottom: 24px;">{{ $contact->name() }}</div>

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
@endsection

@section('portal_scripts')
    <script>
        $(document).ready(function() {
            const apiToken = "{{ Auth::user()->api_token }}";
            const contactId = "{{ $contact->id }}";
            const MIN_LEN = 6;
            const MAX_LEN = 72;

            const $modal = $('#change-password-modal');
            const $form = $('#change-password-form');
            const $passwordInput = $('#new-password');
            const $confirmationInput = $('#new-password-confirmation');
            const $errorDiv = $('#modal-error-message');
            const $successDiv = $('#modal-success-message');
            const $submitBtn = $('#btn-submit-password');
            const $charCount = $('#password-char-count');
            const $passwordHintText = $('#password-hint-text');
            const $confirmationHint = $('#confirmation-hint');

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

            // ---------- Open Update Account Modal ----------
            $('#btn-trigger-edit-account').on('click', function() {
                $editErrorDiv.hide().text('');
                $editSuccessDiv.hide().text('');
                $editModal.css('display', 'flex');
                $firstNameInput.focus();
            });

            // ---------- Close Update Account Modal ----------
            function closeEditModal() {
                $editModal.hide();
                $editErrorDiv.hide().text('');
                $editSuccessDiv.hide().text('');
            }

            $('#btn-cancel-edit-account').on('click', closeEditModal);

            // Note: clicking outside the modal-box intentionally does NOT close it.
            // Only the CANCEL button (or a successful save) closes this modal.

            // ---------- Handle Update Account Submit ----------
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
                    url: `/api/users/${contactId}`,
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

            // ---------- Open Modal ----------
            $('#btn-trigger-change-password').on('click', function() {
                $modal.css('display', 'flex');
                $passwordInput.focus();
            });

            // ---------- Close Modal ----------
            function closeModal() {
                $modal.hide();
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

            $('#btn-cancel-password').on('click', closeModal);

            // Note: clicking outside the modal-box intentionally does NOT close it.
            // Only the CANCEL button (or a successful password update) closes this modal.

            // ---------- Eye icon toggle (bound once, works immediately) ----------
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

            // ---------- Live validation ----------
            function validatePasswords() {
                const pass = $passwordInput.val();
                const conf = $confirmationInput.val();
                let isValid = true;

                // character counter
                $charCount.text(pass.length + ' / ' + MAX_LEN);

                // password length feedback
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

                // confirmation match feedback
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

            // ---------- Handle Form Submit ----------
            $form.on('submit', function(e) {
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
                    url: `/api/users/${contactId}/password`,
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
                            closeModal();
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
        });
    </script>
@endsection