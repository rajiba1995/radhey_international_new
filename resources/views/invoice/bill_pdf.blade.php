<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Roboto", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }

        table {
            width: 100%;
            height: auto;
            border-collapse: collapse;
        }

        .table-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: relative;
            z-index: 3;
            background-image: url("./assets/img/watermark-logo.png");
            background-position: 50% 100%;
            background-attachment: scroll;
            background-repeat: no-repeat;
            background-size: 60%;
        }

        .table-container table {
            flex-grow: 1;
            width: 100%;
            border-collapse: collapse;

        }

        /* .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 75px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-end;

        } */
        .footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .footer strong {
            font-family: "Roboto", sans-serif;
            font-weight: 700;
        }

        .footer div {
            font-family: "Roboto", sans-serif;
            letter-spacing: 0.5px;
        }

        h4,
        h1,
        h5,
        h2,
        h3,
        h6,
        p {
            margin-top: 0;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="table-container">
        <table class="table-custom">
            <tr>
                <td style="width:60%;">
                    <img src="{{  public_path('assets/img/pdf_logo.png')}}" style="width:210px; height:auto;">
                </td>
                <td style="width:40%;">
                    <h3 style="font-size: 15px; margin-bottom: 3px;">Number:- (+242) 05 554 7777</h3>
                    <h3 style="font-size: 15px; margin-bottom: 3px;">Number:- (+242) 05 554 77 77
                    </h3>
                    <h3 style="font-size: 15px; margin-bottom: 3px;">Mail:- contact@stannys.com
                    </h3>
                    <h3 style="font-size: 15px; margin-bottom: 3px;">Website:- www.stannys.com</h3>
                    <h3 style="font-size: 15px; margin-bottom: 3px;">Address:- 18, Blv. Denis Sassou N'guesso,
                        Brazzaville, République du Congo</h3>
                    <div style="border: 1px solid #000; padding: 10px; border-radius: 5px; margin-top: 10px;">
                        <h3 style="font-size: 15px; margin-bottom: 3px;">Client's Name: {{$invoice->customer ?
                            $invoice->customer->name : ""}}</h3>
                        <h3 style="font-size: 15px; margin-bottom: 3px;">Address: @if($invoice->customer &&
                            $invoice->customer->billingAddressLatest)
                            {{ $invoice->customer->billingAddressLatest->address }},
                            {{ $invoice->customer->billingAddressLatest->landmark ?
                            $invoice->customer->billingAddressLatest->landmark . ',' : '' }}
                            {{ $invoice->customer->billingAddressLatest->city }},
                            {{ $invoice->customer->billingAddressLatest->state }},
                            {{ $invoice->customer->billingAddressLatest->country }},
                            {{ $invoice->customer->billingAddressLatest->zip_code }}
                            @else
                            Not Available
                            @endif
                        </h3>
                        <h3 style="font-size: 15px; margin-bottom: 3px;">Contact :
                            {{$invoice->customer->country_code_phone.' '.$invoice->customer->phone}}
                        </h3>
                    </div>
                </td>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <h2 style="font-size: 30px; color:#acacac; font-weight: 400;">Order: {{
                        $invoice->order->order_number }}
                    </h2>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: 1px solid #ccc; padding-bottom: 25px;">
                    <table>
                        <tr>
                            <td style="width:50%;">
                                <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Order
                                    Date:
                                </h5>
                                <p style="color:#000; font-size: 14px;">{{
                                    \Carbon\Carbon::parse($invoice->order->created_at)->format('d-m-Y') }}</p>
                            </td>
                            <td style="width:50%;">
                                <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Name:
                                </h5>
                                <p
                                    style="color:#000; word-break: break-word; white-space: normal; max-width: 200px; font-size: 14px;">
                                    {{ $invoice->customer ?$invoice->customer->name : "N/A" }}
                                </p>
                            </td>
                            <td style="width:50%;">
                                <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Sales
                                    Person:
                                </h5>
                                <p style="color:#000; font-size: 14px;"> {{ $invoice->order?->createdBy?->name ?? "N/A"
                                    }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table>
                        <thead style="text-align: left;">
                            <th style="padding:8px 0; font-size: 14px; text-align:left;">Decriptions</th>
                            <th style="padding:8px 0; font-size: 14px; text-align:left;">Quantity</th>
                            <th style="padding:8px 0; font-size: 14px; text-align:left;">Unit Price</th>
                            {{-- <th style="padding:8px 0; font-size: 14px;">Discount %</th>
                            <th style="padding:8px 0; font-size: 14px;">Taxes</th> --}}
                            <th style="padding:8px 0; font-size: 14px; text-align:left;">Total Price</th>
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
                                <td style="font-size: 13px; vertical-align: top;">{{ number_format(
                                    ($item->total_price)/($item->quantity) ) }}</td>
                                {{-- <td style="font-size: 13px; vertical-align: top;">0.00%</td>
                                <td style="font-size: 13px; vertical-align: top;">--</td> --}}
                                <td style="font-size: 13px; vertical-align: top;">{{ number_format( $item->total_price )
                                    }}
                                    FCFA</td>
                            </tr>
                            @endforeach
                            @if ($invoice->order->air_mail > 0)
                            @php
                            $airMail = $invoice->order->air_mail;
                            $totalPrice += $airMail;
                            @endphp
                            <tr>
                                <td style="width:50%; line-height: 1.6; font-size: 13px; vertical-align: top;">
                                    Air Mail
                                </td>
                                <td style="font-size: 13px; vertical-align: top;">1</td>
                                <td style="font-size: 13px; vertical-align: top;">{{ number_format($airMail)}}</td>
                                <td style="font-size: 13px; vertical-align: top;">{{ number_format( $airMail ) }}
                                    FCFA</td>
                            </tr>
                            @endif
                            @endif


                        </tbody>
                    </table>
                    <table style="margin-top: 45px;">
                        <tr>
                            <td style="width:50%;"></td>
                            <td>
                                <table style="border-top: 1px solid #ccc;">
                                    <tr>
                                        <td
                                            style="font-weight: 600; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            Total</td>
                                        <td
                                            style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            {{ number_format( $totalPrice ) }} FCFA</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <div class="footer">
            <div style="border-top: 1px solid #000; text-align: center; padding-top: 2px;">
                <div style="margin-top: -18px; font-weight: bold; text-transform: uppercase; font-size: 14px;">
                    STE RADHEY'S SARL
                </div>
                <div style="font-size: 13px; margin-top: 2px;">
                    CAPITAL: 1.000.000 FCFA<br>
                    NIU M24000000659298E<br>
                    RCCM: CG-BZV-01-2025-B20-00004
                </div>
                <div style="font-size: 12px; margin-bottom: 5px;">
                    <span style="margin-right: 15px;"><strong>Coordonnées Bancaires :</strong></span>
                    <span style="padding-left: 10px;">
                        <strong> BSCA Bank : | 30020 88101 | 10125540000 08 </strong>
                    </span>
                </div>
            </div>
        </div>
    </div>



</body>

</html