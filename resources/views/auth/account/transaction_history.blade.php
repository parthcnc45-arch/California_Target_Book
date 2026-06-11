@extends('layouts.portal')

@section('portal_content')
    <section id="section-transaction-history" class="portal-section active">
        <header class="section-header">
            <div class="header-avatar" style="background-color: #0d9488; color: #ffffff; font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; text-transform: uppercase; margin-right: 12px; flex-shrink: 0;">
                <i class="bi bi-coin" style="font-size: 18px; display: flex; align-items: center; justify-content: center;"></i>
            </div>
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Transaction History</h1>
                </div>
                <p class="header-subtitle">View past payments, invoices, and subscription charges.</p>
            </div>
        </header>

        <div class="portal-card" style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 10px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); width: 100%; box-sizing: border-box; overflow: hidden; margin-top: 16px;">
            <div class="card-header-custom" style="padding: 16px 20px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                <h2 class="card-title-custom" style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0;">Transaction History</h2>
                <a href="javascript:void(0)" onclick="exportTransactionsCSV()" class="btn btn-outline-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 12px; font-size: 12.5px; font-weight: 600; color: #475569; background: #ffffff; cursor: pointer; transition: all 0.15s; text-decoration: none;">
                    <i class="bi bi-download" style="font-size: 13px;"></i> Export CSV
                </a>
            </div>
            <div class="card-body-custom" style="padding: 0; overflow-x: auto;">
                @if(count($transactions))
                    <table class="info-table" style="width: 100%; border-collapse: collapse; min-width: 700px;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <th style="background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; width: 18%;">Date</th>
                                <th style="background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; width: 37%;">Description</th>
                                <th style="background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; width: 12%;">Plan</th>
                                <th style="background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; width: 13%;">Amount</th>
                                <th style="background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: left !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; width: 12%;">Status</th>
                                <th style="background: #ffffff !important; background-image: none !important; color: var(--text-muted) !important; padding: 14px 20px; text-align: center !important; font-size: 13px !important; font-weight: 500 !important; text-transform: none !important; width: 8%;">Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $t)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="info-value" style="padding: 14px 20px; width: 18%; font-size: 13px; color: #475569; white-space: nowrap;">
                                        {{ $t->date }}
                                    </td>
                                    <td class="info-value" style="padding: 14px 20px; width: 37%; font-size: 13px; font-weight: 600; color: #0f172a; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                        {{ $t->description }}
                                    </td>
                                    <td class="info-value" style="padding: 14px 20px; width: 12%; font-size: 13px; color: #64748b; white-space: nowrap;">
                                        {{ $t->plan }}
                                    </td>
                                    <td class="info-value" style="padding: 14px 20px; width: 13%; font-size: 13px; font-weight: 700; color: #0f172a; white-space: nowrap;">
                                        {{ $t->amount }}
                                    </td>
                                    <td class="info-value" style="padding: 14px 20px; width: 12%; white-space: nowrap;">
                                        @if($t->status === 'Completed')
                                            <span class="status-pill active-status" style="margin: 0; padding: 4px 10px; font-size: 11px; border-radius: 12px; font-weight: 600; background-color: #e6f4ea; color: #137333; display: inline-block;">Completed</span>
                                        @elseif($t->status === 'Refunded')
                                            <span class="status-pill" style="margin: 0; padding: 4px 10px; font-size: 11px; border-radius: 12px; font-weight: 600; background-color: #fff3e0; color: #e65100; display: inline-block;">Refunded</span>
                                        @else
                                            <span class="status-pill" style="margin: 0; padding: 4px 10px; font-size: 11px; border-radius: 12px; font-weight: 600; background-color: #fef9c3; color: #854d0e; display: inline-block;">{{ $t->status }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 14px 20px; text-align: center; width: 8%; white-space: nowrap; box-sizing: border-box;">
                                        @if($t->invoice_url)
                                            <a href="{{ $t->invoice_url }}" target="_blank" class="text-danger fw-semibold" style="font-size: 13px; color: var(--primary-color); font-weight: 600; text-decoration: none;">View</a>
                                        @else
                                            <span style="color: #cbd5e1;">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-5 text-muted" style="text-align: center; padding: 48px 0; color: var(--text-muted);">
                        <i class="bi bi-receipt-cutoff" style="font-size: 36px; display: block; margin-bottom: 12px;"></i>
                        <span>No transaction records found.</span>
                    </div>
                @endif
            </div>
        </div>
        <p style="margin-top: 12px; font-size: 12px; color: var(--text-muted); text-align: left; padding-left: 4px;">
            Showing {{ count($transactions) }} transactions. Contact support for records older than 3 years.
        </p>
    </section>

    <script>
    function exportTransactionsCSV() {
        var csv = [];
        var rows = document.querySelectorAll("table.info-table tr");
        
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
