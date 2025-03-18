<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<style>
    body{
        font-family: "Roboto", sans-serif;
        font-optical-sizing: auto;
        font-weight:400;
        font-style: normal;
        font-variation-settings:"wdth" 100;
    }
    table{
        width:100%;
        height:auto;
        border-collapse: collapse;
    }

    h4, h1, h5, h2, h3, h6, p {
        margin-top: 0;
        color:#000;
    }
</style>
</head>
<body>

<table class="table-custom">
    <tr>
        <td style="width:60%;">
            <img src="{{  public_path('assets/img/stanny.png')}}" style="width:130px; height:auto;">
        </td>
        <td style="width:40%;">
            <h4 style="margin-top: 0; margin-bottom: 10px; font-size: 14px; font-style: italic; margin-bottom: 20px;">Vetro destination ideale</h4>
            <p style="font-size: 12px; margin-bottom: 6px; color:#ccc;">Lorem Ipsum is simply dummy text</p>
            <p style="font-size: 12px; margin-bottom: 6px; color:#ccc;">Lorem Ipsum is </p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td style="width:50%"></td>
                    <td style="width:50%">
                        <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">STE RADHEY's SARL</h3>
                        <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">centre ville</h3>
                        <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">bzv</h3>
                        <h3 style="font-size: 17px; margin-bottom: 3px;">congo</h3>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h2 style="font-size: 30px; color:#acacac; font-weight: 400;">Invoice: {{ $invoice->invoice_no }}</h2>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom: 1px solid #ccc; padding-bottom: 25px;">
            <table>
                <tr>
                    <td>
                        <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Invoice Date:</h5>
                        <p style="color:#000; font-size: 14px;">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</p>
                    </td>
                    <td>
                        <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Due Date:</h5>
                        <p style="color:#000; font-size: 14px;">{{ \Carbon\Carbon::parse($invoice->order->last_payment_date)->format('d-m-Y') }}</p>
                    </td>
                    <td>
                        <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Source:</h5>
                        <p style="color:#000; font-size: 14px;">{{ $invoice->order->order_number }}</p>
                    </td>
                    <td>
                        <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Referrnce:</h5>
                        <p style="color:#000; font-size: 14px;">{{ $invoice->order->order_number }}</p>
                    </td>

                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <table>
                <thead style="text-align: left;">
                    <th style="padding:8px 0; font-size: 14px;">Decriptions</th>
                    <th style="padding:8px 0; font-size: 14px;">Quantity</th>
                    <th style="padding:8px 0; font-size: 14px;">Unit Price</th>
                    <th style="padding:8px 0; font-size: 14px;">Taxes</th>
                    <th style="padding:8px 0; font-size: 14px;">Total price</th>
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
                            <td style="width:60%; line-height: 1.6; font-size: 13px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard</td>
                            <td style="font-size: 13px;">{{ $item->quantity }} set</td>
                            <td style="font-size: 13px;">{{ number_format( ($item->total_price)/($item->quantity) ) }}</td>
                            <td style="font-size: 13px;">0.00</td>
                            <td style="font-size: 13px;">{{ number_format( $item->total_price ) }} FCFA</td>
                        </tr>
                        @endforeach
                        @endif
                </tbody>
            </table>
            <table style="margin-top: 45px;">
                <tr>
                    <td style="width:50%;"></td>
                    <td>
                        <table style="border-top: 1px solid #ccc;">
                            <tr>
                                <td style="font-weight: 600; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">Total</td>
                                <td style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">{{ number_format($invoice->net_price) }} FCFA</td>
                            </tr>
                            <tr>
                                <td style="color:#a2a0a0; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">H.T</td>
                                <td style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">0.00 FCFA</td>
                            </tr>
                            <tr>
                                <td style="color:#a2a0a0; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">T.V.A</td>
                                <td style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">0.00 FCFA</td>
                            </tr>
                            <tr>
                                <td style="color:#a2a0a0; padding: 6px; font-size: 13px;">C.A</td>
                                <td style="text-align: right; padding: 6px; font-size: 13px;">0.00 FCFA</td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px; padding: 6px; font-style: italic; border-bottom: 1px solid #ccc;">paid on {{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }} using cash</td>
                                <td style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">{{ number_format($invoice->net_price - $invoice->required_payment_amount) }} FCFA</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px; font-weight: 600; font-size: 13px;">Amout Due</td>
                                <td style="text-align: right; padding: 6px; font-size: 13px;">{{ number_format($invoice->required_payment_amount) }} FCFA</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p style="font-size: 13px; margin-top: 20px;">Please use the following communication for your payment: {{ $invoice->invoice_no }}</p>
        </td>
    </tr>
</table>


<table style="border-color:#000; border-style: double; border-bottom: 0; border-right: 0; border-left:0; margin-top: 35px;">
    <tr>
        <td style="font-size: 13px; padding: 4px;">PNR: Lorem Ipsum is simply dummy text of the printing</td>
        <td style="font-size: 13px; padding: 4px;">Mobile: +148 15265978</td>
        <td style="font-size: 13px; padding: 4px;">Email: info-pro@gmail.com</td>
    </tr>
    <tr>
        <td style="font-size: 13px; padding: 4px;">PNR: Lorem Ipsum is simply dummy text of the printing</td>
        <td style="font-size: 13px; padding: 4px;">Mobile: +148 15265978</td>
        <td style="font-size: 13px; padding: 4px;">Email: info-pro@gmail.com</td>
    </tr>
</table>

</body>
</html