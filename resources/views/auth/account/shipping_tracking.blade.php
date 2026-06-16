@extends('layouts.portal')
@section('portal_content')
    <section id="section-shipping-tracking" class="portal-section active">
        <header class="section-header">
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Shipping & Tracking</h1>
                </div>
                <p class="header-subtitle">Track your physical book and supplement shipments.</p>
            </div>
        </header>

        <div class="portal-card account-info-card">
            <div class="card-header-custom">
                <h2 class="card-title-custom">Shipments</h2>
            </div>
            <div class="card-body-custom">
                <table class="portal-grid-table shipping-table-layout">
                    <thead>
                        <tr>
                            <th class="portal-col-w-80">Order</th>
                            <th class="portal-col-w-110">Order Date</th>
                            <th class="portal-col-w-240">Item</th>
                            <th class="portal-col-w-80">Carrier</th>
                            <th class="portal-col-w-150">Tracking</th>
                            <th class="portal-col-w-120">Est. Delivery</th>
                            <th class="portal-col-w-120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="portal-col-w-80 portal-word-break-all"><a href="javascript:void(0)">TB-2026-001</a></td>
                            <td>Apr 1, 2026</td>
                            <td class="fw-semibold">California Target Book 2026...</td>
                            <td>UPS</td>
                            <td><a href="https://www.ups.com/track?tracknum=1Z999AA10123011234" target="_blank" class="tracking-link">1Z999AA10123...</a></td>
                            <td>Apr 15, 2026</td>
                            <td>
                                <span class="portal-status-container portal-status-in-transit">
                                    <span class="portal-status-dot"></span>
                                    In Transit
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="portal-col-w-80 portal-word-break-all"><a href="javascript:void(0)">TB-2025-003</a></td>
                            <td>Mar 15, 2025</td>
                            <td class="fw-semibold">CTB District Map Supple...</td>
                            <td>UPS</td>
                            <td><a href="https://www.ups.com/track?tracknum=1Z999AA10124021234" target="_blank" class="tracking-link">1Z999AA10124...</a></td>
                            <td>Mar 20, 2025</td>
                            <td>
                                <span class="portal-status-container portal-status-delivered">
                                    <span class="portal-status-dot"></span>
                                    Delivered
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="portal-col-w-80 portal-word-break-all"><a href="javascript:void(0)">TB-2025-001</a></td>
                            <td>Jan 10, 2025</td>
                            <td class="fw-semibold">California Target Book 2025...</td>
                            <td>FedEx</td>
                            <td><a href="https://www.fedex.com/apps/fedextrack/?tracknumbers=773210987654321" target="_blank" class="tracking-link">773210987654...</a></td>
                            <td>Jan 20, 2025</td>
                            <td>
                                <span class="portal-status-container portal-status-delivered">
                                    <span class="portal-status-dot"></span>
                                    Delivered
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="portal-col-w-80 portal-word-break-all"><a href="javascript:void(0)">TB-2024-002</a></td>
                            <td>Apr 10, 2024</td>
                            <td class="fw-semibold">California Target Book 2024...</td>
                            <td>&nbsp;</td>
                            <td>Pending</td>
                            <td>Apr 25, 2024</td>
                            <td>
                                <span class="portal-status-container portal-status-processing">
                                    <span class="portal-status-dot"></span>
                                    Processing
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="portal-card-footer-border">
                <div class="portal-info-box">
                    <i class="bi bi-info-circle portal-info-box-icon"></i>
                    <div>
                        <h4 class="portal-info-box-title">Need help with a shipment?</h4>
                        <p class="portal-info-box-text">
                            If your order hasn't arrived by the estimated delivery date, please contact our support team for assistance.
                        </p>
                        <a href="/account/help-support" class="portal-info-box-link">Contact Support...</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


