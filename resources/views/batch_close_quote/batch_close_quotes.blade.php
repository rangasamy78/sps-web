@extends('layouts.admin')
@section('title', 'Quotes')
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Quotes</h4>
            <div class="row mb-3">
                <div class="col">
                    <div class="card col-md-12 p-3 mb-3">
                        <div style="position:relative">
                            <form action="{{ route('batch_close_quotes.index') }}" method="GET">
                                <div class="d-flex gap-2">
                                    <label for="start_date">Start Date:</label>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value={{ $startDate }}>
                                    </div>
                                    <label for="end_date">End Date:</label>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value={{ $endDate }}>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Go</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card p-4 pt-0">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('batch_close_quotes.updatestatus') }}" method="POST"
                                    id="batchCloseForm">
                                    <table class="datatables-basic table tables-basic border-top table-striped"
                                        id="datatable">
                                        <thead class="table-header-bold">
                                            <tr class="odd gradeX">
                                                <th>Sl.No</th>
                                                <th>Quote #</th>
                                                <th>Date</th>
                                                <th>Delivery Type:</th>
                                                <th><input type="checkbox" class="form-check-input"
                                                        style="transform:scale(1.2)" id="select-all"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('batch_close_quote.__scripts')
@endsection
