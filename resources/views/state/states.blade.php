@extends('layouts.admin')

@section('title', 'State Page')

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> State</h4>
    @include('state.__search')
    <div class="card">
        <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="table data-table table-striped border-top" id="datatable" style="width: 100%">
                    <thead class="table-header-bold">
                        <tr>
                            <th>S.No</th>
                            <th>State Name</th>
                            <th>State Code</th>
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
    @include('state.__model')
    @include('state.__import')
</div>
<!-- / Content -->
@endsection

@section('scripts')
@include('state.__scripts')
@endsection