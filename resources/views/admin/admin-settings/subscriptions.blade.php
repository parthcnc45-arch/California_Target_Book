@extends('layouts.portal')



@section('portal_content')
    <div class="section-header as-subscriptions-1">
        <div class="header-title-container">
            <h1 class="header-title">Subscriptions</h1>
        </div>
        <a href="/ctb-admin/new/subscriptions/add" class="btn-add-subscription">
            <i class="bi bi-plus-lg"></i> ADD
        </a>
    </div>

    <!-- Stats Row -->
    <div class="as-subscriptions-2">
        <div class="portal-card as-subscriptions-3">
            <div class="as-subscriptions-4">Total Subscriptions</div>
            <div class="as-subscriptions-5" id="stat-total">-</div>
        </div>
        <div class="portal-card as-subscriptions-6">
            <div class="as-subscriptions-4">Active</div>
            <div class="as-subscriptions-5" id="stat-active">-</div>
        </div>
        <div class="portal-card as-subscriptions-7">
            <div class="as-subscriptions-4">Inactive</div>
            <div class="as-subscriptions-5" id="stat-inactive">-</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card as-subscriptions-8">
        <div class="card-header-custom as-subscriptions-9">
            <div class="as-subscriptions-10">
                <h2 class="card-title-custom as-subscriptions-11">Subscribers List</h2>
                <div class="as-subscriptions-12">
                    <i class="bi bi-search as-subscriptions-13"></i>
                    <input type="text" class="form-input-style as-subscriptions-14" id="search-subscribers" placeholder="Search companies or contacts...">
                </div>
            </div>
            
            <!-- Filters Row -->
            <div class="as-subscriptions-15">
                <div class="as-subscriptions-16">
                    <span class="as-subscriptions-17">Status</span>
                    <select class="form-input-style as-subscriptions-18" id="filter-status">
                        <option value="all">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="as-subscriptions-16">
                    <span class="as-subscriptions-17">Term</span>
                    <select class="form-input-style as-subscriptions-18" id="filter-frequency">
                        <option value="all">All Terms</option>
                        <option value="0">Trial</option>
                        <option value="12">12 Months</option>
                        <option value="24">24 Months</option>
                    </select>
                </div>
                <div class="as-subscriptions-16">
                    <span class="as-subscriptions-17">Starts On (From)</span>
                    <input type="date" class="form-input-style as-subscriptions-19" id="filter-starts-on">
                </div>
                <div class="as-subscriptions-16">
                    <span class="as-subscriptions-17">Ends On (To)</span>
                    <input type="date" class="form-input-style as-subscriptions-19" id="filter-ends-on">
                </div>
                <!-- Clear Filters Button -->
                <div class="as-subscriptions-20">
                    <button class="as-subscriptions-21" id="btn-clear-filters" onmouseenter="this.style.backgroundColor='#e2e8f0'" onmouseleave="this.style.backgroundColor='#f1f5f9'">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table" id="subscribers-table">
                <thead>
                    <tr>
                        <th class="as-subscriptions-22">Status</th>
                        <th class="as-subscriptions-24">Customer / Email</th>
                        <th class="as-subscriptions-25">Product</th>
                        <th class="as-subscriptions-26">Term</th>
                        <th class="as-subscriptions-27">Starts On</th>
                        <th class="as-subscriptions-27">Ends On</th>
                        <th class="as-subscriptions-28 text-center" style="text-align: center !important;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS loaded data will be injected here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Footer -->
        <div class="as-subscriptions-29">
            <div class="as-subscriptions-30" id="pagination-info">
                Showing 1 to 5 of 9 entries
            </div>
            <div class="as-subscriptions-31" id="pagination-buttons">
                <!-- Pagination buttons will be dynamically injected -->
            </div>
        </div>
    </div>
@endsection

@section('portal_scripts')
    <script>
        $(document).ready(function () {
            const apiToken = "{{ Auth::user()->api_token }}";
            const $searchInput = $('#search-subscribers');
            const $statusFilter = $('#filter-status');
            const $frequencyFilter = $('#filter-frequency');
            const $startsOnFilter = $('#filter-starts-on');
            const $endsOnFilter = $('#filter-ends-on');
            const $btnClearFilters = $('#btn-clear-filters');
            const $tbody = $('#subscribers-table tbody');
            const $paginationInfo = $('#pagination-info');
            const $paginationButtons = $('#pagination-buttons');

            let allSubscriptions = [];
            let currentPage = 1;
            let pageSize = 10;

            initRowsPerPage({
                targetSelector: '.as-subscriptions-15',
                itemClass: 'as-subscriptions-16',
                labelClass: 'as-subscriptions-17',
                labelName: 'Per page',
                defaultSize: pageSize,
                onChange: function(newSize) {
                    pageSize = newSize;
                    currentPage = 1;
                    loadSubscriptions();
                }
            });

            function formatDate(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) return dateStr;
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const month = months[date.getMonth()];
                const day = date.getDate();
                let suffix = 'th';
                if (day === 1 || day === 21 || day === 31) suffix = 'st';
                else if (day === 2 || day === 22) suffix = 'nd';
                else if (day === 3 || day === 23) suffix = 'rd';
                return `${month} ${day}${suffix}, ${date.getFullYear()}`;
            }

            function formatFrequency(freq) {
                if (freq === 0) return 'Trial';
                if (freq === 12) return '12 Months';
                if (freq === 24) return '24 Months';
                return freq ? `${freq} Months` : '';
            }

            function updateStats(stats) {
                if (!stats) return;
                $('#stat-total').text(stats.total);
                $('#stat-active').text(stats.active);
                $('#stat-inactive').text(stats.inactive);
            }

            function loadSubscriptions() {
                const searchVal = $searchInput.val().trim();
                const statusVal = $statusFilter.val();
                const freqVal = $frequencyFilter.val();
                const startsOnVal = $startsOnFilter.val();
                const endsOnVal = $endsOnFilter.val();

                // Toggle Clear Filters button visibility
                const isFiltered = searchVal !== '' || statusVal !== 'all' || freqVal !== 'all' || startsOnVal !== '' || endsOnVal !== '';
                if (isFiltered) {
                    $btnClearFilters.css('display', 'inline-flex');
                } else {
                    $btnClearFilters.css('display', 'none');
                }

                $tbody.html(`<tr><td class="as-subscriptions-32" colspan="7"><i class="bi bi-arrow-repeat spin as-subscriptions-38"></i> Loading subscriptions...</td></tr>`);

                $.ajax({
                    url: '/api/subscriptions',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json'
                    },
                    data: {
                        search: searchVal,
                        status: statusVal,
                        frequency: freqVal,
                        starts_on: startsOnVal,
                        ends_on: endsOnVal,
                        page: currentPage,
                        limit: pageSize
                    },
                    success: function(res) {
                        allSubscriptions = res.data || [];
                        updateStats(res.stats);
                        renderSubscriptions(allSubscriptions, res.pagination);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching subscriptions:', error);
                        $tbody.html(`<tr><td class="as-subscriptions-39" colspan="7">Failed to load subscriptions. Please try again later.</td></tr>`);
                    }
                });
            }

            function renderSubscriptions(data, pagination) {
                $tbody.empty();
                if (!data || data.length === 0) {
                    $tbody.append(`<tr><td class="as-subscriptions-32" colspan="7">No subscriptions found</td></tr>`);
                    $paginationInfo.text('Showing 0 to 0 of 0 entries');
                    renderPaginationButtons(1);
                    return;
                }

                data.forEach(sub => {
                    const statusStyle = sub.isActive ? '' : 'background-color: #fef2f2; color: #ef4444;';
                    const startsOnStr = sub.cycle ? sub.cycle.starts_on : null;
                    const endsOnStr = sub.cycle ? sub.cycle.ends_on : null;

                    const rowHtml = `
                        <tr>
                            <td><span class="status-pill-completed" style="${statusStyle}">${sub.isActive ? 'Active' : 'Inactive'}</span></td>
                            <td class="as-digital-38">
                                <div class="as-digital-39">${sub.baseAccount ? sub.baseAccount.name : 'N/A'}</div>
                                <div class="as-digital-40">${sub.baseAccount ? sub.baseAccount.email : ''}</div>
                              </td>
                              <td class="as-subscriptions-35">${sub.productName || '—'}</td>
                              <td class="as-subscriptions-36">${formatFrequency(sub.frequency)}</td>
                              <td class="as-subscriptions-36">${formatDate(startsOnStr)}</td>
                              <td class="as-subscriptions-36">${formatDate(endsOnStr)}</td>
                              <td class="as-classifieds-76 text-center" style="text-align: center !important;">
                                  <div class="dropdown table-dropdown-container" style="display: inline-block;">
                                      <button class="table-action-edit" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
                                          <i class="bi bi-three-dots"></i>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end as-classifieds-77">
                                          <li><a class="dropdown-item as-classifieds-78" href="/ctb-admin/new/subscriptions/${sub.id}"><i class="bi bi-pencil as-classifieds-79"></i> Edit</a></li>
                                      </ul>
                                  </div>
                              </td>
                          </tr>
                      `;
                      $tbody.append(rowHtml);
                  });

                  $paginationInfo.text(`Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total || 0} entries`);
                  renderPaginationButtons(pagination.last_page);
              }

              function renderPaginationButtons(totalPages) {
                  $paginationButtons.empty();

                  // Previous Button
                  const $prevBtn = $('<button>').text('Previous');
                  styleButton($prevBtn, currentPage === 1);
                  if (currentPage > 1) {
                      $prevBtn.on('click', () => {
                          currentPage--;
                          loadSubscriptions();
                      });
                  }
                  $paginationButtons.append($prevBtn);

                  // Determine pages to show
                  const pages = [];
                  const delta = 1;
                  
                  for (let i = 1; i <= totalPages; i++) {
                      if (i === 1 || i === totalPages || (i >= currentPage - delta && i <= currentPage + delta)) {
                          pages.push(i);
                      }
                  }

                  let lastPage = 0;
                  pages.forEach(page => {
                      if (lastPage !== 0) {
                          if (page - lastPage === 2) {
                              const $pageBtn = $('<button>').text(lastPage + 1);
                              styleButton($pageBtn, false, currentPage === lastPage + 1);
                              const tempVal = lastPage + 1;
                              $pageBtn.on('click', () => {
                                  currentPage = tempVal;
                                  loadSubscriptions();
                              });
                              $paginationButtons.append($pageBtn);
                          } else if (page - lastPage > 2) {
                              const $ellipsis = $('<span>').text('...').css({
                                  padding: '6px 12px',
                                  color: '#94a3b8',
                                  fontSize: '13px'
                              });
                              $paginationButtons.append($ellipsis);
                          }
                      }
                      
                      const $pageBtn = $('<button>').text(page);
                      styleButton($pageBtn, false, currentPage === page);
                      $pageBtn.on('click', () => {
                          currentPage = page;
                          loadSubscriptions();
                      });
                      $paginationButtons.append($pageBtn);
                      
                      lastPage = page;
                  });

                  // Next Button
                  const $nextBtn = $('<button>').text('Next');
                  styleButton($nextBtn, currentPage === totalPages);
                  if (currentPage < totalPages) {
                      $nextBtn.on('click', () => {
                          currentPage++;
                          loadSubscriptions();
                      });
                  }
                  $paginationButtons.append($nextBtn);
              }

            function styleButton($btn, isDisabled, isActive = false) {
                $btn.css({
                    padding: '6px 12px',
                    borderRadius: '6px',
                    fontSize: '13px',
                    fontWeight: '500',
                    border: '1px solid #e2e8f0',
                    transition: 'all 0.15s ease-in-out'
                });
                
                if (isDisabled) {
                    $btn.css({
                        background: '#f8fafc',
                        color: '#94a3b8',
                        cursor: 'not-allowed'
                    });
                } else if (isActive) {
                    $btn.css({
                        background: '#0f172a',
                        color: '#ffffff',
                        borderColor: '#0f172a',
                        cursor: 'default'
                    });
                } else {
                    $btn.css({
                        background: '#ffffff',
                        color: '#475569',
                        cursor: 'pointer'
                    });
                    
                    $btn.on('mouseenter', function() {
                        $(this).css({
                            background: '#f8fafc',
                            borderColor: '#cbd5e1'
                        });
                    }).on('mouseleave', function() {
                        $(this).css({
                            background: '#ffffff',
                            borderColor: '#e2e8f0'
                        });
                    });
                }
            }

            // Listeners
            if ($searchInput.length) {
                $searchInput.on('input', () => {
                    currentPage = 1;
                    loadSubscriptions();
                });
            }
            $('#filter-status, #filter-frequency, #filter-starts-on, #filter-ends-on').on('change', () => {
                currentPage = 1;
                loadSubscriptions();
            });
            if ($btnClearFilters.length) {
                $btnClearFilters.on('click', () => {
                    $searchInput.val('');
                    $('#filter-status').val('all');
                    $('#filter-frequency').val('all');
                    $('#filter-starts-on').val('');
                    $('#filter-ends-on').val('');
                    currentPage = 1;
                    loadSubscriptions();
                });
            }

            // Load data from API
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                `)
                .appendTo('head');

            loadSubscriptions();
        });
    </script>
@endsection
