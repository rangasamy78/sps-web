@extends('layouts.admin')

@section('title', 'Company Page')

@section('styles')
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> Company</h4>
        @include('company.__search')
        <div class="card">
            <div class="card-datatable table-responsive" style="overflow:hidden;width:96%;margin:auto;">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <table class="table table-bordered data-table  table-striped" id="datatable" style="width: 100%">
                        <thead class="table-header-bold">
                            <tr>
                                <th>S.No</th>
                                <th>Company Name</th>
                                <th>Logo</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>State</th>
                                <th>City</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('company.__model')
    </div>
@endsection

@section('scripts')
@include('company.__scripts')
@endsection
