<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            /* Monospace for thermal printer look */
        }

        .receipt {
            /* max-width: 320px; */
            border: 1px dashed #000;
            padding: 15px;
            margin: auto;
            background: #fff;
        }

        .header {
            text-align: center;
            font-weight: bold;
        }

        .table td,
        .table th {
            text-align: center;
            vertical-align: middle;
            font-size: 30px;
        }
        p{
           font-size: 40px; 
        }
        h5 {
            font-size: 50px;
        }

        .bold {
            font-weight: bold;
        }

        .amount-box {
            border: 1px solid #000;
            padding: 5px;
            font-size: 48px;
        }

        .amount-box td {
            text-align: center;
            font-size: 40px;
            padding: 2px;
        }

        .dotted-line {
            border-top: 1px dashed black;
            margin: 10px 0;
        }

        p {
            margin-bottom: 0px;
        }
        .text-center {
            text-align: center;
        }
        
    </style>
</head>

<body>

    <div class="receipt">
        <div class="text-center">
            <p>Jai Shree Ganesh</p>
            <p>Jai Shree Krishna</p>
            <h5 class="fw-bold" style="font-size: 60px;">STANNY'S</h5>
            <p>LE MONDE DU LUXE</p>
        </div>

        <div class="dotted-line"></div>
        <div class="d-flex justify-content-between align-items-start">
            <!-- Left Column (Personal Info) -->
            <div class="col-12">
                <p><strong>Mr/Mrs:</strong> {{ $invoice->customer->name }}</p>
                <p><strong>Rank:</strong> {{ $invoice->customer->employee_rank }}</p>
            </div>

            <!-- Right Column (Amount Details) -->
            {{-- <div class="col-4">
                <div style="text-align: right;">
                    <table class="table table-sm table-bordered amount-box">
                        <tbody>
                            <tr>
                                <td>Amount:</td>
                                <td class="fw-bold">{{ number_format($invoice->net_price) }}</td>
                            </tr>
                            <tr>
                                <td>Deposit:</td>
                                <td class="fw-bold">{{ number_format($invoice->net_price - $invoice->required_payment_amount) }}</td>
                            </tr>
                            <tr>
                                <td>Balance:</td>
                                <td class="fw-bold">{{ number_format($invoice->required_payment_amount) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}
        </div> 
        <p><strong>Co/Ins Name:</strong> {{ $invoice->customer?$invoice->customer->company_name :" " }}</p>
        <p style="text-align: justify;"><strong>Address:</strong> {{ $invoice->order?$invoice->order->billing_address:" "}}</p>
        
        <div class="dotted-line"></div>

        <table class="table table-sm table-bordered mt-3">
            <thead>
                <tr>
                    <th style="text-align: left !important;">ITEM DESC</th>
                    <th>QTY</th>
                    <th>PAMT</th>
                    <th>NET AMT</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalQuantity = 0;
                @endphp
                @if($invoice->order)
                    @foreach($invoice->order->items as $item)
                        @php
                            $totalQuantity += $item->quantity;
                        @endphp
                        <tr>
                            <td style="text-align: left !important;">{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format( ($item->total_price)/($item->quantity) ) }}</td>
                            <td>{{ number_format( $item->total_price ) }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td class="bold" style="text-align: center;">SUBTOTAL</td>
                    <td class="text-center bold">{{ number_format($invoice->net_price) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="bold" style="text-align: center;">DEPOSIT</td>
                    <td class="text-center bold">{{ number_format($invoice->net_price - $invoice->required_payment_amount) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="bold" style="text-align: center;">BALANCE DUE</td>
                    <td class="text-center bold">{{ number_format($invoice->required_payment_amount) }}</td>
                </tr>\
            </tbody>
        </table>
        <div class="dotted-line"></div>
        <p class="text-center">Your mobile number has been successfully registered with STANNY'S.</p>

        {{-- <p class="bold">PIECES PURCHASED: {{ $totalQuantity }}</p> --}}

        <div class="dotted-line"></div>

        <p class="text-center">Thank you for shopping with us! </p>
    </div>
    {{-- {{dd('here')}} --}}
</body>

</html>
