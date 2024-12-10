@extends('layouts.admin')
@section('title', 'Quote Stages Dashboard')

@section('styles')

@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Page Header -->
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Home / </span>Quote Stages Dashboard
            </h4>
            <div class="card col-md-12 p-3 pb-1">
                <div style="position:relative">
                    <form action="{{ route('quote_stages_dashboard.index') }}" method="GET">
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
            <div class="">
                <div class="col-12">
                    <div class="col-md-12 offset mt-3 mb-5">
                        {{-- <div class="row" style="flex-wrap: nowrap;"> --}}
                        <div class="row">
                            <!-- Default Stage Card -->
                            <div class="col-md-4">
                                <div class="card" style="border: double;">
                                    <div class="card-header p-3" style="background-color: skyblue;">
                                        <h4>Unstaged</h4>
                                         @if ($defaultStages->count() == 1)
                                            {{ $defaultStages->count() }} Quote
                                        @elseif ($defaultStages->count() > 1)
                                            {{ $defaultStages->count() }} Quotes
                                        @else
                                            No Quotes
                                        @endif
                                    </div>
                                    <div class="card-body  mt-3">
                                        @if ($defaultStages->isEmpty())
                                            <p>No items in this Quote.</p>
                                        @else
                                            <ul class="list-group" style="background-color: aliceblue;">
                                                @foreach ($defaultStages as $item)
                                                    <li class="list-group-item">
                                                        <strong>{{ $item->opportunity_code ?? ''}}</strong><br>
                                                        {{ $item->customer_name ?? '' }}<span style="float: right;">{{ !empty($item->probability_to_close) ? $item->probability_to_close.' %' : ''; }}</span><br>
                                                        {{ $item->ship_to_job_name ?? '' }}<br>
                                                        {{ $item->full_name ?? '' }}<span style="float: right;">{{ $item->created_at->diffForHumans() }}</span><br>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Opportunity Stages Cards -->
                            @foreach ($opportunityStages as $opportunity_stage_value)
                            <div class="col-md-4">
                                <div class="card" style="border: double;">
                                    <div class="card-header p-3" style="background-color: skyblue;">
                                        <h4>{{ $opportunity_stage_value->opportunity_stage }}</h4>
                                        @if ($opportunity_stage_value->opportunities->count() == 1)
                                        {{ $opportunity_stage_value->opportunities->count() }} Quote
                                    @elseif ($opportunity_stage_value->opportunities->count() > 1)
                                        {{ $opportunity_stage_value->opportunities->count() }} Quotes
                                     @else
                                        No Quotes
                                    @endif
                                    </div>
                                    <div class="card-body mt-3">
                                        @if ($opportunity_stage_value->opportunities->isEmpty())
                                            <p>No items in this Quote.</p>
                                        @else
                                            <ul class="list-group" style="background-color: aliceblue;">
                                                @foreach ($opportunity_stage_value->opportunities as $item)
                                                    <li class="list-group-item">
                                                        <strong>{{ $item->opportunity_code ?? ''}}</strong><br>
                                                        {{ $item->customer_name ?? '' }}<span style="float: right;">{{ !empty($item->probability_to_close) ? $item->probability_to_close.' %': ''; }}</span><br>
                                                        <i class='bx bx-dollar' ></i>{{ $item->ship_to_job_name ?? ''}}<br>
                                                        <i class='bx bx-user' ></i>{{ $item->full_name ?? '' }}<span style="float: right;">{{ $item->created_at->diffForHumans() ?? '' }}</span><br>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
    @include('quote_stage_dashboard.__model')
@section('scripts')
    @include('quote_stage_dashboard.__scripts')
@endsection
