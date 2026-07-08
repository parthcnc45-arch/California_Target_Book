@extends('layouts.portal')

@section('portal_content')
    <div class="section-header" style="justify-content: space-between;">
        <div class="header-title-container">
            <h1 class="header-title">Hard Copy Subscriptions</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #0d9488;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Total Hard Copies</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">251</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #16a34a;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Active</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">110</div>
        </div>
        <div class="portal-card" style="flex: 1; padding: 20px; border-top: 4px solid #ef4444;">
            <div style="font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Inactive</div>
            <div style="font-size: 28px; font-weight: 800; color: #0f172a;">141</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="portal-card" style="padding: 0;">
        <div class="card-header-custom">
            <h2 class="card-title-custom">Hard Copy List</h2>
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #64748b; font-size: 14px;"></i>
                <input type="text" class="form-input-style" placeholder="Search companies or addresses..." style="padding-left: 36px; width: 300px;">
            </div>
        </div>
        <div class="card-body-custom">
            <table class="portal-grid-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 350px;">Company</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="status-pill-completed" style="background-color: #fef2f2; color: #ef4444;">Inactive</span></td>
                        <td class="fw-semibold text-disabled-gray">Not Specified</td>
                        <td>6173 Hahn Mountain Apt. 399, Moenside, Wyoming 69383</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed" style="background-color: #fef2f2; color: #ef4444;">Inactive</span></td>
                        <td class="fw-semibold text-disabled-gray">Not Specified</td>
                        <td>396 Turcotte Lakes, New Amina, Oklahoma 72834-2432</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">California Target Book</td>
                        <td>829 N San Vicente, Ste 3, West Hollywood, CA 90069</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed" style="background-color: #fef2f2; color: #ef4444;">Inactive</span></td>
                        <td class="fw-semibold text-disabled-gray">Not Specified</td>
                        <td>1303 J Street, #600, Sacramento, CA 95814</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">California Beer & Beverage Distribution</td>
                        <td>1415 L Street, #250, Sacramento, CA 95814</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed" style="background-color: #fef2f2; color: #ef4444;">Inactive</span></td>
                        <td class="fw-semibold">California Building Industry Association (BIA)</td>
                        <td>1215 K Street, Ste. 1200, Sacramento, CA 95814</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed">Active</span></td>
                        <td class="fw-semibold">California Coalition for Public Higher Education</td>
                        <td>10525 Bloomfield St., Toluca Lake, CA 91602</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed" style="background-color: #fef2f2; color: #ef4444;">Inactive</span></td>
                        <td class="fw-semibold">California Grocers Association</td>
                        <td>1215 K Street, #700, Sacramento, CA 95814</td>
                    </tr>
                    <tr>
                        <td><span class="status-pill-completed" style="background-color: #fef2f2; color: #ef4444;">Inactive</span></td>
                        <td class="fw-semibold">California Manufacturing and Technology Association</td>
                        <td>1121 L St., Ste. 700, Sacramento, CA 95814</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
