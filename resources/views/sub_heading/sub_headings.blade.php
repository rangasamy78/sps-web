@extends('layouts.admin')
@section('title', 'Sub Heading')
@section('styles')
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home /</span> Sub Headings</h4>

        <!-- Ajax Sourced Server-side -->
        <div class="card">
            <div class="card-datatable table-responsive"  style="overflow:hidden;width:96%;margin:auto;">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">&nbsp;</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <div class="btn-group">
                                </div>
                                <button class="btn btn-secondary create-new btn-primary" type="button"
                                    id="createSubHeading"><span><i class="bx bx-plus me-1"></i> <span
                                            class="d-none d-lg-inline-block">Create New Sub Heading</span></span></button>
                            </div>
                        </div>
                    </div>
                    <table class="datatables-basic table tables-basic border-top table-striped" id="datatable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Sub Heading Name</th>
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
        @include('sub_heading.__model')
    </div>

    <!-- / Content -->
@endsection

@section('scripts')
    @include('sub_heading.__scripts')
@endsection
