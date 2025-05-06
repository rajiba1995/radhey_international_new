<div class="container">
    <section class="admin__title">
        <h5>Withdrawn</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="">Profit & Loss</a></li>
            <li>Withdrawn</li>
            <li class="back-button">
                <a class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0" href="" role="button">
                    < Back
                </a>
            </li>
        </ul>
    </section>

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="submitWithdraw">
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <label>Voucher No</label>
                        <input type="text" class="form-control form-control-sm" wire:model="voucher_no" disabled>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label>Withdrawable Amount</label>
                        <input type="text" class="form-control form-control-sm" wire:model="withdrawable_amount" disabled>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label>Reserved Amount</label>
                        <input type="text" class="form-control form-control-sm" wire:model="reserved_amount" disabled>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label>Profit in Hand</label>
                        <input type="text" class="form-control form-control-sm" wire:model="profit_in_hand" disabled>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label>Net Profit</label>
                        <input type="text" class="form-control form-control-sm" wire:model="net_profit" disabled>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label>Net Profit Margin</label>
                        <input type="text" class="form-control form-control-sm" wire:model="net_profit_margin" disabled>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label>Withdrawal Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" wire:model="withdrawal_amount">
                        @error('withdrawal_amount') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label>Entry Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" wire:model="entry_date">
                        @error('entry_date') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label>Mode Of Payment <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm" wire:model="payment_mode" wire:change="changePaymentMode($event.target.value)">
                            <option value="" hidden>Select One</option>
                            <option value="cheque">Cheque</option>
                            <option value="neft">NEFT</option>
                            <option value="cash">Cash</option>
                        </select>
                        @error('payment_mode') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                @if($payment_mode !== 'cash')
                <div class="row" id="noncash_sec">
                    <div class="col-sm-6 mb-3">
                        <label>Cheque No / UTR No</label>
                        <input type="text" class="form-control form-control-sm" wire:model="chq_utr_no">
                        @error('chq_utr_no') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label>Bank Name</label>
                        <input type="text" class="form-control form-control-sm" wire:model="bank_name" placeholder="Search Bank">
                        @error('bank_name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <label>Narration</label>
                    <textarea class="form-control form-control-sm" rows="3" wire:model="narration"></textarea>
                </div>

                <div class="form-group text-end">
                    <button type="submit" class="btn btn-sm btn-success select-md">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="loader-container" wire:loading>
        <div class="loader"></div>
    </div>
</div>
