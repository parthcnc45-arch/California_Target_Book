<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $invoice->number ?? $invoice->id }} | California Target Book</title>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 40px 20px;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 48px;
            box-sizing: border-box;
            position: relative;
        }

        /* Top Bar for Actions */
        .actions-bar {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-action:hover {
            background-color: #f8fafc;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .btn-action-primary {
            background-color: #d93838;
            color: #ffffff;
            border-color: #d93838;
        }

        .btn-action-primary:hover {
            background-color: #b91c1c;
            color: #ffffff;
            border-color: #b91c1c;
        }

        .btn-action-secondary {
            background-color: #0d9488;
            color: #ffffff;
            border-color: #0d9488;
        }

        .btn-action-secondary:hover {
            background-color: #0f766e;
            color: #ffffff;
            border-color: #0f766e;
        }

        /* Header Style */
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-container img {
            height: 48px;
            width: auto;
        }

        .receipt-title {
            font-size: 28px;
            font-weight: 300;
            color: #000000;
            letter-spacing: 2px;
            margin: 0;
            text-transform: uppercase;
        }

        /* Info Section */
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .company-details {
            text-align: right;
            font-size: 12.5px;
            color: #64748b;
            line-height: 1.5;
        }

        .company-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .billed-to {
            font-size: 13px;
            color: #475569;
            line-height: 1.6;
            max-width: 40%;
        }

        .billed-title, .details-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .details-col {
            text-align: left;
            font-size: 13px;
            color: #475569;
            line-height: 1.6;
        }

        .details-item {
            margin-bottom: 15px;
        }

        .details-value {
            font-weight: 600;
            color: #0f172a;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            border-bottom: 1px solid #cbd5e1;
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 8px;
            font-size: 13.5px;
            color: #0f172a;
            vertical-align: middle;
        }

        .items-table th.num-col, .items-table td.num-col {
            text-align: right;
        }

        .item-name {
            font-weight: 500;
        }

        /* Calculation block */
        .calc-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .calc-table {
            width: 300px;
            border-collapse: collapse;
        }

        .calc-table td {
            padding: 8px 0;
            font-size: 13.5px;
            color: #475569;
        }

        .calc-table td.val-col {
            text-align: right;
            color: #0f172a;
            font-weight: 500;
        }

        .calc-table tr.total-row td {
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
        }

        .calc-table tr.paid-row td {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            padding-top: 16px;
        }

        .calc-table tr.paid-row td.val-col {
            font-size: 18px;
            font-weight: 800;
        }

        /* Print Override */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .receipt-container {
                border: none;
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Actions Bar -->
    <div class="actions-bar no-print">
        <a href="{{ route('auth.account.transaction_history') }}" class="btn-action">
            <i class="bi bi-arrow-left"></i> Back to Transactions
        </a>
        <div style="display: flex; gap: 10px; align-items: center;">
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
                <div style="font-weight: 700; color: #0f172a; font-size: 14px; margin-bottom: 2px;">
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
                <div style="margin-top: 4px; font-weight: 500; color: #d93838;">californiatargetbook.com</div>
            </div>
        </div>

        <div class="info-row" style="margin-bottom: 30px;">
            <!-- Receipt specific numbers and dates -->
            <div class="details-col">
                <div class="details-item">
                    <div class="details-title">Receipt No</div>
                    <div class="details-value">{{ $invoice->number ?? ('REC' . substr($invoice->id, -6)) }}</div>
                </div>
            </div>

            <div class="details-col" style="text-align: right;">
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
                    <th style="width: 55%;">Item Name</th>
                    <th style="width: 15%;" class="num-col">Price</th>
                    <th style="width: 10%;" class="num-col">Qty</th>
                    <th style="width: 20%;" class="num-col">Subtotal</th>
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

</body>
</html>
