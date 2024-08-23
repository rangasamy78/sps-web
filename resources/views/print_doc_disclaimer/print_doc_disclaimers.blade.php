@extends('layouts.admin')

@section('title', 'Policies And Print Forms')

@section('styles')

<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('public/assets/vendor/libs/quill/editor.css')}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Policies And Print Forms</h4>
    @include('print_doc_disclaimer.__search')
    <div class="card">
        <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="table table-bordered data-table  table-striped" id="datatable" style="width: 100%">
                    <thead>
                        <tr>
                            <th><b>S.No</b></th>
                            <th><b>Title</b></th>
                            <th><b>Select Type Category Name</b></th>
                            <th><b>Select Type Sub Category Name </b></th>
                            <th><b>Policy</b></th>
                            <th width="150px"><b>Action</b></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('print_doc_disclaimer.__model')
</div>
@endsection
@section('scripts')
<script src="{{asset('public/assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('public/assets/vendor/libs/quill/quill.js')}}"></script>

@include('print_doc_disclaimer.__scripts')
@endsection
