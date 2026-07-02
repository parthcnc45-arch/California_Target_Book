@extends('layouts.portal')

@section('portal_content')
    <!-- Actions Bar -->
    <div class="actions-bar no-print">
        <a href="{{ route('auth.account.transaction_history') }}" class="btn-action">
            <i class="bi bi-arrow-left"></i> Back to Transactions
        </a>
        <div class="receipt-actions-right">
            @if($invoice->invoice_pdf)
                <a href="{{ $invoice->invoice_pdf }}" target="_blank" class="btn-action btn-action-secondary">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            @endif
            <button type="button" class="btn-action btn-action-primary" onclick="window.print()">
                <i class="bi bi-printer"></i> Print Receipt
            </button>
        </div>
    </div>

    <!-- Receipt Document Container -->
    <div class="receipt-container">
        
        <!-- Header -->
        <div class="receipt-header">
            <div class="logo-container">
                <img src="/img/ctb_logo.png" alt="California Target Book">
            </div>
            <h1 class="receipt-title">Receipt</h1>
        </div>

        <!-- Details & Addresses -->
        <div class="info-row">
            <!-- Billed to customer -->
            <div class="billed-to">
                <div class="billed-title">Billed to</div>
                <div class="receipt-customer-name">
                    {{ $invoice->customer_name ?? ($user->first_name . ' ' . $user->last_name) }}
                </div>
                <div>{{ $invoice->customer_email ?? $user->email }}</div>
                <div>
                    @if($invoice->customer_address && $invoice->customer_address->country)
                        {{ $invoice->customer_address->country }}
                    @elseif($user->company && $user->company->address && $user->company->address->country)
                        {{ $user->company->address->country }}
                    @else
                        United States
                    @endif
                </div>
            </div>

            <!-- Company target book info -->
            <div class="company-details">
                <div class="company-name">California Target Book</div>
                <div>(916) 200-3590</div>
                <div>P.O. Box 5978</div>
                <div>Beverly Hills, California 90209</div>
                <div>United States</div>
                <div class="receipt-company-web">californiatargetbook.com</div>
            </div>
        </div>

        <div class="info-row receipt-info-row-mb30">
            <!-- Receipt specific numbers and dates -->
            <div class="details-col">
                <div class="details-item">
                    <div class="details-title">Receipt No</div>
                    <div class="details-value">{{ $invoice->number ?? ('REC' . substr($invoice->id, -6)) }}</div>
                </div>
            </div>

            <div class="details-col receipt-details-col-right">
                <div class="details-item">
                    <div class="details-title">Date Paid</div>
                    <div class="details-value">
                        {{ Carbon\Carbon::createFromTimestamp($invoice->created)->format('F j, Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="receipt-col-name">Item Name</th>
                    <th class="receipt-col-price num-col">Price</th>
                    <th class="receipt-col-qty num-col">Qty</th>
                    <th class="receipt-col-subtotal num-col">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->lines->data as $item)
                    <tr>
                        <td class="item-name">{{ $item->description }}</td>
                        <td class="num-col">${{ number_format($item->amount / 100, 2) }}</td>
                        <td class="num-col">{{ $item->quantity }}</td>
                        <td class="num-col">${{ number_format($item->amount / 100, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Calculations & Totals -->
        <div class="calc-section">
            <table class="calc-table">
                <tr>
                    <td>Subtotal</td>
                    <td class="val-col">${{ number_format($invoice->subtotal / 100, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total (USD)</td>
                    <td class="val-col">${{ number_format($invoice->total / 100, 2) }}</td>
                </tr>
                <tr class="paid-row">
                    <td>Amount Paid (USD)</td>
                    <td class="val-col">${{ number_format($invoice->amount_paid / 100, 2) }}</td>
                </tr>
            </table>
        </div>

    </div>

    <script>
        document.body.classList.add('receipt-page');
    </script>
@endsection
