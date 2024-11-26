@extends('layouts.admin')
@section('title', 'lists')

@section('styles')

@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Event Calendar</h4>
            <div class="card row ">
                <div class="col-12">
                    <div class="col-md-12 mt-5 mb-5">
                        <div id="calendar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('event_calendar.__scripts')
@endsection
