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
                                <th class="th-w-37">Description</th>
                                <th class="th-w-12">Plan</th>
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
                @else
                    <div class="empty-state-container">
                        <i class="bi bi-receipt-cutoff empty-state-icon"></i>
                        <span>No transaction records found.</span>
                    </div>
                @endif
            </div>
        </div>
        <p class="table-footer-note">
            Showing {{ count($transactions) }} transactions. Contact support for records older than 3 years.
        </p>
    </section>

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
