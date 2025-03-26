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
            <img src="{{  public_path('assets/img/pdf_logo.png')}}" style="width:130px; height:auto;">
        </td>
        <td style="width:40%;">
            < <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">STE RADHEY'S SARL</h3>
            <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">CAPITAL: 1.000.000 FCFA</h3>
            <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">NIU  M24000000659298E</h3>
            <h3 style="font-size: 15px; margin-bottom: 3px;">RCCM  CG-PNR-01-2024-B12-00203</h3>
        </td>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <h2 style="font-size: 30px; color:#acacac; font-weight: 400;">Order: {{ $invoice->order->order_number }}</h2>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom: 1px solid #ccc; padding-bottom: 25px;">
            <table>
                <tr>
                    <td style="width:50%;">
                        <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Order Date:</h5>
                        <p style="color:#000; font-size: 14px;">{{ \Carbon\Carbon::parse($invoice->order->created_at)->format('d-m-Y') }}</p>
                    </td>
                    <td style="width:50%;">
                        <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Sales Person:</h5>
                        <p style="color:#000; font-size: 14px;"> {{ $invoice->order->createdBy->name }}</p>
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
                    <th style="padding:8px 0; font-size: 14px;">Discount %</th>
                    <th style="padding:8px 0; font-size: 14px;">Taxes</th>
                    <th style="padding:8px 0; font-size: 14px;">Total price</th>
                </thead>
                <tbody>
                @php
                        $totalQuantity = 0;
                        $totalPrice = 0;
                    @endphp
                    @if($invoice->order)
                        @foreach($invoice->order->items as $item)
                            @php
                                $totalQuantity += $item->quantity;
                                $totalPrice += $item->total_price;
                            @endphp
                            <tr>
                                <td style="width:50%; line-height: 1.6; font-size: 13px; vertical-align: top;">
                                    <p>{{ $item->product_name }}</p>
                                    <!-- <p>Coulour: Marron</p> -->
                                <td style="font-size: 13px; vertical-align: top;">{{ $item->quantity }} pcs</td>
                                <td style="font-size: 13px; vertical-align: top;">{{ number_format( ($item->total_price)/($item->quantity) ) }}</td>
                                <td style="font-size: 13px; vertical-align: top;">0.00%</td>
                                <td style="font-size: 13px; vertical-align: top;">--</td>
                                <td style="font-size: 13px; vertical-align: top;">{{ number_format( $item->total_price ) }} FCFA</td>
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
                                <td style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">{{ number_format( $totalPrice ) }} FCFA</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
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