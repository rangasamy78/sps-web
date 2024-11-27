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
                        {{-- @csrf --}}
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
                            {{-- <input type="button" class="btn btn-primary" id="go_btn" name="go_btn" value="Go"> --}}
                            <button type="submit" class="btn btn-primary">Go</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Cards Row -->
            <div class="col-12">
                <div class="col-md-12 offset mt-2 mb-5">
                    {{-- <div class="row" style="flex-wrap: nowrap;"> --}}

                    <div class="row">
                        @foreach ($probabilityToClose as $probability_to_close_value)
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="row">
                                        <div class="card-header">
                                            Probability To Close - <span class="text-warning text-sm font-weight-bolder">
                                                {{ $probability_to_close_value->probability_to_close }} %</span>
                                            {{ $probability_to_close_value->probability_close_count }}
                                        </div>
                                        <div class="card-body">
                                            @if ($probability_to_close_value->Probability->isEmpty())
                                            @else
                                                <ul class="list-group">
                                                    @foreach ($probability_to_close_value->Probability as $item)
                                                        <li class="list-group-item">
                                                            <strong>{{ $item->opportunity_code }}</strong><br>
                                                            {{ $item->opportunity_code }}
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
