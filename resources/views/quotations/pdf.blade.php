<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotation #{{ $quotation->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #374151;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .a4-page {
            width: 180mm; 
            min-height: 267mm; 
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 3px;
            vertical-align: top;
        }

        .header-table td {
            vertical-align: top;
        }

        .client-table td {
            padding: 2mm 0;
        }

        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 2mm;
        }

        .items-table th {
            background-color: #ccc;
        }

        .totals-table td {
            padding: 2mm;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .logo { width: 60px; height: 60px; }

        .totals-container {
            width: 100%;
            display: block;
            margin-top: 5mm;
        }

        .totals-table {
            width: 40%;
            margin-left: auto; 
            border: 1px solid #000;
        }

        .items-table, .items-table tbody tr {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .clearfix { clear: both; }

        .items-table td, .items-table th {
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="a4-page">
        <table class="header-table">
            <tr>
                <td style="width:50%;">
                    <img src="{{ public_path('images/logo.PNG') }}" class="logo">
                    <p class="bold">QuoteFlow Solutions</p>
                    <p>123 Business Blvd, Suite 400</p>
                </td>
                <td style="width:50%; text-align:right;">
                    <p class="bold" style="font-size:18px;">QUOTATION</p>
                    <p>#{{ $quotation->id }}</p>
                </td>
            </tr>
        </table>

        <table class="client-table">
            <tr>
                <td style="width:50%;">
                    <p class="bold">Billed To:</p>
                    <p class="bold">{{ $quotation->client->name ?? 'N/A' }}</p>
                    <p>{{ $quotation->client->email ?? 'N/A' }}</p>
                    <p>{{ $quotation->client->address ?? 'N/A' }}</p>
                </td>
                <td style="width:50%; text-align:right;">
                    <p>Quotation Date: {{ $quotation->created_at->format('Y-m-d') }}</p>
                    <p>Due Date: {{ $quotation->due_date ?? 'N/A' }}</p>
                    <p>Status: {{ $quotation->status }}</p>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:45%;">Item Description</th>
                    <th style="width:10%;">Qty</th>
                    <th style="width:10%;">Unit Price</th>
                    <th style="width:10%;">Tax</th>
                    <th style="width:10%;">Discount</th>
                    <th style="width:10%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">RS{{ number_format($item->unit_price,2) }}</td>
                    <td class="text-right">RS{{ number_format($item->tax,2) }}</td>
                    <td class="text-right">RS{{ number_format($item->discount,2) }}</td>
                    <td class="text-right bold">RS{{ number_format($item->total,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-container">
            <table class="totals-table">
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">RS{{ number_format($quotation->subtotal,2) }}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td class="text-right">RS{{ number_format($quotation->tax,2) }}</td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td class="text-right">RS{{ number_format($quotation->discount,2) }}</td>
                </tr>
                <tr>
                    <td class="bold">Total:</td>
                    <td class="text-right bold">RS{{ number_format($quotation->total,2) }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <div style="margin-top:5mm; text-align:center;">
            <p>Thank you for doing business with us!</p>
        </div>
    </div>
</body>
</html>
