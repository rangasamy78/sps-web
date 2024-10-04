@extends('layouts.admin')

@section('title', 'Edit Tax Code')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Edit Tax Code</span></h4>
            <div class="app-ecommerce">
                {!! Form::model($tax_code, [
                    'id' => 'taxCodeForm',
                    'name' => 'taxCodeForm',
                    'method' => 'PUT',
                    'class' => 'form-horizontal',
                ]) !!}
                @include('tax_code.partials.__tax_code_form')
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('tax_code_id', $tax_code->id, ['class' => 'form-control', 'id' => 'tax_code_id']) !!}
                        {!! Form::button('Update', ['class' => 'btn btn-primary', 'id' => 'savedata']) !!}
                        <a href="{{ route('tax_codes.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('tax_code.__scripts')
@endsection
