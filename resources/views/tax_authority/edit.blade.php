@extends('layouts.admin')

@section('title', 'Edit Tax Authority')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Edit Tax Authority</span></h4>
            <div class="app-ecommerce">
                {!! Form::model($tax_authority, [
                    'id' => 'taxAuthorityForm',
                    'name' => 'taxAuthorityForm',
                    'method' => 'PUT',
                    'class' => 'form-horizontal',
                ]) !!}
                @csrf
                @include('tax_authority.partials.__tax_authority_form')
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('tax_authority_id', $tax_authority->id, ['class' => 'form-control', 'id' => 'tax_authority_id']) !!}
                        {!! Form::button('Update', ['class' => 'btn btn-primary', 'id' => 'savedata']) !!}
                        <a href="{{ route('tax_authorities.index') }}" class="btn btn-secondary">Cancel</a>
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
