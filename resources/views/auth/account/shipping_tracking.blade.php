@extends('layouts.portal')

@section('portal_styles')
<style>
    /* Override global table styles to match transaction_history */
    .info-table thead tr {
        background-color: #ffffff !important;
        background-image: none !important;
        border-bottom: 1px solid var(--border-color) !important;
    }
    .info-table th {
        background-color: #ffffff !important;
        background-image: none !important;
        color: var(--text-muted) !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        text-transform: none !important;
        letter-spacing: normal !important;
        padding: 14px 20px !important;
        border-bottom: 1px solid var(--border-color) !important;
        box-sizing: border-box;
    }
    .info-table td {
        padding: 14px 20px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle !important;
    }
    .info-table tr:last-child td {
        border-bottom: none !important;
    }
    /* Link styling */
    .info-table a {
        color: var(--primary-color) !important;
        text-decoration: none !important;
        font-weight: 600 !important;
    }
    .info-table a:hover {
        text-decoration: underline !important;
    }
    .tracking-link {
        font-size: 13px !important;
        font-weight: 600 !important;
    }
</style>
@endsection

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

        <div class="portal-card account-info-card" style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 10px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); width: 100%; box-sizing: border-box; overflow: hidden; margin-top: 16px;">
            <div class="card-header-custom" style="padding: 16px 20px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                <h2 class="card-title-custom" style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0;">Shipments</h2>
            </div>
            <div class="card-body-custom" style="padding: 0; overflow-x: auto;">
                <div style="overflow-x: auto; width: 100%;">
                    <table class="info-table" style="width: 100%; border-collapse: collapse; min-width: 840px; table-layout: fixed;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <th style="width: 80px; min-width: 80px; max-width: 80px; background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; box-sizing: border-box;">Order</th>
                                <th style="width: 110px; min-width: 110px; background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; box-sizing: border-box;">Order Date</th>
                                <th style="width: 240px; min-width: 240px; background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; box-sizing: border-box;">Item</th>
                                <th style="width: 80px; min-width: 80px; background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; box-sizing: border-box;">Carrier</th>
                                <th style="width: 150px; min-width: 150px; background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; box-sizing: border-box;">Tracking</th>
                                <th style="width: 120px; min-width: 120px; background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; box-sizing: border-box;">Est. Delivery</th>
                                <th style="width: 120px; min-width: 120px; background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; box-sizing: border-box;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="info-value" style="width: 80px; padding: 14px 20px; box-sizing: border-box; word-break: break-all; white-space: normal;"><a href="javascript:void(0)" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">TB-2026-001</a></td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Apr 1, 2026</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; font-weight: 600; color: #0f172a; box-sizing: border-box; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">California Target Book 2026...</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #64748b; box-sizing: border-box;">UPS</td>
                                <td class="info-value" style="padding: 14px 20px; box-sizing: border-box;"><a href="https://www.ups.com/track?tracknum=1Z999AA10123011234" target="_blank" class="tracking-link" style="font-size: 13px; color: var(--primary-color); font-weight: 600; text-decoration: none;">1Z999AA10123...</a></td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Apr 15, 2026</td>
                                <td class="info-value" style="padding: 14px 20px; box-sizing: border-box;">
                                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 600; font-size: 12.5px; color: #d97706;">
                                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>
                                        In Transit
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="info-value" style="width: 80px; padding: 14px 20px; box-sizing: border-box; word-break: break-all; white-space: normal;"><a href="javascript:void(0)" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">TB-2025-003</a></td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Mar 15, 2025</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; font-weight: 600; color: #0f172a; box-sizing: border-box; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">CTB District Map Supple...</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #64748b; box-sizing: border-box;">UPS</td>
                                <td class="info-value" style="padding: 14px 20px; box-sizing: border-box;"><a href="https://www.ups.com/track?tracknum=1Z999AA10124021234" target="_blank" class="tracking-link" style="font-size: 13px; color: var(--primary-color); font-weight: 600; text-decoration: none;">1Z999AA10124...</a></td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Mar 20, 2025</td>
                                <td class="info-value" style="padding: 14px 20px; box-sizing: border-box;">
                                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 600; font-size: 12.5px; color: #16a34a;">
                                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #22c55e; display: inline-block;"></span>
                                        Delivered
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="info-value" style="width: 80px; padding: 14px 20px; box-sizing: border-box; word-break: break-all; white-space: normal;"><a href="javascript:void(0)" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">TB-2025-001</a></td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Jan 10, 2025</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; font-weight: 600; color: #0f172a; box-sizing: border-box; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">California Target Book 2025...</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #64748b; box-sizing: border-box;">FedEx</td>
                                <td class="info-value" style="padding: 14px 20px; box-sizing: border-box;"><a href="https://www.fedex.com/apps/fedextrack/?tracknumbers=773210987654321" target="_blank" class="tracking-link" style="font-size: 13px; color: var(--primary-color); font-weight: 600; text-decoration: none;">773210987654...</a></td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Jan 20, 2025</td>
                                <td class="info-value" style="padding: 14px 20px; box-sizing: border-box;">
                                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 600; font-size: 12.5px; color: #16a34a;">
                                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #22c55e; display: inline-block;"></span>
                                        Delivered
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom: none;">
                                <td class="info-value" style="width: 80px; padding: 14px 20px; box-sizing: border-box; word-break: break-all; white-space: normal;"><a href="javascript:void(0)" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">TB-2024-002</a></td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Apr 10, 2024</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; font-weight: 600; color: #0f172a; box-sizing: border-box; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">California Target Book 2024...</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #64748b; box-sizing: border-box;">&nbsp;</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #64748b; box-sizing: border-box; font-weight: 500;">Pending</td>
                                <td class="info-value" style="padding: 14px 20px; font-size: 13px; color: #475569; box-sizing: border-box; white-space: nowrap;">Apr 25, 2024</td>
                                <td class="info-value" style="padding: 14px 20px; box-sizing: border-box;">
                                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 600; font-size: 12.5px; color: #4b5563;">
                                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #94a3b8; display: inline-block;"></span>
                                        Processing
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="padding: 24px; border-top: 1px solid var(--border-color);">
                    <div style="display: flex; align-items: flex-start; gap: 12px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px;">
                        <i class="bi bi-info-circle" style="color: #64748b; font-size: 18px; margin-top: 2px;"></i>
                        <div>
                            <h4 style="margin: 0 0 4px 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Need help with a shipment?</h4>
                            <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.5;">
                                If your order hasn't arrived by the estimated delivery date, please contact our support team for assistance.
                            </p>
                            <a href="/account/help-support" style="color: var(--primary-color); font-weight: 600; text-decoration: none; display: inline-block; margin-top: 8px; font-size: 12.5px;">Contact Support...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


