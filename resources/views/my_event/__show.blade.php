@extends('layouts.admin')
@section('title', 'Show Event')
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span><span> Show Events</span></h4>
            <div class="app-ecommerce">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                            <div class="row">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4><span class="card-title mb-0 fw-bold">{{ $my_event->event_title ?? '' }}</span>@if($my_event->mark_as_complete == 1)
                                    <span class="text-danger fw-bold">(InComplete)</span>
                                    @endif</h4>
                                <div class="d-flex align-items-center"> <!-- Container for buttons -->
                                    <a href="{{ route('my_events.edit', $my_event->id) }}"
                                        data-id="{{ $my_event->id }}"
                                        class="btn btn-primary rounded-circle editbtn"
                                        data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Edit Event"
                                        style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bx-edit" style="font-size: 18px;"></i>
                                    </a>
                                    <div class='dropdown ms-2'> <!-- Add margin to separate buttons -->
                                        <button type='button' class='btn p-0 dropdown-toggle hide-arrow btn-primary rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class='bx bx-plus-circle icon-color' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Action"></i> <!-- Icon inside the button -->
                                        </button>
                                        <div class='dropdown-menu'>
                                            <a class='dropdown-item showbtn text-warning' href='{{ route('my_events.index') }}'>
                                                <i class='bx bx-list-ul'></i> List All Service
                                            </a>
                                            <a class='dropdown-item change_status text-success completebtn' data-id='{{ $my_event->id }}'>
                                                <i class='bx bx-check-circle'></i> @if($my_event->mark_as_complete == 0)Mark As Incomplete
                                                @else
                                                Mark As Complete
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="row mb-2">
                                <div class="col">
                                    <label><span class="text-dark fw-bold">Type: </span>
                                        {{ $my_event->event_type->event_type_name ?? '' }}</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label><span class="text-dark fw-bold">Schedule Date/Time: </span>
                                        {{ $my_event->schedule_date && $my_event->schedule_time ? \Carbon\Carbon::parse($my_event->schedule_date.' '.$my_event->schedule_time)->format('M d, Y h:i A') : '' }}</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label><span class="text-dark fw-bold">Assigned To: </span>
                                        {{ $my_event->users->first_name.' '.$my_event->users->last_name ?? '' }}</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label><span class="text-dark fw-bold">Followers(CC): </span>
                                        @foreach ($followers as $follower)
                                            {{ $follower['first_name'] }} {{ $follower['last_name'] }}<br />
                                        @endforeach
                                    </label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label><span class="text-dark fw-bold">Transaction #: </span>
                                        {{ $my_event->party_name ?? '' }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">

                            <div class="row mb-2">
                                <div class="col">
                                    <label><span class="text-dark fw-bold">Products: </span>
                                        @foreach ($products as $product)
                                            {{ $product['product_name'] }} <br />
                                        @endforeach {{ $my_event->price ? '$'.$my_event->price.' / SF' : ''; }}</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <span class="text-dark fw-bold">Description: </span>
                                    <textarea class="form-control" style="background: lightgoldenrodyellow;" readonly >{{ $my_event->description ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });

</script>
    @include('my_event.__script')
@endsection
