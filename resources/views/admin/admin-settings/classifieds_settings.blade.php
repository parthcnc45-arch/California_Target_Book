@extends('layouts.portal')

@section('portal_styles')
    <style>
        .settings-card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            padding: 24px;
        }
        .settings-card-title {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .form-group-custom {
            margin-bottom: 18px;
        }
        .form-group-custom label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
        .form-control-custom {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            color: #0f172a;
            transition: border-color 0.15s ease-in-out;
        }
        .form-control-custom:focus {
            border-color: #1e3a8a;
            outline: none;
        }
        .btn-save-settings {
            background-color: #d32f2f;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 13px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-save-settings:hover {
            background-color: #b71c1c;
        }
        
        /* Ad Categories Styling */
        .category-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .category-row:last-child {
            border-bottom: none;
        }
        .category-left {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
        }
        .drag-handle {
            color: #cbd5e1;
            font-size: 18px;
            cursor: move;
        }
        .category-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .active-ads-count {
            font-size: 12.5px;
            color: #94a3b8;
        }
        .btn-cat-outline {
            border: 1.5px solid #d32f2f;
            color: #d32f2f;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-cat-outline:hover {
            background-color: #fee2e2;
        }
        .btn-cat-grey {
            background-color: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            font-size: 12.5px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-cat-grey:hover {
            background-color: #f1f5f9;
        }
        .btn-cat-delete {
            background-color: #fee2e2;
            color: #ef4444;
            border: 1px solid #fca5a5;
            font-size: 12.5px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-cat-delete:hover {
            background-color: #fecaca;
        }
        .btn-add-category, .btn-add-pricing {
            background-color: #d32f2f;
            color: #ffffff;
            border: none;
            padding: 6px 14px;
            font-size: 12.5px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-add-category:hover, .btn-add-pricing:hover {
            background-color: #b71c1c;
        }

        /* Custom Modal Overlay */
        .cat-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(4px);
        }

        .cat-modal {
            background: #ffffff;
            border-radius: 12px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            animation: modalFadeIn 0.2s ease-out;
        }

        @keyframes modalFadeIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .cat-modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cat-modal-title {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        .cat-modal-close {
            background: transparent;
            border: none;
            font-size: 20px;
            color: #94a3b8;
            cursor: pointer;
        }

        .cat-modal-close:hover {
            color: #475569;
        }

        .cat-modal-body {
            padding: 24px;
        }

        .cat-modal-footer {
            padding: 16px 24px;
            background-color: #f8fafc;
            border-top: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Custom switch toggle styling */
        .switch-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        .switch-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #475569;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
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
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #d32f2f;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        /* Custom Pagination Styling */
        .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            padding: 0;
            margin: 20px 0 0 0;
            justify-content: center;
        }
        .pagination li {
            margin: 0;
        }
        .pagination li a, .pagination li span {
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            color: #475569;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            background: #ffffff;
            transition: all 0.15s ease-in-out;
        }
        .pagination li a:hover {
            background-color: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
        }
        .pagination li.active span {
            background-color: #d32f2f;
            border-color: #d32f2f;
            color: #ffffff;
        }
        .pagination li.disabled span {
            color: #94a3b8;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('portal_content')
    <!-- Toast Notification Container -->
    <div id="settings-toast-container" style="position: fixed; top: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 12px; pointer-events: none;"></div>

    <div class="section-header" style="justify-content: space-between; display: flex; align-items: center; margin-bottom: 24px;">
        <div class="header-title-container">
            <h1 class="header-title">Classifieds Settings</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Ad Categories Card -->
            <div class="settings-card">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 20px;">
                    <span style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 700; color: #0f172a;">Ad Categories</span>
                    <button type="button" class="btn-add-category" id="btnAddCategory">
                        <i class="bi bi-plus"></i> Add Category
                    </button>
                </div>
                
                <div class="category-list">
                    @foreach($categories as $category)
                        <!-- Category Item -->
                        <div class="category-row" data-id="{{ $category->id }}" data-status="{{ $category->status }}">
                          <div class="category-left">
                            <span>{{ $category->name }}</span>
                          </div>
                          <div class="category-right">
                            <button type="button" class="btn-cat-outline">Edit</button>
                          </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination Links -->
                <div style="margin-top: 15px; display: flex; justify-content: center;">
                    {!! $categories->appends(request()->query())->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Pricing & Rates Card -->
            <div class="settings-card">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 20px;">
                    <span style="font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 700; color: #0f172a;">Pricing & Rates</span>
                    <button type="button" class="btn-add-pricing" id="btnAddPricing">
                        <i class="bi bi-plus"></i> Add Pricing & Rates
                    </button>
                </div>
                
                <div class="pricing-list">
                    @foreach($rates as $rate)
                        @php
                            $rateTitle = $rate->title ?? $rate->name;
                            $rateAmt = $rate->rate_amount ? round($rate->rate_amount) : '';
                            $rateDays = $rate->days ?? '';
                            $details = '';
                            if ($rateAmt && $rateDays) {
                                $details = " (\${$rateAmt} / {$rateDays} Days)";
                            } elseif ($rateAmt) {
                                $details = " (\${$rateAmt})";
                            }
                        @endphp
                        <div class="category-row pricing-row" data-id="{{ $rate->id }}" data-title="{{ $rateTitle }}" data-amount="{{ $rateAmt }}" data-days="{{ $rateDays }}" data-status="{{ $rate->status ?? 'Show' }}">
                          <div class="category-left">
                            <span>{{ $rateTitle }}{{ $details }}</span>
                          </div>
                          <div class="category-right">
                            <button type="button" class="btn-cat-outline btn-edit-pricing">Edit</button>
                          </div>
                        </div>
                    @endforeach
                </div>

                <!-- Rates Pagination Links -->
                <div style="margin-top: 15px; display: flex; justify-content: center;">
                    {!! $rates->appends(request()->query())->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Category Modal Overlay -->
    <div class="cat-modal-overlay" id="categoryModalOverlay">
        <div class="cat-modal">
            <div class="cat-modal-header">
                <span class="cat-modal-title" id="modalTitle">Add Category</span>
                <button type="button" class="cat-modal-close" id="btnModalClose">&times;</button>
            </div>
            
            <div class="cat-modal-body">
                <div class="form-group-custom">
                    <label for="modal-cat-name">Category Name</label>
                    <input type="text" id="modal-cat-name" class="form-control-custom" placeholder="e.g. Help Wanted">
                </div>
                
                <div class="switch-container">
                    <span class="switch-label">Show Category on Public Page</span>
                    <label class="switch">
                        <input type="checkbox" id="modal-cat-status" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
            
            <div class="cat-modal-footer">
                <div>
                    <!-- Only show for editing -->
                    <button type="button" class="btn-cat-delete" id="btnModalDelete" style="display: none;">Delete Category</button>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn-cat-grey" id="btnModalCancel">Cancel</button>
                    <button type="button" class="btn-save-settings" id="btnModalSave" style="margin-top: 0; padding: 8px 20px;">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Pricing Modal Overlay -->
    <div class="cat-modal-overlay" id="pricingModalOverlay">
        <div class="cat-modal">
            <div class="cat-modal-header">
                <span class="cat-modal-title" id="pricingModalTitle">Add Pricing & Rate</span>
                <button type="button" class="cat-modal-close" id="btnPriceModalClose">&times;</button>
            </div>
            
            <div class="cat-modal-body">
                <div class="form-group-custom">
                    <label for="modal-price-title">Rate Title (e.g. Weekly, Monthly)</label>
                    <input type="text" id="modal-price-title" class="form-control-custom" placeholder="e.g. Weekly Ad Rate">
                </div>

                <div class="row">
                    <div class="col-md-6 form-group-custom">
                        <label for="modal-price-amount">Price Amount ($)</label>
                        <input type="number" id="modal-price-amount" class="form-control-custom" placeholder="e.g. 165" min="0">
                    </div>
                    <div class="col-md-6 form-group-custom">
                        <label for="modal-price-days">Duration (Days)</label>
                        <input type="number" id="modal-price-days" class="form-control-custom" placeholder="e.g. 7" min="1">
                    </div>
                </div>
                
                <div class="switch-container">
                    <span class="switch-label">Show on Public Page</span>
                    <label class="switch">
                        <input type="checkbox" id="modal-price-status" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
            
            <div class="cat-modal-footer">
                <div>
                    <!-- Only show for editing -->
                    <button type="button" class="btn-cat-delete" id="btnPriceModalDelete" style="display: none;">Delete Rate</button>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn-cat-grey" id="btnPriceModalCancel">Cancel</button>
                    <button type="button" class="btn-save-settings" id="btnPriceModalSave" style="margin-top: 0; padding: 8px 20px;">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Delete Confirmation Modal Overlay -->
    <div class="cat-modal-overlay" id="confirmModalOverlay" style="z-index: 2100;">
        <div class="cat-modal" style="max-width: 400px;">
            <div class="cat-modal-header">
                <span class="cat-modal-title">Delete Category</span>
                <button type="button" class="cat-modal-close" id="btnConfirmClose">&times;</button>
            </div>
            
            <div class="cat-modal-body" style="padding: 20px 24px;">
                <p style="font-size: 14px; color: #475569; margin: 0;">Are you sure you want to delete this category?</p>
            </div>
            
            <div class="cat-modal-footer" style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn-cat-grey" id="btnConfirmCancel">Cancel</button>
                <button type="button" class="btn-save-settings" id="btnConfirmYes" style="margin-top: 0; padding: 8px 20px; background-color: #d32f2f;">Delete</button>
            </div>
        </div>
    </div>

    <!-- jQuery and scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Custom Toast Notification System
        function showToast(message, type = 'success') {
            const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
            const bg = type === 'success' ? '#10b981' : '#ef4444';
            const toastHtml = `
                <div class="custom-toast" style="background: ${bg}; color: #ffffff; padding: 14px 20px; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); display: flex; align-items: center; gap: 10px; font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 600; min-width: 280px; transform: translateX(120%); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s; opacity: 0; pointer-events: auto; margin-bottom: 8px;">
                    <i class="bi ${icon}"></i>
                    <span>${message}</span>
                </div>
            `;
            const $toast = $(toastHtml);
            $('#settings-toast-container').append($toast);
            
            // Trigger sliding animation
            setTimeout(() => {
                $toast.css({ 'transform': 'translateX(0)', 'opacity': '1' });
            }, 50);

            // Remove toast after 3 seconds
            setTimeout(() => {
                $toast.css({ 'transform': 'translateX(120%)', 'opacity': '0' });
                setTimeout(() => {
                    $toast.remove();
                }, 300);
            }, 3000);
        }

        $(document).ready(function() {
            let activeCategoryRow = null;

            // Setup AJAX CSRF token header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // Re-bind click handler function to allow edit on dynamically added elements
            function bindEditEvents() {
                $('.btn-cat-outline').off('click').on('click', function() {
                    activeCategoryRow = $(this).closest('.category-row');
                    const catName = activeCategoryRow.find('.category-left span').text().trim();
                    const catStatus = activeCategoryRow.attr('data-status') || 'Show';
                    
                    $('#modalTitle').text('Edit Category');
                    $('#modal-cat-name').val(catName);
                    $('#modal-cat-status').prop('checked', catStatus === 'Show');
                    $('#btnModalDelete').show();
                    $('#categoryModalOverlay').css('display', 'flex');
                });
            }

            // Bind initially loaded rows
            bindEditEvents();

            // Trigger Add Category Modal
            $('#btnAddCategory').on('click', function() {
                activeCategoryRow = null;
                $('#modalTitle').text('Add Category');
                $('#modal-cat-name').val('');
                $('#modal-cat-status').prop('checked', true);
                $('#btnModalDelete').hide();
                $('#categoryModalOverlay').css('display', 'flex');
            });

            // Modal Cancel & Close actions
            $('#btnModalClose, #btnModalCancel, #categoryModalOverlay').on('click', function(e) {
                if (e.target === this) {
                    $('#categoryModalOverlay').hide();
                }
            });

            $('.cat-modal').on('click', function(e) {
                e.stopPropagation();
            });

            // Save/Update Category Action
            $('#btnModalSave').on('click', function() {
                const nameVal = $('#modal-cat-name').val().trim();
                const statusVal = $('#modal-cat-status').is(':checked') ? 'Show' : 'Hide';

                if (!nameVal) {
                    showToast('Please enter a category name.', 'error');
                    return;
                }

                if (activeCategoryRow) {
                    // Update category AJAX
                    const categoryId = activeCategoryRow.attr('data-id');
                    $.ajax({
                        url: `/ctb-admin/new/classifieds/categories/${categoryId}`,
                        type: 'PUT',
                        data: {
                            name: nameVal,
                            status: statusVal
                        },
                        success: function(response) {
                            activeCategoryRow.find('.category-left span').text(response.name);
                            activeCategoryRow.attr('data-status', response.status);
                            showToast('Category updated successfully!');
                            $('#categoryModalOverlay').hide();
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                showToast(Object.values(xhr.responseJSON.errors).flat().join('\n'), 'error');
                            } else {
                                showToast('Error updating category. Please try again.', 'error');
                            }
                        }
                    });
                } else {
                    // Add new category AJAX
                    $.ajax({
                        url: '/ctb-admin/new/classifieds/categories',
                        type: 'POST',
                        data: {
                            name: nameVal,
                            status: statusVal
                        },
                        success: function(response) {
                            const newHtml = `
                                <div class="category-row" data-id="${response.id}" data-status="${response.status}">
                                  <div class="category-left">
                                    <span>${response.name}</span>
                                  </div>
                                  <div class="category-right">
                                    <button type="button" class="btn-cat-outline">Edit</button>
                                  </div>
                                </div>
                            `;
                            $('.category-list').append(newHtml);
                            bindEditEvents(); // Rebind handlers
                            showToast('Category added successfully!');
                            $('#categoryModalOverlay').hide();
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                showToast(Object.values(xhr.responseJSON.errors).flat().join('\n'), 'error');
                            } else {
                                showToast('Error adding category. Please try again.', 'error');
                            }
                        }
                    });
                }
            });

            // Delete Category Action (Trigger Custom Confirmation Modal)
            $('#btnModalDelete').on('click', function() {
                if (activeCategoryRow) {
                    $('#confirmModalOverlay').css('display', 'flex');
                }
            });

            // Close Custom Confirmation Modal
            $('#btnConfirmClose, #btnConfirmCancel, #confirmModalOverlay').on('click', function(e) {
                if (e.target === this) {
                    $('#confirmModalOverlay').hide();
                }
            });

            // Confirm Delete Yes action
            $('#btnConfirmYes').on('click', function() {
                if (activeCategoryRow) {
                    const categoryId = activeCategoryRow.attr('data-id');
                    $.ajax({
                        url: `/ctb-admin/new/classifieds/categories/${categoryId}`,
                        type: 'DELETE',
                        success: function() {
                            activeCategoryRow.remove();
                            showToast('Category deleted successfully!');
                            $('#confirmModalOverlay').hide();
                            $('#categoryModalOverlay').hide();
                        },
                        error: function() {
                            showToast('Error deleting category. Please try again.', 'error');
                            $('#confirmModalOverlay').hide();
                        }
                    });
                }
            });

            // PRICING & RATES MODAL LOGIC
            let activePricingRow = null;

            function bindPricingEditEvents() {
                $('.btn-edit-pricing').off('click').on('click', function() {
                    activePricingRow = $(this).closest('.pricing-row');
                    const title = activePricingRow.attr('data-title') || '';
                    const amount = activePricingRow.attr('data-amount') || '';
                    const days = activePricingRow.attr('data-days') || '';
                    const status = activePricingRow.attr('data-status') || 'Show';

                    $('#pricingModalTitle').text('Edit Pricing & Rate');
                    $('#modal-price-title').val(title);
                    $('#modal-price-amount').val(amount);
                    $('#modal-price-days').val(days);
                    $('#modal-price-status').prop('checked', status === 'Show');
                    $('#btnPriceModalDelete').show();
                    $('#pricingModalOverlay').css('display', 'flex');
                });
            }

            bindPricingEditEvents();

            $('#btnAddPricing').on('click', function() {
                activePricingRow = null;
                $('#pricingModalTitle').text('Add Pricing & Rate');
                $('#modal-price-title').val('');
                $('#modal-price-amount').val('');
                $('#modal-price-days').val('');
                $('#modal-price-status').prop('checked', true);
                $('#btnPriceModalDelete').hide();
                $('#pricingModalOverlay').css('display', 'flex');
            });

            $('#btnPriceModalClose, #btnPriceModalCancel, #pricingModalOverlay').on('click', function(e) {
                if (e.target === this) {
                    $('#pricingModalOverlay').hide();
                }
            });

            $('#btnPriceModalSave').on('click', function() {
                const titleVal = $('#modal-price-title').val().trim();
                const amountVal = $('#modal-price-amount').val().trim();
                const daysVal = $('#modal-price-days').val().trim();
                const statusVal = $('#modal-price-status').is(':checked') ? 'Show' : 'Hide';

                if (!titleVal) {
                    showToast('Please enter a rate title.', 'error');
                    return;
                }

                if (activePricingRow && activePricingRow.attr('data-id')) {
                    // Update rate AJAX
                    const rateId = activePricingRow.attr('data-id');
                    $.ajax({
                        url: `/ctb-admin/new/classifieds/rates/${rateId}`,
                        type: 'PUT',
                        data: {
                            title: titleVal,
                            amount: amountVal,
                            days: daysVal,
                            status: statusVal
                        },
                        success: function(response) {
                            const rTitle = response.title || response.name;
                            const rAmt = response.rate_amount ? Math.round(response.rate_amount) : '';
                            const rDays = response.days || '';
                            let details = '';
                            if (rAmt && rDays) {
                                details = ` ($${rAmt} / ${rDays} Days)`;
                            } else if (rAmt) {
                                details = ` ($${rAmt})`;
                            }
                            activePricingRow.attr('data-title', rTitle);
                            activePricingRow.attr('data-amount', rAmt);
                            activePricingRow.attr('data-days', rDays);
                            activePricingRow.attr('data-status', response.status || 'Show');
                            activePricingRow.find('.category-left span').text(`${rTitle}${details}`);
                            showToast('Pricing & Rate updated successfully!');
                            $('#pricingModalOverlay').hide();
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                showToast(Object.values(xhr.responseJSON.errors).flat().join('\n'), 'error');
                            } else {
                                showToast('Error updating rate. Please try again.', 'error');
                            }
                        }
                    });
                } else {
                    // Add new rate AJAX
                    $.ajax({
                        url: '/ctb-admin/new/classifieds/rates',
                        type: 'POST',
                        data: {
                            title: titleVal,
                            amount: amountVal,
                            days: daysVal,
                            status: statusVal
                        },
                        success: function(response) {
                            const rTitle = response.title || response.name;
                            const rAmt = response.rate_amount ? Math.round(response.rate_amount) : '';
                            const rDays = response.days || '';
                            let details = '';
                            if (rAmt && rDays) {
                                details = ` ($${rAmt} / ${rDays} Days)`;
                            } else if (rAmt) {
                                details = ` ($${rAmt})`;
                            }
                            const newPricingHtml = `
                                <div class="category-row pricing-row" data-id="${response.id}" data-title="${rTitle}" data-amount="${rAmt}" data-days="${rDays}" data-status="${response.status || 'Show'}">
                                  <div class="category-left">
                                    <span>${rTitle}${details}</span>
                                  </div>
                                  <div class="category-right">
                                    <button type="button" class="btn-cat-outline btn-edit-pricing">Edit</button>
                                  </div>
                                </div>
                            `;
                            $('.pricing-list').append(newPricingHtml);
                            bindPricingEditEvents();
                            showToast('Pricing & Rate added successfully!');
                            $('#pricingModalOverlay').hide();
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                showToast(Object.values(xhr.responseJSON.errors).flat().join('\n'), 'error');
                            } else {
                                showToast('Error adding rate. Please try again.', 'error');
                            }
                        }
                    });
                }
            });

            $('#btnPriceModalDelete').on('click', function() {
                if (activePricingRow) {
                    const rateId = activePricingRow.attr('data-id');
                    if (rateId && confirm('Are you sure you want to delete this rate?')) {
                        $.ajax({
                            url: `/ctb-admin/new/classifieds/rates/${rateId}`,
                            type: 'DELETE',
                            success: function() {
                                activePricingRow.remove();
                                showToast('Pricing & Rate deleted successfully!');
                                $('#pricingModalOverlay').hide();
                            },
                            error: function() {
                                showToast('Error deleting rate. Please try again.', 'error');
                            }
                        });
                    } else if (!rateId) {
                        activePricingRow.remove();
                        showToast('Pricing & Rate deleted successfully!');
                        $('#pricingModalOverlay').hide();
                    }
                }
            });
        });
    </script>
    
@endsection
