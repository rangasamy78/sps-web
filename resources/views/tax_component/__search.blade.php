<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Tax Authority : </b></label>
        <div class="col-12 col-sm-6 col-lg-4">
            {!! Form::text('component_name', null, ['class' => 'form-control', 'id' => 'componentNameFilter', 'placeholder' => 'Tax Component']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
            {!! Form::select('authority_id', $tax_authorities, null, ['class' => 'form-control select2', 'id' => 'authorityFilter', 'placeholder' => '--Select Authority--', 'data-allow-clear' => 'true']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
            {!! Form::select('sales_tax_id', $sales_taxes, null, ['class' => 'form-control select2', 'id' => 'salesTaxIDFilter', 'placeholder' => '--Select Sales Tax--', 'data-allow-clear' => 'true']) !!}
        </div>
    </div>
</div>&nbsp;
