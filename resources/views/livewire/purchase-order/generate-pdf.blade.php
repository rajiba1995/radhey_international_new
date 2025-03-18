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
    .box {
        border: 1px solid #000;
        padding: 9px 7px;
        height: 100px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 8px 11px 0px rgba(0, 0, 0, 0.2);
    }

</style>
</head>
<body>

<table class="table-custom">
    <tr>
        <td style="width:50%; vertical-align: top;">
            <img src="{{  public_path('assets/img/stanny.png')}}" style="width:200px; height:auto;">
        </td>
        <td style="width:50%; vertical-align: center;">
            <div class="box">
                <h2 style="text-transform:uppercase; font-size: 16px; color:#000;">Client home and decor</h2>
                <span>NIU:</span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 28px;">
            <table>
                <tr>
                    <td style="width:50%">
                        <p style="font-size: 15px; color:#000; margin-bottom: 3px; line-height: 23px;">
                            Avenue Orsy Centre-Ville <br>
                            11, Av. Mundji, Q/Boyera, Commune De Mbandaka <br>
                            Phone number:  (+243)817301069 <br>
                            Email: info_BRA@gmail.com <br>
                            NUR: M2456985896325478 <br>
                            RCCM: CG/PNR/09-56-ko
                        </p>
                    </td>
                    <td style="width:50%; vertical-align: top;">
                        <table>
                            <tr>
                                <td>
                                    <h3 style="font-size:17px; margin-bottom: 8px;">What is Lorem Ipsum?</h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <table style="border:1px solid #000;">
                                        <tr>
                                            <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 50%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">N discount</th>
                                            <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 50%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Date</th>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; text-transform: uppercase; width: 50%; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">bdmk55689758</td>
                                            <td style="text-align: center; text-transform: uppercase; width: 50%; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">15-2-2025</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                                <p style="margin-bottom: 0;">REFERENCE: sk radhey sarl</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                                <p style="margin-bottom: 0;">representant: home n decore</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @if ($purchaseOrder->status == 0)
    
        @if ($purchaseOrder->orderproducts->where('stock_type', 'product')->count() > 0)
            <tr>
                <td colspan="2" style="padding-top:20px;">
                    <table style="border:1px solid #000; min-height: 450px;">
                        <thead style="text-align: left;">
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Reference</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Designation</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">QTE</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U HT</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">R %</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U Net</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000;">Montant HT</th>
                        </thead>
                        <tbody>
                        @php $i = 1; $totalProducts = 0; @endphp

                        @foreach ($purchaseOrder->orderproducts->where('stock_type', 'product') as $item)
                            @php $amount = $item->qty_in_pieces * $item->piece_price; $totalProducts += $amount; @endphp
                            <tr>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:5%;">{{ $purchaseOrder->unique_id }}</td>
                                <td style="width:50%; line-height: 1.6; font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000;">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <p>Coulour: Marron</p>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ $item->qty_in_pieces  }} pcs</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">0.00</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">0.00%</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">--</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ number_format($amount, 2) }} FCFA</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endif
        @if ($purchaseOrder->orderproducts->where('stock_type', 'fabric')->count() > 0 )
            <tr>
                <td colspan="2" style="padding-top:20px;">
                    <table style="border:1px solid #000; min-height: 450px;">
                        <thead style="text-align: left;">
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Reference</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Designation</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">QTE</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U HT</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">R %</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U Net</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000;">Montant HT</th>
                        </thead>
                        <tbody>
                        @php $j = 1; $totalFabrics = 0; @endphp
                            @foreach ($purchaseOrder->orderproducts->where('stock_type', 'fabric') as $item)
                                @php $amount = $item->qty_in_meter * $item->piece_price; $totalFabrics += $amount; @endphp
                            <tr>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:5%;">{{ $purchaseOrder->unique_id }}</td>
                                <td style="width:50%; line-height: 1.6; font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000;">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <p>Coulour: Marron</p>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ $item->qty_in_meter }} meter</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">0.00</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">0.00%</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">--</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ number_format($amount, 2) }} FCFA</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endif
    @else
        @if ($purchaseOrder->orderproducts->where('stock_type', 'product')->count() > 0)
            <tr>
                <td colspan="2" style="padding-top:20px;">
                    <table style="border:1px solid #000; min-height: 450px;">
                        <thead style="text-align: left;">
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Reference</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Designation</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">QTE</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U HT</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">R %</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U Net</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000;">Montant HT</th>
                        </thead>
                        <tbody>
                            @php $i = 1; $totalProducts = 0; @endphp
                            @foreach ($purchaseOrder->orderproducts->where('stock_type', 'product') as $item)
                                @php $amount = $item->qty_while_grn_product * $item->piece_price; $totalProducts += $amount; @endphp
                                <tr>
                                    <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:5%;">{{ $item->unique_id }}</td>
                                    <td style="width:50%; line-height: 1.6; font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000;">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        <p>Coulour: Marron</p>
                                    <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ $item->qty_in_pieces  }}2 pcs</td>
                                    <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">0.00</td>
                                    <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">0.00%</td>
                                    <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">--</td>
                                    <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ number_format($amount, 2) }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endif
        @if ($purchaseOrder->orderproducts->where('stock_type', 'fabric')->count() > 0 )
            <tr>
                <td colspan="2" style="padding-top:20px;">
                    <table style="border:1px solid #000; min-height: 450px;">
                        <thead style="text-align: left;">
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Reference</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">Designation</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">QTE</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U HT</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">R %</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000">P.U Net</th>
                            <th style="padding:8px; font-size: 14px; border:1px solid #000;">Montant HT</th>
                        </thead>
                        <tbody>
                        @php $j = 1; $totalFabrics = 0;
                            $i = 1; $totalProducts = 0;
                        @endphp
                        @foreach ($purchaseOrder->orderproducts->where('stock_type', 'fabric') as $item)
                            @php $amount = $item->qty_while_grn_fabric * $item->piece_price; $totalFabrics += $amount; @endphp
                            <tr>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:5%;">{{ $purchaseOrder->unique_id }}</td>
                                <td style="width:50%; line-height: 1.6; font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000;">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <p>Coulour: Marron</p>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ intval($item->qty_in_meter) }} meter</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">00.00</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">0.00%</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">--</td>
                                <td style="font-size: 13px; vertical-align: top; padding:8px; border:1px solid #000; width:9%;">{{ number_format($amount, 2) }} FCFA</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endif
    @endif
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td style="width:50%; vertical-align: top;">
                        <table style="border:1px solid #000;">
                            <tr>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Code</th>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Base</th>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Taux</th>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Montant</th>
                            </tr>

                            <tr>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                    1
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   ---
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   ---
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                    ---
                                </td>
                            </tr>
                            <tr>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                    2
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   ---
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   ----
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                    ---
                                </td>
                            </tr>
                            <tr>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   Total
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   ---
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   ---
                                </td>
                                <td style="text-transform: uppercase; vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   --- 
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td style="width:50%; vertical-align: top;">
                        <table style="border:1px solid #000;">
                            <tr>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Total HT</th>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Total TTC</th>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">Acompte</th>
                                <th style="text-align: center; text-transform: uppercase; font-weight: 600; width: 25%; vertical-align: top; padding: 8px; font-size: 14px; border:1px solid #000;">NET A PAYER</th>
                            </tr>

                            <tr>
                                <td style=" vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                    30,000
                                </td>
                                <td style=" vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   30000
                                </td>
                                <td style="vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                   ---
                                </td>
                                <td style="vertical-align: top; padding: 8px; font-size: 13px; border:1px solid #000;">
                                    30000
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="vertical-align: top; padding: 4px; font-size: 12px;">
                                   Arreter ie net a payer: 30,000
                                </td>
                                
                                <td colspan="2" style="vertical-align: top; padding: 4px; font-size: 12px; text-align: right;">
                                   france CFA
                                </td>
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