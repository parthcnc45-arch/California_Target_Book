@extends('layouts.portal')

@section('portal_content')
    <div class="section-header" style="justify-content: space-between;">
        <div class="header-title-container">
            <h1 class="header-title">Contacts</h1>
        </div>
        <button class="btn-export-csv">
            <i class="bi bi-download"></i> EXPORT
        </button>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total Contacts</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">1187</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #16a34a;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Active</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">472</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #ef4444;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Inactive</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">715</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card" style="padding: 0;">
        <div class="card-header-custom">
            <h2 class="card-title-custom">Contact List</h2>
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #64748b; font-size: 14px;"></i>
                <input type="text" class="form-input-style" placeholder="Search contacts or emails..." style="padding-left: 36px; width: 300px;">
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Subscribed On</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Hedy Frye</td>
                        <td><a href="mailto:riqowuta@mailinator.com">riqowuta@mailinator.com</a></td>
                        <td>Howe and Fernandez Inc</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Scarlett Guzman</td>
                        <td><a href="mailto:wepok@mailinator.com">wepok@mailinator.com</a></td>
                        <td>Spencer May LLC</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Travis Dillon</td>
                        <td><a href="mailto:pubew@mailinator.com">pubew@mailinator.com</a></td>
                        <td>Bush and Mcfarland Trading</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Idona Wilcox</td>
                        <td><a href="mailto:cepeti@mailinator.com">cepeti@mailinator.com</a></td>
                        <td>Saunders Bridges Inc</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Callie Hurley</td>
                        <td><a href="mailto:jarezypa@mailinator.com">jarezypa@mailinator.com</a></td>
                        <td>Stanton Hess LLC</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold text-disabled-gray">Not Specified</td>
                        <td><a href="mailto:resuva@mailinator.com">resuva@mailinator.com</a></td>
                        <td>Stanton Hess LLC</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold text-disabled-gray">Not Specified</td>
                        <td><a href="mailto:lolifu@mailinator.com">lolifu@mailinator.com</a></td>
                        <td>Stanton Hess LLC</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">Gay Padilla</td>
                        <td><a href="mailto:sejyny@mailinator.com">sejyny@mailinator.com</a></td>
                        <td>Wilcox and Neal Associates</td>
                        <td>Jul 7th, 2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
