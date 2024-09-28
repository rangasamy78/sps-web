@extends('layouts.admin')

@section('title', 'Add Tax Authority')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Add Tax Authority</span></h4>
            <div class="app-ecommerce">
                {!! Form::open([
                    'id' => 'taxAuthorityForm',
                    'name' => 'taxAuthorityForm',
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                ]) !!}
                @csrf
                @include('tax_authority.partials.__tax_authority_form')
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('tax_authority_id', '') !!}
                        {!! Form::button('Save Tax Authority', ['class' => 'btn btn-primary', 'id' => 'savedata', 'value' => 'create']) !!}
                        {!! Form::reset('Reset', ['class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('tax_authority.__scripts')
@endsection
