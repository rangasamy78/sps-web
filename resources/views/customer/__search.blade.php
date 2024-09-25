<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Company : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            {!! Form::text('customer_name', null, ['class' => 'form-control dt-input dt-full-name', 'id' => 'customerNameFilter', 'placeholder' => 'Name / DBA / Code / Contact Name']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            {!! Form::select('customer_type', $customerTypes, null, ['class' => 'form-control dt-input dt-full-name select2', 'id' => 'customerTypeFilter', 'placeholder' => 'Select Customer Type', 'data-allow-clear' => 'true']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('address', null, ['class' => 'form-control dt-input dt-full-name', 'id' => 'addressFilter', 'placeholder' => 'Address Name']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('phone', null, ['class' => 'form-control dt-input dt-full-name', 'id' => 'customerPhoneFilter', 'placeholder' => 'Phone / Fax / Email']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::select('location_name', $companies, null, ['class' => 'form-control dt-input dt-full-name', 'id' => 'locationNameFilter', 'placeholder' => 'Select Location Name', 'data-allow-clear' => 'true']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            {!! Form::select('status', [1 => 'Active', 2 => 'Inactive'], null, ['class' => 'form-control select2', 'id' => 'statusFilter', 'placeholder' => 'Select Status', 'data-allow-clear' => 'true']) !!}
        </div>
    </div>
</div>&nbsp;
