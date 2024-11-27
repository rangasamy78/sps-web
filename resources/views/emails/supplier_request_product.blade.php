<!DOCTYPE html>
<html>
<head>
    <title>Product Request Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 1000px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background-color: #007BFF;
            color: #fff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            line-height: 1.6;
        }

        .content p {
            margin: 15px 0;
        }

        .button {
            text-align: center;
            margin: 20px 0;
        }

        .button a {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>PrePurchase Request # {{ $data['content']['pre_purchase_request_id'] ?? ''}}</h1>
        </div>
        <div class="content">
            <p>{{ $data['content']['email_body'] ?? '' }}</p>
            <table width="100%" cellpadding="5" cellspacing="0" border="1">
                <thead>
                    <tr>
                        <th width="110">Ship To:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $data['content']['supplier']['supplier_name'] ?? '' }}<br>
                            {{ $data['content']['supplier_address'] ?? '' }}<br>
                            {{ $data['content']['supplier_suite'] ?? '' }}<br>
                            {{ $data['content']['supplier_state'] ?? '' }}-{{ $data['content']['supplier_city'] ?? '' }}-{{ $data['content']['supplier_zip'] ?? '' }}<br>
                            {{ $data['content']['country']['country_name'] ?? '' }}<br>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br />
            <table width="100%" cellpadding="5" cellspacing="0" border="1">
                <thead>
                    <tr>
                        <th width="30">Payment Terms</th>
                        <th width="30">Required ShipDate</th>
                        <th width="80">Shipment Terms</th>
                        <th width="30">Entered By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center">{{ $data['content']['account_payment_term']['payment_label'] ?? '' }}</td>
                        <td style="text-align:center">{{ \Carbon\Carbon::parse($data['content']['required_ship_date'])->format('M d, Y') ?? '' }}</td>
                        <td style="text-align:center">{{ $data['content']['shipment_term']['shipment_term_name'] ?? '' }}</td>
                        <td style="text-align:center">{{ $data['content']['user']['full_name'] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
            <br />
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Product Sku</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Bundles</th>
                        <th>Slabs</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['products'] as $key => $reqProduct)
                        <tr>
                            <td>{{ $reqProduct['product_sku'] ?? '' }}</td>
                            <td>{{ $reqProduct['generic_name'] ?? '' }}</td>
                            <td>{{ $reqProduct['description'] ?? '' }}</td>
                            <td>{{ $reqProduct['picking_qty']." Bundles" }}</td>
                            <td>{{ $reqProduct['slab']." Slabs" }}</td>
                            <td>{{ $reqProduct['qty'] . " SF" }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p>If you have any questions, feel free to reply to this email or contact us directly at <a
                    href="mailto:support@yourcompany.com">support@yourcompany.com</a>.</p>
        </div>
        <div class="button">
            @php $ctaUrl = "http://localhost/sps-web/pre_purchase_supplier_requests/create?id=1" @endphp
            <a href="{{ $ctaUrl }}">View More Details</a>
        </div>
        <div class="footer">
            <p>Thank you, <br>Your Company Team</p>
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
