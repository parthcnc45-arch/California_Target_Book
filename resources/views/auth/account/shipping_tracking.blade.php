@extends('layouts.portal')

@section('portal_styles')
    <style>
        .portal-status-container {
            margin: 0;
            padding: 4px 10px;
            font-size: 11px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
            text-align: center;
        }
        .portal-status-delivered {
            background-color: #e6f4ea !important;
            color: #137333 !important;
        }
        .portal-status-in-transit {
            background-color: #fff3e0 !important;
            color: #e65100 !important;
        }
        .portal-status-processing {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
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

        <div class="portal-card account-info-card">
            <div class="card-header-custom">
                <h2 class="card-title-custom">Shipments</h2>
            </div>
            <div class="card-body-custom">
                <table class="portal-grid-table shipping-table-layout">
                    <thead>
                        <tr>
                            <th class="portal-col-w-120">Status</th>
                            <th class="portal-col-w-120">Shipment No.</th>
                            <th class="portal-col-w-240">Contact Name</th>
                            <th class="portal-col-w-240">Item Name</th>
                            <th class="portal-col-w-120">Carrier</th>
                            <th class="portal-col-w-120">Tracking No.</th>
                            <th class="portal-col-w-120">Ship Date</th>
                            <th class="portal-col-w-120">Est. Delivery</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($sub['books']) && count($sub['books']) > 0)
                            @foreach($sub['books'] as $book)
                                @php
                                    $status = strtolower($book->status ?? 'processing');
                                    $statusClass = 'portal-status-processing';
                                    if ($status === 'delivered') $statusClass = 'portal-status-delivered';
                                    elseif ($status === 'in transit' || $status === 'shipped') $statusClass = 'portal-status-in-transit';
                                    elseif ($status === 'exception / delayed') $statusClass = 'portal-status-processing'; 
                                @endphp
                                <tr>
                                    <td>
                                        <span class="portal-status-container {{ $statusClass }}">
                                            {{ ucfirst($book->status ?? 'Processing') }}
                                        </span>
                                    </td>
                                    <td class="portal-col-w-80 portal-word-break-all">SH-{{ $book->id }}</td>
                                    <td class="fw-semibold">{{ isset($sub['base_account']) && $sub['base_account'] ? $sub['base_account']->name() : 'Not Specified' }}</td>
                                    <td class="fw-semibold">{{ $book->item_name ?? '-' }}</td>
                                    <td>{{ $book->carrier ?? '-' }}</td>
                                    <td>
                                        @if($book->tracking_url)
                                            <a href="{{ $book->tracking_url }}" target="_blank" class="tracking-link">{{ \Illuminate\Support\Str::limit($book->tracking_id, 15) }}</a>
                                        @elseif($book->tracking_id)
                                            {{ $book->tracking_id }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $book->ship_date ? \Carbon\Carbon::parse($book->ship_date)->format('M j, Y') : '-' }}</td>
                                    <td>{{ $book->estimated_delivery ? \Carbon\Carbon::parse($book->estimated_delivery)->format('M j, Y') : '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 32px; color: #64748b;">
                                    No shipments found.
                                </td>
                            </tr>
                        @endif
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


