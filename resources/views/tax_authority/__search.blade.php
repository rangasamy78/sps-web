<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Tax Authority : </b></label>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('authority_name', null, ['class' => 'form-control', 'id' => 'authorityNameFilter', 'placeholder' => 'Name']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'codeFilter', 'placeholder' => 'Code']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('city', null, ['class' => 'form-control', 'id' => 'cityFilter', 'placeholder' => 'City']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('state', null, ['class' => 'form-control', 'id' => 'stateFilter', 'placeholder' => 'State']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('zip', null, ['class' => 'form-control', 'id' => 'zipFilter', 'placeholder' => 'Zip']) !!}
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            {!! Form::text('tax_number', null, ['class' => 'form-control', 'id' => 'taxNumberFilter', 'placeholder' => 'Zip']) !!}
        </div>
    </div>
</div>&nbsp;
