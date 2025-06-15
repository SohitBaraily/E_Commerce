<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Voucher</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f2f2f2;
        }

        .voucher-container {
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
        }

        .voucher-header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .voucher-header h1 {
            color: #4CAF50;
            margin: 0;
        }

        .voucher-info {
            margin-bottom: 20px;
        }

        .voucher-info p {
            margin: 6px 0;
            font-size: 16px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        .details-table th {
            background-color: #f4f4f4;
        }

        .summary {
            text-align: right;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .footer {
            font-size: 14px;
            color: #666;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        @media print {
            .voucher-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }

            body {
                background: #fff;
            }
        }
    </style>
</head>

<body>
    <div class="voucher-container">
        <div class="voucher-header">
            <h1>Order Voucher</h1>
            <p>Order #{{ $order->id }}</p>
            <p>Status: {{ ucfirst($order->status) }}</p>
            <p>Date: {{ $order->created_at->format('d M Y') }}</p>
        </div>

        <div class="voucher-info">
            <p><strong>Customer:</strong> {{ $order->user->name }}</p>
            <p><strong>Contact:</strong> {{ $order->contact }}</p>
            <p><strong>Delivery Address:</strong> {{ $order->available_address->address }}</p>
            <p><strong>Delivery Charge:</strong> Rs. {{ $order->available_address->price }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            @if($order->address_note)
                <p><strong>Note:</strong> {{ $order->address_note }}</p>
            @endif
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Line Total</th>
                </tr>
            </thead>
            <tbody>
                @php $subTotal = 0; @endphp
                @foreach($order->order_description as $index => $desc)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $desc->product->name }}</td>
                        <td>{{ $desc->quantity }}</td>
                        <td>Rs. {{ number_format($desc->product->price, 2) }}</td>
                        <td>Rs. {{ number_format($desc->amount, 2) }}</td>
                        @php $subTotal += $desc->amount; @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p><strong>Subtotal:</strong> Rs. {{ number_format($subTotal, 2) }}</p>
            <p><strong>Delivery:</strong> Rs. {{ number_format($order->available_address->price, 2) }}</p>
            <p><strong>Total Amount:</strong> Rs. {{ number_format($order->total_amount, 2) }}</p>
        </div>

        <div class="footer">
            <p>Thank you for your order!</p>
            <p>&copy; {{ date('Y') }} YourCompany. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
