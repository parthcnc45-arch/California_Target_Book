<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classifieds | California Target Book</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Site styles -->
  <link rel="stylesheet" href="/css/style_new.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    /* Custom style overrides for public Classifieds page */
    body {
        background-color: #f8fafc;
        font-family: 'Open Sans', sans-serif;
    }
    
    .classifieds-layout {
        display: flex;
        gap: 28px;
        align-items: flex-start;
    }
    
    .sidebar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }
    
    .sidebar-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 12px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-family: 'Montserrat', sans-serif;
    }

    .rate-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13.5px;
        color: #475569;
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .rate-item:last-child {
        border-bottom: none;
    }
    .rate-item .rate-price {
        font-weight: 700;
        color: #c52026;
    }

    .btn-post-ad {
        display: block;
        width: 100%;
        background-color: #c52026;
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        padding: 10px 16px;
        border-radius: 6px;
        margin-top: 16px;
        transition: background-color 0.15s ease-in-out;
        border: none;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }
    .btn-post-ad:hover {
        background-color: #a91b21;
        color: #ffffff;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        font-size: 13.5px;
        color: #475569;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }
    .category-item:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }
    .category-item.active {
        background-color: #fee2e2;
        color: #c52026;
        font-weight: 700;
    }
    .category-count {
        font-size: 11px;
        font-weight: 700;
        background-color: #f1f5f9;
        color: #64748b;
        padding: 2px 8px;
        border-radius: 9999px;
        transition: all 0.15s ease-in-out;
    }
    .category-item.active .category-count {
        background-color: #c52026;
        color: #ffffff;
    }

    /* Listing Grid */
    .listing-section-header {
        display: flex;
        align-items: center;
        margin-top: 0;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #cbd5e1;
        padding-bottom: 8px;
        font-family: 'Montserrat', sans-serif;
    }
    .listing-section-count {
        font-size: 12px;
        font-weight: 700;
        background-color: #1c3a63;
        color: #ffffff;
        padding: 3px 8px;
        border-radius: 9999px;
        margin-left: 8px;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 1024px) {
        .cards-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 768px) {
        .classifieds-layout {
            flex-direction: column;
        }
        .sidebar-area {
            width: 100% !important;
            margin-bottom: 20px;
        }
    }
    @media (max-width: 640px) {
        .cards-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    .classified-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .classified-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    .card-tag {
        font-size: 10.5px;
        font-weight: 700;
        color: #c52026;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .card-org {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
    }
    .card-headline {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 8px;
        line-height: 1.4;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .card-body-text {
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 16px;
        flex-grow: 1;
        height: 80px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }
    
    .card-footer-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
        font-size: 12px;
    }
    .card-expires {
        color: #94a3b8;
        font-weight: 500;
    }
    .card-details-link {
        color: #1c3a63;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }
    .card-details-link:hover {
        text-decoration: underline;
    }

    .view-all-link {
        display: inline-flex;
        align-items: center;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        float: right;
        margin-top: -8px;
        margin-bottom: 24px;
    }
    .view-all-link:hover {
        color: #0f172a;
        text-decoration: underline;
    }

    /* Detail Modal Popup */
    #detail-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 24px;
        transition: all 0.3s ease;
        opacity: 0;
    }
    #detail-modal.modal-open {
        opacity: 1;
    }
    #detail-modal-container {
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    #detail-modal.modal-open #detail-modal-container {
        transform: translateY(0);
    }
    
    .detail-meta-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .detail-meta-val {
        font-size: 14px;
        color: #0f172a;
        font-weight: 500;
        margin-bottom: 16px;
    }

    /* Styles for general form input look (copied for standalone context) */
    .form-input-style {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.15s ease-in-out;
    }
    .form-input-style:focus {
        border-color: #94a3b8;
    }
  </style>
</head>

<body>

  @include('layouts.navbar')

  <!-- Hero Header Banner -->
  <div style="background: linear-gradient(180deg, rgba(16, 28, 51, 0.96) 0%, var(--navy-900) 100%); padding: 100px 24px 60px; text-align: center; color: #ffffff; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container-ctb">
        <h1 style="font-family: var(--font-heading); font-size: 44px; font-weight: 700; color: #ffffff; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Classifieds</h1>
        <p style="font-size: 15px; max-width: 650px; margin: 0 auto 28px auto; color: rgba(255, 255, 255, 0.85); line-height: 1.6; font-weight: 400; font-family: var(--font-heading);">
            Job openings, office space, consulting services, and more — reaching California's political and government professionals.
        </p>
        <div style="display: flex; gap: 14px; justify-content: center; align-items: center; flex-wrap: wrap;">
            <a href="mailto:ads@californiatargetbook.com?subject=Post%20a%20Classified%20Ad" class="btn-ctb btn-red">Post a Classified Ad</a>
            <a href="#rates-section" id="btn-view-rates" class="btn-ctb btn-outline-light">View Ad Rates</a>
        </div>
    </div>
  </div>

  <div class="container-ctb" style="padding-top: 40px; padding-bottom: 80px;">
    <!-- Top Filter & Search controls -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 30px; flex-wrap: wrap;">
        <div style="position: relative; flex: 1; max-width: 400px; min-width: 250px;">
            <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 14px;"></i>
            <input type="text" class="form-input-style" id="search-listings" placeholder="Search classifieds..." style="padding-left: 36px; height: 38px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px; width: 100%;">
        </div>
        <div>
            <select class="form-input-style" id="sort-listings" style="width: 160px; height: 38px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; background-color: #ffffff;">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="expiring">Expiring Soon</option>
            </select>
        </div>
    </div>

    <!-- Main Layout Container -->
    <div class="classifieds-layout">
        <!-- Sidebar Area (Left column) -->
        <div class="sidebar-area" style="width: 260px; flex-shrink: 0;">
            <!-- Ad Rates Card -->
            <div class="sidebar-card" id="rates-section">
                <h3 class="sidebar-title">Ad Rates</h3>
                <p style="font-size: 12px; color: #64748b; line-height: 1.5; margin-top: 0; margin-bottom: 12px;">Ads run newest to oldest within each category. Expiration date shown at end of each ad.</p>
                @if(isset($rates) && count($rates) > 0)
                    @foreach($rates as $rateOption)
                        <div class="rate-item">
                            <span style="font-weight: 500;">{{ $rateOption->title ?? $rateOption->name }}</span>
                            <span class="rate-price">${{ round($rateOption->rate_amount) }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="rate-item">
                        <span style="font-weight: 500;">Weekly</span>
                        <span class="rate-price">$165</span>
                    </div>
                    <div class="rate-item">
                        <span style="font-weight: 500;">Monthly</span>
                        <span class="rate-price">$585</span>
                    </div>
                @endif
                <a href="mailto:ads@californiatargetbook.com?subject=Inquiry%20about%20Post%20an%20Ad" class="btn-post-ad">
                    <i class="bi bi-plus-circle"></i> Post an Ad
                </a>
            </div>

            <!-- Categories Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-title">Categories</h3>
                <ul class="category-list">
                    <li class="category-item active" data-category="all">
                        <span>All Categories</span>
                        <span class="category-count" id="count-all">{{ $classifieds->count() }}</span>
                    </li>
                    @if(isset($categories) && count($categories) > 0)
                        @foreach($categories as $category)
                            <li class="category-item" data-category="{{ $category->name }}">
                                <span>{{ $category->name }}</span>
                                <span class="category-count">{{ $classifieds->filter(function($c) use ($category) { return strtolower($c->category) === strtolower($category->name); })->count() }}</span>
                            </li>
                        @endforeach
                    @else
                        <li class="category-item" data-category="Jobs">
                            <span>Jobs</span>
                            <span class="category-count">{{ $classifieds->where('category', 'jobs')->count() }}</span>
                        </li>
                        <li class="category-item" data-category="Office Space">
                            <span>Office Space</span>
                            <span class="category-count">{{ $classifieds->where('category', 'office space')->count() }}</span>
                        </li>
                        <li class="category-item" data-category="Consulting">
                            <span>Consulting</span>
                            <span class="category-count">{{ $classifieds->where('category', 'consulting')->count() }}</span>
                        </li>
                        <li class="category-item" data-category="Other">
                            <span>Other</span>
                            <span class="category-count">{{ $classifieds->where('category', 'other')->count() }}</span>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Questions Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-title">Questions?</h3>
                <p style="font-size: 12px; color: #64748b; line-height: 1.5; margin-top: 0; margin-bottom: 10px;">Call us weekdays 10 a.m. - 5 p.m.</p>
                <a href="tel:+19164435883" style="font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 8px; text-decoration: none; display: block;">(916) 443-5883</a>
                <a href="mailto:ads@californiatargetbook.com" style="color: #0d6efd; font-size: 12.5px; font-weight: 600; text-decoration: none;">ads@californiatargetbook.com</a>
            </div>
        </div>

        <!-- Main Listings Content Area (Right column) -->
        <div style="flex: 1; display: flex; flex-direction: column; gap: 24px;" id="listings-container">
            <!-- Dynamic Sections render here -->
        </div>
    </div>
  </div>

  <!-- Frontend Details Modal Dialog -->
  <div id="detail-modal">
      <div class="portal-card" style="width: 100%; max-width: 600px; max-height: calc(100vh - 48px); overflow-y: auto; padding: 0; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border-radius: 12px; background: #ffffff;" id="detail-modal-container">
          <!-- Header -->
          <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #e2e8f0; background: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
              <h3 style="margin: 0; font-size: 14.5px; font-weight: 800; color: #0d6efd; text-transform: uppercase;" id="detail-category">JOBS</h3>
              <button type="button" id="btn-close-detail" style="background: transparent; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center;"><i class="bi bi-x-lg"></i></button>
          </div>
          
          <!-- Content -->
          <div style="padding: 24px;">
              <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;" id="detail-organization">Dept. of Public Health</div>
              <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 16px; line-height: 1.3;" id="detail-title">Assistant Deputy Director, Chief Technology Officer</h2>
              
              <div style="font-size: 14px; color: #334155; line-height: 1.6; white-space: pre-wrap; margin-bottom: 24px;" id="detail-body">
                  Body text goes here...
              </div>

              <!-- Meta Rows -->
              <div style="border-top: 1px solid #f1f5f9; padding-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                  <div>
                      <div class="detail-meta-label">Expires On</div>
                      <div class="detail-meta-val" id="detail-expires">-</div>
                  </div>
                  <div>
                      <div class="detail-meta-label">Rate</div>
                      <div class="detail-meta-val" id="detail-rate">-</div>
                  </div>
                  <div>
                      <div class="detail-meta-label">Contact Email</div>
                      <div class="detail-meta-val">
                          <a href="#" id="detail-email-link" style="color: #0d6efd; text-decoration: none; font-weight: 600;">contact@org.com</a>
                      </div>
                  </div>
                  <div id="detail-url-row">
                      <div class="detail-meta-label">Link URL</div>
                      <div class="detail-meta-val">
                          <a href="#" id="detail-url-link" target="_blank" style="color: #0d6efd; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                              Visit Link <i class="bi bi-box-arrow-up-right"></i>
                          </a>
                      </div>
                  </div>
              </div>
          </div>
          
          <!-- Footer -->
          <div style="display: flex; justify-content: flex-end; padding: 16px 24px; border-top: 1px solid #e2e8f0; background: #f8fafc; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
              <button type="button" id="btn-close-detail-footer" style="background-color: #0f172a; border: none; color: #ffffff; padding: 10px 24px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer;">Close</button>
          </div>
      </div>
  </div>

  @include('layouts.footer')

  <script src="/js/script.js"></script>

  <script>
      $(document).ready(function () {
          // Load DB records passed from controller
          const rawClassifieds = @json($classifieds);
          let activeCategory = 'all';
          let currentSearch = '';
          let currentSort = 'newest';
          let currentPage = 1;
          const itemsPerPage = 9;

          // Categories mapping
          const categories = ['Jobs', 'Office Space', 'Consulting', 'Other'];

          // Cache loaded items for detail popup lookup
          let loadedItems = [];

          function updateBadges(counts) {
              if (!counts) return;
              $('#count-all').text(counts.all);
              $('#count-jobs').text(counts.jobs);
              $('#count-office').text(counts.office);
              $('#count-consulting').text(counts.consulting);
              $('#count-other').text(counts.other);
          }

          function formatDateShort(dateStr) {
              if (!dateStr) return '';
              if (dateStr.includes('T')) dateStr = dateStr.split('T')[0];
              const date = new Date(dateStr + 'T00:00:00');
              if (isNaN(date.getTime())) return dateStr;
              return `${date.getMonth() + 1}/${date.getDate()}`;
          }

          function renderEmptyState() {
              $('#listings-container').html(`
                  <div class="sidebar-card" style="padding: 40px; text-align: center; color: #64748b;">
                      <i class="bi bi-megaphone" style="font-size: 32px; display: block; margin-bottom: 12px; color: #cbd5e1;"></i>
                      <b>No active ads found.</b> Try adjusting your search keyword or selected category.
                  </div>
              `);
          }

          function createCardHtml(ad) {
              const expiresText = ad.ends_on ? `Expires ${formatDateShort(ad.ends_on)}` : '';
              const tag = ad.category === 'Consulting' ? 'Consulting' : ad.category;
              
              return `
                  <div class="classified-card">
                      <div class="card-tag">${tag}</div>
                      <div class="card-org">${ad.organization_name || ''}</div>
                      <h4 class="card-headline" title="${ad.title || ''}">${ad.title || ''}</h4>
                      <div class="card-body-text">${ad.body || ''}</div>
                      <div class="card-footer-info">
                          <span class="card-expires">${expiresText}</span>
                          <span class="card-details-link btn-view-details" data-id="${ad.id}">
                              Details <i class="bi bi-arrow-right-short" style="font-size: 16px;"></i>
                          </span>
                      </div>
                  </div>
              `;
          }

          function loadClassifieds() {
              const $container = $('#listings-container');
              
              // Loading Spinner
              $container.html(`
                  <div style="text-align: center; padding: 60px 0; color: #64748b;">
                      <div class="spinner-border text-danger" role="status" style="width: 2.5rem; height: 2.5rem; border-width: 0.25em; margin-bottom: 12px;"></div>
                      <div style="font-weight: 600; font-size: 13.5px;">Loading classifieds...</div>
                  </div>
              `);

              $.ajax({
                  url: '/api/public/classifieds',
                  method: 'GET',
                  data: {
                      category: activeCategory,
                      search: currentSearch,
                      sort: currentSort,
                      page: currentPage
                  },
                  dataType: 'json',
                  success: function (response) {
                      updateBadges(response.counts);
                      $container.empty();

                      if (response.type === 'grouped') {
                          loadedItems = [];
                          const categories = ['Jobs', 'Office Space', 'Consulting', 'Other'];
                          let hasAnyData = false;

                          categories.forEach(cat => {
                              const catItems = response.data[cat] || [];
                              if (catItems.length === 0) return;

                              hasAnyData = true;
                              loadedItems = loadedItems.concat(catItems);

                              const key = cat === 'Jobs' ? 'jobs' :
                                          cat === 'Office Space' ? 'office' :
                                          cat === 'Consulting' ? 'consulting' : 'other';
                              const totalCatCount = response.counts[key];
                              const headerText = cat === 'Consulting' ? 'Consulting Services' : cat;

                              let blockHtml = `
                                  <div>
                                      <h2 class="listing-section-header">
                                          ${headerText} <span class="listing-section-count">${totalCatCount}</span>
                                      </h2>
                                      <div class="cards-grid">
                              `;

                              catItems.forEach(ad => {
                                  blockHtml += createCardHtml(ad);
                              });

                              blockHtml += `</div>`;

                              if (totalCatCount > 3) {
                                  blockHtml += `
                                      <a href="#" class="view-all-link btn-view-all-cat" data-category="${cat}">
                                          View all ${totalCatCount} ${cat.toLowerCase()} listings <i class="bi bi-arrow-right" style="margin-left: 2px;"></i>
                                      </a>
                                      <div style="clear: both;"></div>
                                  `;
                              }

                              blockHtml += `</div>`;
                              $container.append(blockHtml);
                          });

                          if (!hasAnyData) {
                              renderEmptyState();
                          }
                      } else {
                          const catItems = response.data || [];
                          loadedItems = catItems;

                          if (catItems.length === 0) {
                              renderEmptyState();
                              return;
                          }

                          const totalEntries = response.pagination.total;
                          const headerText = activeCategory === 'Consulting' ? 'Consulting Services' : activeCategory;

                          let blockHtml = `
                              <div>
                                  <h2 class="listing-section-header">
                                      ${headerText} <span class="listing-section-count">${totalEntries}</span>
                                  </h2>
                                  <div class="cards-grid">
                          `;

                          catItems.forEach(ad => {
                              blockHtml += createCardHtml(ad);
                          });

                          blockHtml += `</div></div>`;
                          $container.append(blockHtml);

                          // Append pagination
                          renderPagination(
                              response.pagination.last_page,
                              response.pagination.current_page,
                              response.pagination.total,
                              response.pagination.per_page
                          );
                      }
                  },
                  error: function() {
                      $container.html(`
                          <div class="sidebar-card" style="padding: 40px; text-align: center; color: #c52026;">
                              <i class="bi bi-exclamation-triangle" style="font-size: 32px; display: block; margin-bottom: 12px;"></i>
                              <b>Failed to load classifieds.</b> Please refresh the page or try again.
                          </div>
                      `);
                  }
              });
          }

          function renderPagination(lastPage, currentPageNum, totalEntries, perPage) {
              const startIndex = (currentPageNum - 1) * perPage;
              const endIndex = Math.min(startIndex + perPage, totalEntries);

              const $paginationContainer = $(`
                  <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-top: 1px solid #f1f5f9; background-color: transparent; flex-wrap: wrap; gap: 12px;">
                      <div style="font-size: 13.5px; color: #64748b;">
                          Showing ${startIndex + 1} to ${endIndex} of ${totalEntries} entries
                      </div>
                      <div style="display: flex; gap: 8px; align-items: center;" class="listing-pagination-buttons">
                      </div>
                  </div>
              `);

              const $buttonsContainer = $paginationContainer.find('.listing-pagination-buttons');

              // Previous
              const $prevBtn = $('<button>').text('Previous');
              stylePaginationButton($prevBtn, currentPageNum === 1);
              if (currentPageNum > 1) {
                  $prevBtn.on('click', () => {
                      currentPage = currentPageNum - 1;
                      loadClassifieds();
                      scrollToTop();
                  });
              }
              $buttonsContainer.append($prevBtn);

              // Numbers
              for (let i = 1; i <= lastPage; i++) {
                  const $pageBtn = $('<button>').text(i);
                  stylePaginationButton($pageBtn, false, currentPageNum === i);
                  $pageBtn.on('click', () => {
                      currentPage = i;
                      loadClassifieds();
                      scrollToTop();
                  });
                  $buttonsContainer.append($pageBtn);
              }

              // Next
              const $nextBtn = $('<button>').text('Next');
              stylePaginationButton($nextBtn, currentPageNum === lastPage);
              if (currentPageNum < lastPage) {
                  $nextBtn.on('click', () => {
                      currentPage = currentPageNum + 1;
                      loadClassifieds();
                      scrollToTop();
                  });
              }
              $buttonsContainer.append($nextBtn);

              $('#listings-container').append($paginationContainer);
          }

          function stylePaginationButton($btn, isDisabled, isActive = false) {
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
                      background: '#1c3a63',
                      color: '#ffffff',
                      borderColor: '#1c3a63',
                      cursor: 'default'
                  });
              } else {
                  $btn.css({
                      background: '#ffffff',
                      color: '#475569',
                      cursor: 'pointer'
                  });
                  $btn.on('mouseenter', function() {
                      $(this).css({ background: '#f8fafc', borderColor: '#cbd5e1' });
                  }).on('mouseleave', function() {
                      $(this).css({ background: '#ffffff', borderColor: '#e2e8f0' });
                  });
              }
          }

          function scrollToTop() {
              $('html, body').animate({
                  scrollTop: $('#listings-container').offset().top - 120
              }, 150);
          }

          // Categories list clicking
          $('.category-item').on('click', function () {
              $('.category-item').removeClass('active');
              $(this).addClass('active');
              activeCategory = $(this).data('category');
              currentPage = 1;
              loadClassifieds();
          });

          // View all category links click
          $('#listings-container').on('click', '.btn-view-all-cat', function (e) {
              e.preventDefault();
              const cat = $(this).data('category');
              const $sidebarItem = $(`.category-item[data-category="${cat}"]`);
              if ($sidebarItem.length) {
                  $sidebarItem.click();
                  $('html, body').animate({ scrollTop: $('#listings-container').offset().top - 120 }, 200);
              }
          });

          // Search input
          let searchTimeout = null;
          $('#search-listings').on('input', function () {
              currentSearch = $(this).val().toLowerCase().trim();
              currentPage = 1;
              clearTimeout(searchTimeout);
              searchTimeout = setTimeout(loadClassifieds, 250);
          });

          // Sort dropdown
          $('#sort-listings').on('change', function () {
              currentSort = $(this).val();
              currentPage = 1;
              loadClassifieds();
          });

          // View Ad Rates smooth scroll
          $('#btn-view-rates').on('click', function(e) {
              e.preventDefault();
              $('html, body').animate({
                  scrollTop: $("#rates-section").offset().top - 120
              }, 300);
          });

          // Details Modal Logic
          const $detailModal = $('#detail-modal');
          const $detailModalContainer = $('#detail-modal-container');

          function openDetailModal() {
              $detailModal.css('display', 'flex');
              setTimeout(() => {
                  $detailModal.addClass('modal-open');
              }, 10);
          }

          function closeDetailModal() {
              $detailModal.removeClass('modal-open');
              setTimeout(() => {
                  $detailModal.css('display', 'none');
              }, 300);
          }

          $('#btn-close-detail, #btn-close-detail-footer').on('click', closeDetailModal);
          $detailModal.on('click', function (e) {
              if (e.target === this) closeDetailModal();
          });

          // Card details click handler
          $('#listings-container').on('click', '.btn-view-details', function () {
              const adId = $(this).data('id');
              const ad = loadedItems.find(a => a.id === adId);
              if (!ad) return;

              // Map fields
              const categoryText = ad.category === 'Consulting' ? 'Consulting Services' : ad.category;
              $('#detail-category').text(categoryText);
              $('#detail-organization').text(ad.organization_name || 'N/A');
              $('#detail-title').text(ad.title || 'N/A');
              $('#detail-body').text(ad.body || '');
              $('#detail-expires').text(formatDateShort(ad.ends_on));
              $('#detail-rate').text(ad.rate || 'Unspecified');

              // Contact Email Link
              if (ad.advertiser_email) {
                  $('#detail-email-link')
                      .attr('href', `mailto:${ad.advertiser_email}?subject=Inquiry%20regarding%20classified%20ad%20-${encodeURIComponent(ad.title)}`)
                      .text(ad.advertiser_email)
                      .show();
              } else {
                  $('#detail-email-link').hide();
              }

              // Link URL
              if (ad.link_url) {
                  $('#detail-url-link').attr('href', ad.link_url);
                  $('#detail-url-row').show();
              } else {
                  $('#detail-url-row').hide();
              }

              openDetailModal();
          });

          // Run initial load
          loadClassifieds();
      });
  </script>
</body>

</html>
