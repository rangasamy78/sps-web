<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Tax Component</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6 mb-3">
                        <label class="form-label" for="name">Sort Order </label>
                        {!! Form::text('sort_order', isset($tax_component) ? null : $nextSortOrder, [
                            'class' => 'form-control',
                            'id' => 'sort_order',
                            'placeholder' => 'Enter Sort Oder',
                            'disabled' => isset($tax_component),
                        ]) !!}
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="component_name">Component Name <sup
                                style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::text('component_name', null, [
                            'class' => 'form-control',
                            'id' => 'component_name',
                            'placeholder' => 'Enter Component Name',
                        ]) !!}
                        <span class="text-danger error-text component_name_error"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" for="component_tax_id">Component Tax ID <sup
                                style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::text('component_tax_id', null, [
                            'class' => 'form-control',
                            'id' => 'component_tax_id',
                            'placeholder' => 'Enter Component Tax ID',
                        ]) !!}
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="code">Authority</label>
                        {!! Form::select('authority_id', $tax_authorities, null, ['class' => 'form-control select2', 'id' => 'authority_id', 'placeholder' => '--Select Authority--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" for="contact-name">Sales Tax Account <sup
                            style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                            {!! Form::select('sales_tax_id', $tax_authorities, null, ['class' => 'form-control select2', 'id' => 'sales_tax_id', 'placeholder' => '--Select Authority--', 'data-allow-clear' => 'true']) !!}
                        <span class="text-danger error-text sales_tax_id_error"></span>
                    </div>
                </div>
            </div> <!-- card -->
        </div>
    </div>
</div>
