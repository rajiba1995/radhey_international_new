<div class="container-fluid px-4">

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
           

        }

        

        .table-container table {
            flex-grow: 1;
            width: 100%;
            border-collapse: collapse;

        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 75px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-end;

        }

        html,
        body {
            height: 100%;
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



    <div class="table-container">
        <table class="table-custom">
            <tr>
                <td style="width:60%;">
                    <img src="{{  asset('assets/img/pdf_logo.png')}}" style="width:210px; height:auto;">
                </td>
                <td style="width:40%;">
                    <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">STE RADHEY'S SARL</h3>
                    <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">CAPITAL: 1.000.000 FCFA
                    </h3>
                    <h3 style="text-transform: uppercase; font-size: 15px; margin-bottom: 3px;">NIU M24000000659298E
                    </h3>
                    <h3 style="font-size: 15px; margin-bottom: 3px;">RCCM CG-PNR-01-2024-B12-00203</h3>
                </td>
            </tr>
           
            <tr>
                <td colspan="2">
                    <h2 style="font-size: 20px; color:#2d1e1e; font-weight: 400;">Invoice: INV/{{ date('Y') }}/</h2>
                </td>
            </tr>
            {{-- <tr>
                <td colspan="2" style="border-bottom: 1px solid #ccc; padding-bottom: 25px;">
                    <table>
                        <tr>
                            <td>
                                <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Invoice
                                    Date:</h5>
                                <p style="color:#000; font-size: 14px;">{{
                                    \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</p>
                            </td>
                            <td>
                                <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Due Date:
                                </h5>
                                <p style="color:#000; font-size: 14px;">{{
                                    \Carbon\Carbon::parse($invoice->order->last_payment_date)->format('d-m-Y') }}</p>
                            </td>
                            <td>
                                <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">Source:
                                </h5>
                                <p style="color:#000; font-size: 14px;">{{ $invoice->order->order_number }}</p>
                            </td>
                            <td>
                                <h5 style="color:#000; font-size: 16px; font-weight: 600; margin-bottom: 6px;">
                                    Referrnce:</h5>
                                <p style="color:#000; font-size: 14px;">{{ $invoice->order->order_number }}</p>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr> --}}

            <tr>
                <td colspan="2">
                    <table>
                        <thead style="text-align: left;">
                            <tr>
                                <th style="padding:8px 0; font-size: 14px; text-align: left;">Decriptions</th>
                                <th style="padding:8px 0; font-size: 14px; text-align: left;">Quantity</th>
                                <th style="padding:8px 0; font-size: 14px; text-align: left;">Unit Price</th>
                                {{-- <th style="padding:8px 0; font-size: 14px;">Taxes</th> --}}
                                <th style="padding:8px 0; font-size: 14px; text-align: left;">Total Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $index => $row)
                                
                            <tr>
                                <td style="line-height: 1.6; font-size: 13px;">
                                    <select class="form-control product-select" wire:model="rows.{{ $index }}.product_id">
                                        <option value="" selected hidden>Select Product</option>
                                        @foreach ($products as $product)
                                        <option value="{{$product['id']}}">{{$product['name']}}</option>
                                        @endforeach
                                    </select>
                                    @error('rows.'.$index.'.product_id')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary btn-qty minus" type="button"
                                                wire:click="updateQuantity({{ $index }}, 'decrease')">-</button>
                                        </div>
                                        <input type="text" class="form-control quantity text-center" value="1" min="1"
                                            wire:model="rows.{{ $index }}.quantity" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-qty plus" type="button"
                                                wire:click="updateQuantity({{ $index }}, 'increase')">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size: 13px;">
                                    <input type="text" class="form-control amount" wire:model="rows.{{ $index }}.unit_price"
                                    wire:keyup="updatePrice({{ $index }})" placeholder="Enter Amount">
                                    @error('rows.'.$index.'.unit_price')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </td>
                                {{-- <td style="font-size: 13px;">0.00</td> --}}
                                <td style="font-size: 13px;"><input type="text" class="form-control amount" value="0" readonly
                                    wire:model="rows.{{ $index }}.total"> FCFA</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row"
                                        wire:click="removeRow({{$index}})"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            <button class="btn btn-success btn-sm" wire:click="addRow"><i class="fas fa-plus"></i> Add Row</button>
                        </tbody>
                    </table>
                    <table style="margin-top: 45px;">
                        <tr>
                            <td style="width:50%;"></td>
                            <td>
                                <table style="border-top: 1px solid #ccc;">
                                    @php
                                        $subtotal = collect($rows)->sum(function ($row) {
                                            return floatval($row['total']);
                                        });
                                        $tva = $subtotal * 0.18;
                                        $ca = $tva * 0.05;
                                        $ht_amount = $subtotal - ($tva + $ca);
                                     @endphp
                                    <tr>
                                        <td
                                            style="font-weight: 600; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            Total</td>
                                        <td
                                            style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            {{$subtotal}} FCFA</td>
                                    </tr>
                                   

                                    <tr>
                                        <td
                                            style="color:#a2a0a0; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            H.T</td>
                                        <td
                                            style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            {{ number_format($ht_amount, 2) }} FCFA</td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="color:#a2a0a0; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            T.V.A</td>
                                        <td
                                            style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                            {{ number_format($tva, 2) }}
                                            FCFA</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#a2a0a0; padding: 6px; font-size: 13px;">C.A</td>
                                        <td style="text-align: right; padding: 6px; font-size: 13px;">{{
                                            number_format($ca, 2) }}
                                            FCFA</td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="font-size: 13px; padding: 6px; font-style: italic; border-bottom: 1px solid #ccc;">
                                            paid on {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                                            using cash</td>
                                        <td
                                            style="text-align: right; padding: 6px; border-bottom: 1px solid #ccc; font-size: 13px;">
                                           
                                           0 FCFA</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px; font-weight: 600; font-size: 13px;">Amout Due</td>
                                        <td style="text-align: right; padding: 6px; font-size: 13px;">
                                            {{$subtotal}} FCFA</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="font-size: 13px; margin-top: 20px;">Please use the following communication for your
                        payment: INV/{{ date('Y') }}</p>
                </td>
            </tr>
        </table>
        <div class="footer">
            <table
                style="border-color:#000; border-style: double; border-bottom: 0; border-right: 0; border-left:0; margin-top: 35px;">
                <tr>
                    <td style="font-size: 13px; padding: 4px;">PNR: Lorem Ipsum is simply dummy text of the printing
                    </td>
                    <td style="font-size: 13px; padding: 4px;">Mobile: +148 15265978</td>
                    <td style="font-size: 13px; padding: 4px;">Email: info-pro@gmail.com</td>
                </tr>
                <tr>
                    <td style="font-size: 13px; padding: 4px;">PNR: Lorem Ipsum is simply dummy text of the printing
                    </td>
                    <td style="font-size: 13px; padding: 4px;">Mobile: +148 15265978</td>
                    <td style="font-size: 13px; padding: 4px;">Email: info-pro@gmail.com</td>
                </tr>
            </table>
        </div>
    </div>
</div>


