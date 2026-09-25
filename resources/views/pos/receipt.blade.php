<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt {{ $order->invoice_no }}</title>
    
    <!-- Minimal styling for screen view -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        /* --- SCREEN STYLES (How it looks in browser) --- */
        body {
            background-color: #f4f6f9;
            padding: 20px;
        }
        .screen-container {
            max-width: 500px;
            margin: 0 auto;
        }
        /* The simulated thermal paper on screen */
        .receipt-paper {
            background: #fff;
            width: 80mm; /* Standard thermal width */
            margin: 0 auto;
            padding: 5mm;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }

        /* --- PRINT STYLES (How it looks on paper) --- */
        @media print {
            @page {
                size: A4; /* Or Auto */
                margin: 0; /* Remove browser default margins */
            }

            body {
                margin: 0;
                padding: 0;
                background: #fff;
            }

            /* Hide everything else on the page */
            body * {
                visibility: hidden;
            }

            /* Show only the receipt paper and its children */
            .receipt-paper, .receipt-paper * {
                visibility: visible;
            }

            /* Position it at the top-left, full size */
            .receipt-paper {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%; /* Fill the printable area */
                border: none;
                box-shadow: none;
                padding: 0; /* Remove padding for clean edge */
                margin: 0;
                font-size: 12pt; /* Force good print size */
            }
        }

        /* --- RECEIPT INTERNAL STYLES --- */
        .receipt-paper .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .receipt-paper .header h2 {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
        }
        .receipt-paper .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .receipt-paper .meta-table td {
            padding: 2px 0;
            font-size: 12px;
        }
        .receipt-paper .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .receipt-paper .items-table th {
            border-bottom: 1px solid #000;
            padding: 5px 0;
            text-align: left;
            font-size: 12px;
        }
        .receipt-paper .items-table td {
            padding: 5px 0;
            font-size: 12px;
        }
        .receipt-paper .totals-table {
            width: 100%;
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 10px;
        }
        .receipt-paper .totals-table td {
            padding: 3px 0;
        }
        .receipt-paper .footer {
            text-align: center;
            margin-top: 20px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="screen-container">
        <!-- Action Buttons (Hidden on Print) -->
        <div class="no-print d-flex justify-content-end mb-3 gap-2">
            <a href="{{ route('pos.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> New Order
            </a>
            <button onclick="window.print()" class="btn btn-dark btn-sm">
                <i class="bi bi-printer"></i> Print
            </button>
        </div>

        <!-- The Receipt Paper -->
        <div class="receipt-paper">
            
            <!-- Header -->
            <div class="header">
                <h2>Laundry POS</h2>
                <div style="font-size: 11px; margin-top: 5px;">
                    P.O. Box 12345, Nairobi<br>
                    Tel: +254 700 000 000
                </div>
            </div>

            <!-- Invoice Details -->
            <table class="meta-table">
                <tr>
                    <td>Invoice:</td>
                    <td style="text-align: right; font-weight: bold;">{{ $order->invoice_no }}</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td style="text-align: right;">{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Customer:</td>
                    <td style="text-align: right;">{{ $order->customer_name }}</td>
                </tr>
                <tr>
                    <td>Tel:</td>
                    <td style="text-align: right;">{{ $order->customer_phone }}</td>
                </tr>
            </table>

            <!-- Items List -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Item</th>
                        <th style="width: 20%; text-align: center;">Qty</th>
                        <th style="width: 30%; text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->service_name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <table class="totals-table">
                <tr>
                    <td>TOTAL:</td>
                    <td style="text-align: right; font-weight: bold;">Ksh {{ number_format($order->total_amount, 2) }}</td>
                </tr>
                
                @if($order->paid_amount > 0)
                <tr>
                    <td>Paid:</td>
                    <td style="text-align: right;">Ksh {{ number_format($order->paid_amount, 2) }}</td>
                </tr>
                @endif

                @if($order->total_amount - $order->paid_amount > 0)
                <tr style="font-weight: bold; font-size: 13px;">
                    <td>BALANCE:</td>
                    <td style="text-align: right;">Ksh {{ number_format($order->total_amount - $order->paid_amount, 2) }}</td>
                </tr>
                @endif
            </table>

            <!-- Pickup Reminder -->
            <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 8px 0; margin-top: 10px; text-align: center; font-weight: bold;">
                PICKUP DATE: {{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}
            </div>

            <!-- Footer -->
            <div class="footer">
                <p style="margin: 0; font-weight: bold;">*** THANK YOU ***</p>
                <p style="margin: 5px 0 0 0; font-size: 10px;">Powered by Laravel POS</p>
            </div>

        </div>
    </div>

</body>
</html>