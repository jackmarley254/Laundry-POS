<!DOCTYPE html>
<html>
<head>
    <style>
        /* General Reset for PDF */
        body {
            font-family: 'DejaVu Sans', sans-serif; /* DejaVu supports more characters than standard sans-serif in DomPDF */
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Header Styling */
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }

        /* Summary Box */
        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .summary-box strong {
            color: #000;
            font-size: 16px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        /* Zebra striping for rows */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Align numbers to the right for financial columns */
        .text-right {
            text-align: right;
        }
        
        /* Status badges */
        .status {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: capitalize;
        }
        .status-pending { background-color: #ffeeba; color: #856404; }
        .status-completed, .status-delivered { background-color: #c3e6cb; color: #155724; }
        .status-processing { background-color: #bee5eb; color: #0c5460; }
        .status-cancelled { background-color: #f5c6cb; color: #721c24; }
    </style>
</head>
<body>

    <!-- Centered Header -->
    <div class="header">
        <h1>Order Report</h1>
        <p>Generated on {{ date('F d, Y') }}</p>
    </div>

    <!-- Centered Summary Information -->
    <div class="summary-box">
        <p style="margin:0 0 5px 0;">
            <strong>Period:</strong> 
            {{ $startDate ?? 'N/A' }} to {{ $endDate ?? 'Now' }}
        </p>
        <p style="margin:0; font-size: 18px;">
            <strong>Total Sales:</strong> Ksh {{ number_format($totalSales, 2) }}
        </p>
    </div>

    <!-- Orders Table -->
    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th class="text-right">Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->invoice_no }}</td>
                <td>{{ $order->customer_name ?? 'Walk-in' }}</td>
                <td class="text-right">Ksh {{ number_format($order->total_amount, 2) }}</td>
                <td>
                    <span class="status status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>