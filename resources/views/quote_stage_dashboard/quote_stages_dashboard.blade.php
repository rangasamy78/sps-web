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

            <!-- Cards Row -->
            <div class="">
                <div class="col-12">
                    <div class="col-md-12 offset mt-5 mb-5">
                        {{-- <div class="row" style="flex-wrap: nowrap;"> --}}
                        <div class="row">
                            <!-- Default Stage Card -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header" style="background-color: skyblue;">
                                        <h4>Unstaged</h4>
                                        {{ $defaultStages->count(); }}
                                    </div>
                                    <div class="card-body  mt-3">
                                        @if ($defaultStages->isEmpty())
                                            <p>No items in this Quote.</p>
                                        @else
                                            <ul class="list-group" style="background-color: aliceblue;">
                                                @foreach ($defaultStages as $item)
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
                            <!-- Opportunity Stages Cards -->
                            @foreach ($opportunityStages as $opportunity_stage_value)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header" style="background-color: skyblue;">
                                            <h4>{{ $opportunity_stage_value->opportunity_stage }}</h4>
                                            {{ $opportunity_stage_value->opportunity_count }}
                                        </div>
                                        <div class="card-body mt-3">
                                            @if ($opportunity_stage_value->opportunity->isEmpty())
                                                <p>No items in this Quote.</p>
                                            @else
                                                <ul class="list-group" style="background-color: aliceblue;">
                                                    @foreach ($opportunity_stage_value->opportunity as $item)
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
