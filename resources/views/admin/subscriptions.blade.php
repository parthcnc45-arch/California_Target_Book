@extends('layouts.portal')

@section('portal_content')
    <div class="section-header" style="justify-content: space-between;">
        <div class="header-title-container">
            <h1 class="header-title">Subscriptions</h1>
        </div>
        <a href="/ctb-admin/new/subscriptions/add" class="btn-add-subscription">
            <i class="bi bi-plus-lg"></i> ADD
        </a>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total Subscriptions</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">589</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #16a34a;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Active</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">264</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #ef4444;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Inactive</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">325</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card" style="padding: 0;">
        <div class="card-header-custom">
            <h2 class="card-title-custom">Subscribers List</h2>
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #64748b; font-size: 14px;"></i>
                <input type="text" class="form-input-style" placeholder="Search companies or contacts..." style="padding-left: 36px; width: 280px;">
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Status</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Expiration</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Howe and Fernandez Inc</td>
                        <td><a href="#">Hedy Frye</a></td>
                        <td>Jul 7th, 2027</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Spencer May LLC</td>
                        <td><a href="#">Scarlett Guzman</a></td>
                        <td>Jul 7th, 2028</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Bush and Mcfarland Trading</td>
                        <td><a href="#">Travis Dillon</a></td>
                        <td>Jul 7th, 2027</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Saunders Bridges Inc</td>
                        <td><a href="#">Idona Wilcox</a></td>
                        <td>Jul 7th, 2028</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Stanton Hess LLC</td>
                        <td><a href="#">Callie Hurley</a></td>
                        <td>Jul 7th, 2028</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Wilcox and Neal Associates</td>
                        <td><a href="#">Gay Padilla</a></td>
                        <td>Jul 7th, 2027</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Spectrum Campaigns</td>
                        <td><a href="#">David Koenig</a></td>
                        <td>Jul 2nd, 2028</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Codeandcore</td>
                        <td><a href="#">Nagender Gehlot</a></td>
                        <td>Jul 2nd, 2027</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">JIO</td>
                        <td><a href="#">Vijay Solnki</a></td>
                        <td>Jun 25th, 2027</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
