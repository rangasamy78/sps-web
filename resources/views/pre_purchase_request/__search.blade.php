<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Company : </b></label>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('transaction_number', null, ['class' => 'form-control', 'id' => 'transactionNumberFilter', 'placeholder' => 'Enter Transaction Number']) !!}
        </div>

        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::date('pre_purchase_date', null, ['class' => 'form-control', 'id' => 'prePurchaseDateFilter', 'title' => 'Enter Pre Purchase Date']) !!}
        </div>

        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control dt-input dt-full-name select2', 'id' => 'supplierFilter', 'placeholder' => 'Select Supplier', 'data-allow-clear' => 'true']) !!}
        </div>

        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::date('required_ship_date', null, ['class' => 'form-control', 'id' => 'requiredShipDateFilter', 'title' => 'Enter Required Ship Date']) !!}
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            {!! Form::select('requested_by_id', $users, null, ['class' => 'form-control dt-input dt-full-name select2', 'id' => 'requestedByFilter', 'placeholder' => 'Select Request By', 'data-allow-clear' => 'true']) !!}
        </div>
    </div>
</div>&nbsp;
