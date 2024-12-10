@extends('layouts.admin')
@section('title', 'Follow Up')

@section('styles')

@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Page Header -->
            <h4>
                <span class="text-muted fw-light">Home / </span>Follow Up
            </h4>
            <div class="card col-md-12 p-3 pb-1">
                <div style="position:relative">
                    <form action="{{ route('follow_ups.index') }}" method="GET">
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
            <!-- Cards Row -->
            <div class="col-12">
                <div class="col-md-12 offset mt-3 mb-5">
                    {{-- <div class="row" style="flex-wrap: nowrap;"> --}}

                    <div class="row">
                        @foreach ($probabilityToClose as $probability_to_close_value)
                            <div class="col-md-3">
                                <div class="card" style="border: double;">
                                    <div class="row">
                                        <div class="card-header text-dark" style="background-color: skyblue;margin-left: 4%;width: 92%;">
                                            Probability To Close - <span class="text-sm font-weight-bolder">
                                                {{ $probability_to_close_value->probability_to_close }} %</span>
                                            {{ $probability_to_close_value->probability_close_count }}
                                        </div>
                                        <div class="card-body mt-2">
                                            @if ($probability_to_close_value->Probability->isEmpty())
                                            @else
                                                <ul class="list-group"  style="background-color:aliceblue;">
                                                    @foreach ($probability_to_close_value->Probability as $item)
                                                        <li class="list-group-item">
                                                            Job Name:<strong><span style="float: right;">{{ $item->opportunity_code }}</span><br />&emsp;
                                                            {{ $item->ship_to_job_name }}<br />&emsp;<i class='bx bx-phone' ></i>{{ $item->ship_to_phone }}<br />&emsp;<i class='bx bx-envelope' ></i>{{ $item->ship_to_email }}</strong><br>
                                                            Bill To:<br />&emsp;
                                                            <strong>{{ $item->customer_name }}<br />&emsp;<i class="bx bx-phone"></i>{{ $item->phone }}<br />&emsp;<i class='bx bx-envelope' ></i>{{ $item->accounting_email }}</strong><br>
                                                            Days: <strong>{{ \Carbon\Carbon::now()->diffInDays($item->opportunity_date) }} - {{ \Carbon\Carbon::parse($item->opportunity_date)->format('M d, Y') }}</strong><br>
                                                            <i class="bx bx-user"></i><strong>{{ $item->full_name }}<span style="float: right;"><i class='bx bx-current-location' ></i>{{$item->company_name}}</span></strong>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('follow_up.__model')
@section('scripts')
    @include('follow_up.__scripts')
@endsection
