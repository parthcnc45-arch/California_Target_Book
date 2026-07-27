@extends('layouts.portal')



@section('portal_content')
    <!-- Toast Notification Container -->
    <div class="as-class-settings-1" id="settings-toast-container"></div>

    <div class="section-header as-class-settings-2">
        <div class="header-title-container">
            <h1 class="header-title">Classifieds Settings</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Ad Categories Card -->
            <div class="settings-card">
                <div class="as-class-settings-3">
                    <span class="as-class-settings-4">Ad Categories</span>
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
                <div class="as-class-settings-5">
                    {!! $categories->appends(request()->query())->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Pricing & Rates Card -->
            <div class="settings-card">
                <div class="as-class-settings-3">
                    <span class="as-class-settings-4">Pricing & Rates</span>
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
                <div class="as-class-settings-5">
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
                    <button type="button" class="btn-cat-delete as-class-settings-6" id="btnModalDelete">Delete Category</button>
                </div>
                <div class="as-class-settings-7">
                    <button type="button" class="btn-cat-grey" id="btnModalCancel">Cancel</button>
                    <button type="button" class="btn-save-settings as-class-settings-8" id="btnModalSave">Save</button>
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
                    <button type="button" class="btn-cat-delete as-class-settings-6" id="btnPriceModalDelete">Delete Rate</button>
                </div>
                <div class="as-class-settings-7">
                    <button type="button" class="btn-cat-grey" id="btnPriceModalCancel">Cancel</button>
                    <button type="button" class="btn-save-settings as-class-settings-8" id="btnPriceModalSave">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Delete Confirmation Modal Overlay -->
    <div class="cat-modal-overlay as-class-settings-9" id="confirmModalOverlay">
        <div class="cat-modal as-class-settings-10">
            <div class="cat-modal-header">
                <span class="cat-modal-title">Delete Category</span>
                <button type="button" class="cat-modal-close" id="btnConfirmClose">&times;</button>
            </div>
            
            <div class="cat-modal-body as-class-settings-11">
                <p class="as-class-settings-12">Are you sure you want to delete this category?</p>
            </div>
            
            <div class="cat-modal-footer as-class-settings-13">
                <button type="button" class="btn-cat-grey" id="btnConfirmCancel">Cancel</button>
                <button type="button" class="btn-save-settings as-class-settings-14" id="btnConfirmYes">Delete</button>
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
                <div class="custom-toast as-class-settings-15" style="background: ${bg}">
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

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                }
            });

            // Modal Cancel & Close actions
            $('#btnModalClose, #btnModalCancel').on('click', function(e) {
                $('#categoryModalOverlay').hide();
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
            $('#btnConfirmClose, #btnConfirmCancel').on('click', function(e) {
                $('#confirmModalOverlay').hide();
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

            $('#btnPriceModalClose, #btnPriceModalCancel').on('click', function(e) {
                $('#pricingModalOverlay').hide();
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
