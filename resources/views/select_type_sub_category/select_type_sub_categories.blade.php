@extends('layouts.admin')

@section('title', 'Select Type Sub Category')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Select Type Sub Category</h4>
    <!-- Ajax Sourced Server-side -->
    @include('select_type_sub_category.__search')
    <div class="card">
        <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="table border-top data-table table-striped" id="datatable" style="width: 100%">
                    <thead class="table-header-bold">
                        <tr>
                            <th>S.No</th>
                            <th>Select Type Category Name</th>
                            <th>Select Type Sub Category Name</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('select_type_sub_category.__model')
</div>
<!-- / Content -->
@endsection
@section('scripts')
@include('select_type_sub_category.__scripts')
@endsection
