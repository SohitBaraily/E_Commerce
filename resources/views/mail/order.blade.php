<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Vendor Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .content p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .details strong {
            display: inline-block;
            width: 120px;
            color: #555;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eee;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                margin: 10px;
                padding: 10px;
            }

            .header h1 {
                font-size: 20px;
            }

            .content h2 {
                font-size: 18px;
            }

            .details strong {
                width: 100px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Order Request</h1>
        </div>
        <div class="content">
            <h2>Dear Vendor</h2>
            <p>A new order has submitted a registration request. Please review the details below:</p>
            @foreach ($order->order_description as $des)
                <div class="details">
                    <p><strong>Product Name:</strong> {{ $des->product->name }}</p>
                    <p><strong>Quantity:</strong> {{ $des->quantity }}</p>
                </div>
            @endforeach
            <div class="details">
                <p><strong>Total Amount:</strong> {{ $order->total_amount }}</p>
            </div>
        </div>
        <div class="footer">
            <p>This is an automated email. Please do not reply directly to this message.</p>
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
