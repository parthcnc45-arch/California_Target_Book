@extends('layouts.portal')

@section('portal_content')
    <section id="section-transaction-history" class="portal-section active">
        <header class="section-header">
            <div class="header-avatar bg-teal-avatar">
                <i class="bi bi-coin icon-flex-18"></i>
            </div>
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Transaction History</h1>
                </div>
                <p class="header-subtitle">View past payments, invoices, and subscription charges.</p>
            </div>
        </header>

        <div class="portal-card">
            <div class="card-header-custom">
                <h2 class="card-title-custom">Transaction History</h2>
                <a href="javascript:void(0)" onclick="exportTransactionsCSV()" class="btn-export-csv">
                    <i class="bi bi-download"></i> Export CSV
                </a>
            </div>
            <div class="card-body-custom">
                @if(count($transactions))
                    <table class="portal-grid-table info-table-min-700">
                        <thead>
                            <tr>
                                <th class="th-w-18">Date</th>
                                <th class="th-w-37">Items</th>
                                <th class="th-w-12">Type</th>
                                <th class="th-w-13">Amount</th>
                                <th class="th-w-12">Status</th>
                                <th class="text-center th-w-8">Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $t)
                                <tr>
                                    <td>
                                        {{ $t->date }}
                                    </td>
                                    <td class="fw-semibold">
                                        {{ $t->description }}
                                    </td>
                                    <td>
                                        {{ $t->plan }}
                                    </td>
                                    <td class="fw-bold">
                                        {{ $t->amount }}
                                    </td>
                                    <td>
                                        @if($t->status === 'Completed')
                                            <span class="status-pill-completed">Completed</span>
                                        @elseif($t->status === 'Refunded')
                                            <span class="status-pill-refunded">Refunded</span>
                                        @else
                                            <span class="status-pill-pending">{{ $t->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($t->invoice_url)
                                            <a href="{{ $t->invoice_url }}" class="link-view-invoice">View</a>
                                        @else
                                            <span class="text-disabled-gray">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination-container">
                        {{ $transactions->links('vendor.pagination.default') }}
                    </div>
                @else
                    <div class="empty-state-container">
                        <i class="bi bi-receipt-cutoff empty-state-icon"></i>
                        <span>No transaction records found.</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
    /* Custom Premium Pagination Styling */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 24px;
        margin-bottom: 8px;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 6px;
        align-items: center;
    }
    
    .pagination li {
        display: inline-block;
    }
    
    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        font-size: 13px;
        font-weight: 500;
        color: #475569;
        background-color: #ffffff;
        border: 1px solid var(--border-color, #e2e8ee);
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
        box-sizing: border-box;
    }
    
    .pagination li a:hover {
        color: var(--primary-color, #d93838);
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }
    
    .pagination li.active span {
        color: #ffffff;
        background-color: var(--primary-color, #d93838);
        border-color: var(--primary-color, #d93838);
        font-weight: 600;
    }
    
    .pagination li.disabled span {
        color: #94a3b8;
        background-color: #f8fafc;
        border-color: var(--border-color, #e2e8ee);
        cursor: not-allowed;
    }
    </style>

    <script>
    function exportTransactionsCSV() {
        var csv = [];
        var rows = document.querySelectorAll("table.portal-grid-table tr");
        
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            
            // We want to export first 5 columns: Date, Description, Plan, Amount, Status
            for (var j = 0; j < Math.min(cols.length, 5); j++) {
                var text = cols[j].innerText.trim().replace(/"/g, '""');
                row.push('"' + text + '"');
            }
            
            if (row.length > 0) {
                csv.push(row.join(","));
            }
        }
        
        var csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "transaction_history.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    </script>
@endsection
