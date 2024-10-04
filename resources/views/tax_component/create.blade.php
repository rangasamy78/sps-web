@extends('layouts.admin')

@section('title', 'Add Tax Component')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Add Tax Component</span></h4>
            <div class="app-ecommerce">
                {!! Form::open([
                    'id' => 'taxComponentForm',
                    'name' => 'taxComponentForm',
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                ]) !!}
                @include('tax_component.partials.__tax_component_form')
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('tax_component_id', '') !!}
                        {!! Form::button('Save Tax Component', ['class' => 'btn btn-primary', 'id' => 'savedata', 'value' => 'create']) !!}
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
    @include('tax_component.__scripts')
@endsection
