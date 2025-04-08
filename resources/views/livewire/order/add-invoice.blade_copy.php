<div class="container-fluid px-4">
    <style>
        html,
        body {
            margin: 0;
            padding: 20px;
            /* height: 100%; */
            background: #f2f2f2;
            font-family: 'Segoe UI', sans-serif;
            width: 100%;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            height: 100%;
        }

        .receipt-main {
            background: #fff;
            padding: 20px;
            /* height: 100%; */
            width: 100%;
            box-sizing: border-box;
            border-top: 5px solid #dc3545;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .receipt-main h5,
        .receipt-main h3,
        .receipt-main p {
            margin: 0;
        }

        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .receipt-header img {
            width: 30%;
            border-radius: 50%;
        }

        .table thead th {
            background-color: #c6d2dd;
            color: #fff;
        }

        .input-group .form-control {
            max-width: 60px;
        }

        .btn-qty {
            min-width: 30px;
        }

        .text-total {
            font-size: 18px;
            font-weight: bold;
        }

        .print-btn {
            float: right;
        }

        .text-total {
            font-size: 20px;
            font-weight: bold;
        }

        .text-total+h6 {
            font-size: 14px;
            color: #444;
            font-style: italic;
        }
        /*  */
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
        


        @media print {

            /* Hide sidebar, buttons, or any other non-print content */
            .sidebar,
            .btn,
            .action-buttons,
            .print-hide,
            .print-hide-admin {
                display: none !important;
            }

            /* Ensure scrollable containers fully expand */
            .scrollable-container {
                max-height: none !important;
                overflow: visible !important;
            }

            table th:last-child,
            table td:last-child {
                display: none;
            }

            /* Optional: Set page size and margins for better print */
            @page {
                size: A4;
                margin: 1cm;
            }

            /* Prevent page breaks inside a row */
            .invoice-row {
                page-break-inside: avoid;
            }

            body {
                overflow: visible !important;
            }
        }
    </style>
    <div class="receipt-main" id="print_div">
        <!-- Header -->
        <table class="table-custom">
            <tr>
                <td style="width:60%;">
                    <img src="{{  public_path('assets/img/pdf_logo.png')}}" style="width:210px; height:auto;">
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
        </table>
        <!-- User Info -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h5>Souvik Mandal</h5>
                <p><strong>Mobile:</strong> 9064956744</p>
                <p><strong>Email:</strong> souvik@gmail.com</p>
            </div>
            <div class="col-md-4 text-right">
                <h3>INVOICE #102</h3>
            </div>
        </div>
        <div class="scrollable-container">
            <!-- Product Table -->
            <table class="table table-bordered" id="invoiceTable">
                <thead>
                    <tr class="text-light">
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="invoiceBody">
                    @foreach ($rows as $index => $row)
                    <tr>
                        <td>
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
                            <input type="text" class="form-control amount" wire:model="rows.{{ $index }}.unit_price"
                                wire:keyup="updatePrice({{ $index }})" placeholder="Enter Amount">
                            @error('rows.'.$index.'.unit_price')
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
                        <td>
                            <input type="text" class="form-control amount" value="0" readonly
                                wire:model="rows.{{ $index }}.total">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row"
                                wire:click="removeRow({{$index}})"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex mt-3 align-items-start">
                <button class="btn btn-success btn-sm" wire:click="addRow"><i class="fas fa-plus"></i> Add Row</button>
                <div class="ms-auto text-right me-4" style="min-width: 300px;">
                    <h5 class="text-total">
                        <strong>Total Amount:</strong>
                        <span id="totalAmount">{{number_format($this->totalAmount,2)}}</span>
                    </h5>
                    <h6 class="mt-2">
                        <strong>Total (in words):</strong>
                        <span id="totalAmount">{{$this->totalInWords}}</span>
                    </h6>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-4">
            <div class="col-md-8">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                <p class="text-muted">Thanks for shopping with us!</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-primary print-btn" wire:click="printInvoice">Print</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('triggerPrint', () => {
        window.print();
    });
</script>