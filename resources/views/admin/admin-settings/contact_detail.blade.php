@extends('layouts.portal')



@section('portal_content')
    <div class="details-container">
        <!-- Header -->
        <div class="as-contact-detail-1">
            <div>
                <div class="subscriber-tag">Subscriber</div>
                <h1 class="subscriber-name">{{ $contact->name() }}</h1>
            </div>
            <a href="javascript:history.back()" class="btn-export-csv as-contact-detail-2">
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
                                    <i class="bi bi-pencil-fill as-contact-detail-3"></i>
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
                            <span class="detail-value-span as-contact-detail-4">{{ $contact->role ?? 'Subscriber' }}</span>
                        </td>
                        <td class="detail-label">Company</td>
                        <td class="detail-value">
                            @if($contact->company)
                                <span class="text-brand-red">{{ $contact->company->name }}</span>
                            @else
                                <span class="detail-value-span as-contact-detail-5">Not Specified</span>
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
                                <span class="detail-value-span as-contact-detail-5">N/A</span>
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
                                <span class="detail-value-span as-contact-detail-5">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label as-contact-detail-6">Notes</td>
                        <td colspan="3" class="detail-value as-contact-detail-7">
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
    <div class="as-contact-detail-8" id="edit-account-modal">
        <div class="modal-box as-contact-detail-9">
            <div class="as-contact-detail-10">
                <h3 class="as-contact-detail-11">Update Account</h3>

                <form id="edit-account-form" novalidate>
                    <div class="as-contact-detail-12">
                        <div class="as-contact-detail-13">
                            <label class="as-contact-detail-14">First Name *</label>
                            <input class="as-contact-detail-15" type="text" id="edit-first-name" required maxlength="255" value="{{ $contact->first_name }}">
                        </div>
                        <div class="as-contact-detail-13">
                            <label class="as-contact-detail-14">Last Name</label>
                            <input class="as-contact-detail-15" type="text" id="edit-last-name" maxlength="255" value="{{ $contact->last_name }}">
                        </div>
                    </div>

                    <div class="as-contact-detail-12">
                        <div class="as-contact-detail-13">
                            <label class="as-contact-detail-14">Email *</label>
                            <input class="as-contact-detail-15" type="email" id="edit-email" required maxlength="255" value="{{ $contact->email }}">
                        </div>
                        <div class="as-contact-detail-13">
                            <label class="as-contact-detail-14">Phone Number</label>
                            <input class="as-contact-detail-15" type="text" id="edit-phone-number" maxlength="30" value="{{ $contact->phone_number }}">
                        </div>
                    </div>

                    <div class="as-contact-detail-16">
                        <label class="as-contact-detail-14">Notes</label>
                        <textarea class="as-contact-detail-17" id="edit-notes" rows="3">{{ $contact->notes }}</textarea>
                    </div>

                    <div class="as-contact-detail-18" id="edit-modal-error-message"></div>
                    <div class="as-contact-detail-19" id="edit-modal-success-message"></div>

                    <div class="as-contact-detail-20">
                        <button class="as-contact-detail-21" type="button" id="btn-cancel-edit-account">CANCEL</button>
                        <button class="as-contact-detail-22" type="submit" id="btn-submit-edit-account">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="as-contact-detail-8" id="change-password-modal">
        <div class="modal-box as-contact-detail-23">
            <div class="as-contact-detail-10">
                <h3 class="as-contact-detail-24">Change Subscriber Password</h3>
                <div class="as-contact-detail-25">{{ $contact->name() }}</div>

                <form id="change-password-form" novalidate>
                    <div class="as-contact-detail-26">
                        <label class="as-contact-detail-14">Password *</label>
                        <div class="password-input-wrapper as-contact-detail-27">
                            <input class="as-contact-detail-28" type="password" id="new-password" required minlength="6" maxlength="72" autocomplete="new-password">
                            <button type="button" class="toggle-password-visibility as-contact-detail-29" data-target="new-password">
                                <i class="bi bi-eye as-contact-detail-30"></i>
                            </button>
                        </div>
                        <div class="field-hint" id="password-hint">
                            <span id="password-hint-text">Minimum 6, maximum 72 characters</span>
                            <span id="password-char-count">0 / 72</span>
                        </div>
                    </div>

                    <div class="as-contact-detail-16">
                        <label class="as-contact-detail-14">Password Confirmation *</label>
                        <div class="password-input-wrapper as-contact-detail-27">
                            <input class="as-contact-detail-28" type="password" id="new-password-confirmation" required minlength="6" maxlength="72" autocomplete="new-password">
                            <button type="button" class="toggle-password-visibility as-contact-detail-29" data-target="new-password-confirmation">
                                <i class="bi bi-eye as-contact-detail-30"></i>
                            </button>
                        </div>
                        <div class="field-hint as-contact-detail-31" id="confirmation-hint"></div>
                    </div>

                    <div class="as-contact-detail-18" id="modal-error-message"></div>
                    <div class="as-contact-detail-19" id="modal-success-message"></div>

                    <div class="as-contact-detail-20">
                        <button class="as-contact-detail-21" type="button" id="btn-cancel-password">CANCEL</button>
                        <button class="as-contact-detail-22" type="submit" id="btn-submit-password">SUBMIT</button>
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

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection