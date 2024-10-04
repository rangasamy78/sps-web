@extends('layouts.admin')

@section('title', 'Tax Authority')
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Tax Authority</h4>
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Tax Authority</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label" for="name">Authority Name </label>
                                    {!! Form::text('authority_name', $tax_authority->authority_name, [
                                        'class' => 'form-control',
                                        'id' => 'authority_name',
                                        'placeholder' => 'Enter Authority Name',
                                    ]) !!}
                                    <span class="text-danger error-text authority_name_error"></span>
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="print_name">Print Name </label>
                                    {!! Form::text('print_name', $tax_authority->print_name, [
                                        'class' => 'form-control',
                                        'id' => 'print_name',
                                        'placeholder' => 'Enter Print Name',
                                    ]) !!}
                                    <span class="text-danger error-text print_name_error"></span>
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="code">Authority Code</label>
                                    {!! Form::text('authority_code', $tax_authority->authority_code, [
                                        'class' => 'form-control',
                                        'id' => 'authority_code',
                                        'placeholder' => 'Enter Authority Code',
                                    ]) !!}
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="contact-name">Contact Name</label>
                                    {!! Form::text('contact_name', $tax_authority->contact_name, [
                                        'class' => 'form-control',
                                        'id' => 'contact_name',
                                        'placeholder' => 'Enter Contact Name',
                                    ]) !!}
                                </div>
                            </div>
                        </div> <!-- card -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Contact Information:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="primary_phone">Primary Phone</label>
                                    {!! Form::text('primary_phone', $tax_authority->primary_phone, [
                                        'class' => 'form-control',
                                        'id' => 'primary_phone',
                                        'placeholder' => 'Enter Primary Phone',
                                    ]) !!}
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="secondary_phone">Secondary Phone</label>
                                    {!! Form::text('secondary_phone', $tax_authority->secondary_phone, [
                                        'class' => 'form-control',
                                        'id' => 'secondary_phone',
                                        'placeholder' => 'Enter Secondary Phone',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="mobile">Mobile</label>
                                    {!! Form::text('mobile', $tax_authority->mobile, ['class' => 'form-control', 'id' => 'mobile', 'placeholder' => 'Enter Mobile']) !!}
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="fax">Fax</label>
                                    {!! Form::text('fax', $tax_authority->fax, ['class' => 'form-control', 'id' => 'fax', 'placeholder' => 'Enter Fax']) !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <label class="form-label" for="email">Email Address</label>
                                    {!! Form::text('email', $tax_authority->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter Email']) !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <label class="form-label" for="website">Website</label>
                                    {!! Form::text('website', $tax_authority->website, [
                                        'class' => 'form-control',
                                        'id' => 'website',
                                        'placeholder' => 'Enter Website',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Address:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    {!! Form::text('address', $tax_authority->address, [
                                        'class' => 'form-control',
                                        'id' => 'address',
                                        'placeholder' => 'Enter Address',
                                    ]) !!}
                                </div>
                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label" for="suite">Suite / Unit#</label>
                                    {!! Form::text('suite', $tax_authority->suite, [
                                        'class' => 'form-control',
                                        'id' => 'suite',
                                        'placeholder' => 'Enter Suite / Unit',
                                    ]) !!}
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="city">City</label>
                                    {!! Form::text('city', $tax_authority->city, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'Enter City']) !!}
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="state">State</label>
                                    {!! Form::text('state', $tax_authority->state, ['class' => 'form-control', 'id' => 'state', 'placeholder' => 'Enter State']) !!}
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="zip">Zip</label>
                                    {!! Form::text('zip', $tax_authority->zip, ['class' => 'form-control', 'id' => 'zip', 'placeholder' => 'Enter Zip']) !!}
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="country">Country</label>
                                    {!! Form::select('country_id', $countries, $tax_authority->country_id, [
                                        'class' => 'form-control select2',
                                        'id' => 'country_id',
                                        'placeholder' => '--Select Country--',
                                        'data-allow-clear' => 'true',
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Accounting Information:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label" for="tax_number">Tax Number</label>
                                    {!! Form::text('tax_number', $tax_authority->tax_number, [
                                        'class' => 'form-control',
                                        'id' => 'tax_number',
                                        'placeholder' => 'Enter Tax Number',
                                    ]) !!}
                                </div>
                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label" for="check_memo">Memo On Check</label>
                                    {!! Form::text('check_memo', $tax_authority->check_memo, [
                                        'class' => 'form-control',
                                        'id' => 'check_memo',
                                        'placeholder' => 'Enter Memo On Check',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    {!! Form::label('internal_notes', 'Internal Notes:', ['class' => 'form-label']) !!}
                                    {!! Form::textarea('internal_notes', $tax_authority->internal_notes, [
                                        'class' => 'form-control',
                                        'id' => 'internal_notes',
                                        'placeholder' => 'Enter Internal Notes',
                                        'rows' => 4,
                                        'cols' => 50,
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection
