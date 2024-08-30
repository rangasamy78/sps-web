@extends('layouts.admin')

@section('title', 'Product Category')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Product Category</h4>
    @include('product_category.__search')
    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
               <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                    <thead class="table-header-bold">
                        <tr>
                            <th>S.No</th>
                            <th>Product Category Name</th>
                            <th>Product Subcategory Name</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
    <!--/ Responsive Datatable -->
    @include('product_category.__model')
</div>
<!-- / Content -->
@endsection

@section('scripts')
@include('product_category.__scripts')

@endsection
