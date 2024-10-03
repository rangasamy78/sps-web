<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Tax Code</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-3 mb-3">
                        <label class="form-label" for="sort_order">Sort Order </label>
                        {!! Form::text('sort_order', isset($tax_code) ? null : $nextSortOrder, [
                            'class' => 'form-control',
                            'id' => 'sort_order',
                            'placeholder' => 'Enter Sort Oder',
                        ]) !!}
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="tax_code">Tax Code <sup
                                style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::text('tax_code', null, [
                            'class' => 'form-control',
                            'id' => 'tax_code',
                            'placeholder' => 'Enter Tax Code',
                        ]) !!}
                        <span class="text-danger error-text tax_code_error"></span>
                    </div>
                    <div class="col-5 mb-3">
                        <label class="form-label" for="tax_code_label">Tax Code Label <sup
                                style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        {!! Form::text('tax_code_label', null, [
                            'class' => 'form-control',
                            'id' => 'tax_code_label',
                            'placeholder' => 'Enter Tax Code Label',
                        ]) !!}
                        <span class="text-danger error-text tax_code_label_error"></span>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="code">Note</label>
                        {!! Form::textarea('notes', null, ['class' => 'form-control', 'id' => 'notes', 'placeholder' => 'Enter Notes','rows' => 4, 'cols' => 50]) !!}
                    </div>
                    <div class="col-3">
                        <div style="display: flex;margin-top: 40px;">
                            {!! Form::checkbox('is_sale_use', 1, null, ['id' => 'is_sale_use','disabled' => 'disabled', 'checked' => true]) !!}
                            <label class="form-label" for="code" style="margin-left: 10px;margin-top: 10px;">Where is this Tax Code Used?</label>
                        </div>
                    </div>
                    <div class="col-3">
                        {!! Form::label('effective_date', 'Effective Date:', ['class' => 'form-label']) !!}
                        {!! Form::date('effective_date', null, ['class' => 'form-control', 'id' => 'effective_date']) !!}
                        <span class="text-danger error-text effective_date_error"></span>
                    </div>
                </div>
            </div> <!-- card -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dynamic_table">
                    <tr>
                        <th>Sort</th>
                        <th>Tax Component</th>
                        <th>GL Account</th>
                        <th>Rate</th>
                        <th><button type="button" name="add" id="add" class="btn btn-success">Add More</button></th>
                    </tr>
                    @if(isset($tax_code_components))
                        @php $j = 1; $i = 0; @endphp
                        @foreach($tax_code_components as $key => $tax_code_component)
                            <tr id="row_{{ $i }}">
                                <td>{!! Form::text('tax_id[]', $j * 10, ['class' => 'form-control', 'id' => "tax_id_$i", 'placeholder' => 'Enter Tax ID']) !!}</td>
                                <td>{!! Form::select('tax_component_id[]', $data['tax_components'], $tax_code_component['tax_component_id'], ['class' => 'form-control tax_component_id', 'data-id'=> "$i", 'id' => "tax_component_id_$i", 'placeholder' => '--Select Component--', 'data-allow-clear' => 'true']) !!}</td>
                                <td><span id="tax_gl_account_{{$i}}">{{ $tax_code_component['gl_account_name'] }}</span>
                                    {!! Form::hidden('gl_account_name[]', $tax_code_component['gl_account_name'], ['class' => 'form-control', 'id' => "gl_account_name_$i", 'placeholder' => 'Enter Tax Gl Account']) !!}
                                </td>
                                <td>{!! Form::text('tax_rate[]', $tax_code_component['rate'], ['class' => 'form-control tax_rate', 'id' => "tax_rate_$i", 'placeholder' => 'Enter Rate']) !!}</td>
                                <td>@if($i >= 1) {!! Form::button('X', ['type' => 'button', 'name' => 'remove', 'id' => $i, 'class' => 'btn btn-danger btn_remove']) !!} @endif</td>
                            </tr>
                        @php $j++; $i++; @endphp
                        @endforeach
                    @else
                    <tr id="row_0">
                        <td>{!! Form::text('tax_id[]', null, ['class' => 'form-control', 'id' => 'tax_id_0', 'placeholder' => 'Enter Tax ID', 'disabled' => 'disabled']) !!}</td>
                        <td>{!! Form::select('tax_component_id[]', $data['tax_components'], null, ['class' => 'form-control tax_component_id', 'data-id'=> '0', 'id' => 'tax_component_id', 'placeholder' => '--Select Component--', 'data-allow-clear' => 'true']) !!}</td>
                        <td><span id="tax_gl_account_0"></span>
                            {!! Form::text('gl_account_name[]', null, ['class' => 'form-control', 'id' => "gl_account_name_0", 'placeholder' => 'Enter Tax Gl Account']) !!}
                        </td>
                        <td>{!! Form::text('tax_rate[]', null, ['class' => 'form-control tax_rate', 'id' => 'tax_rate_0', 'placeholder' => 'Enter Rate', 'disabled' => 'disabled']) !!}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <p>If tax component not available in the dropdown, add new component here:</p>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label" for="component_name">New Tax Component </label>
                        {!! Form::text('component_name', $tax_component->component_name ?? '', ['class' => 'form-control','id' => 'component_name','placeholder' => 'Enter New Tax Component',]) !!}
                        <span class="text-danger error-text component_name_error"></span>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="sales_tax_id">Tax Component Sales Acc.</label>
                        {!! Form::select('sales_tax_id', $data['sales_taxes'], $tax_component->sales_tax_id ?? '', ['class' => 'form-control sales_tax_id', 'data-id'=> '0', 'id' => 'sales_tax_id', 'placeholder' => '--Select Tax Code--', 'data-allow-clear' => 'true']) !!}
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="new_tax_component_rate">&nbsp;</label>
                        {!! Form::text('new_tax_component_rate', $tax_component->new_tax_component_rate ?? '', ['class' => 'form-control tax_rate','id' => 'new_tax_component_rate', 'disabled' => 'disabled', 'style' =>"margin-left: 85px;"]) !!}
                    </div>
                    <div class="col-7">&nbsp;</div>
                    <div class="col-2 mb-3">
                        <span id="tax_sum" style="margin-left: 100px; font-weight: 800; font-size: 17px;">
                            {{ isset($tax_component->tax_code_total) ? $tax_component->tax_code_total . '%' : '' }}
                        </span>
                        {!! Form::text('tax_code_total', old('tax_code_total', $tax_component->tax_code_total ?? ''), ['class' => 'form-control', 'id' => 'tax_code_total', 'style' => 'margin-left: 85px;']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
