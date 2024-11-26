@extends('layouts.admin')

@section('title', 'My Event')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Event / </span>Create</h4>
            <form id="eventForm" name="eventForm" class="form-horizontal">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">My Event information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="form-label" for="Event Type">Event Type<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="event_type_id"
                                            id="event_type_id" data-allow-clear="true">
                                            <option value=""></option>
                                            @foreach ($event_types as $key => $type)
                                                <option value="{{ $key }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text event_type_id_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="user">Assigned To<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select class="form-select select2" name="assigned_to_id"
                                            id="assigned_to_id" data-allow-clear="true">
                                            <option value=""></option>
                                            @foreach ($users as $key => $type)
                                                <option value="{{ $key }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text assigned_to_id_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="schedule_date">Scheduled Date</label>
                                        <input type="date" class="form-control" id="schedule_date"
                                            name="schedule_date" aria-label="schedule_date" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="schedule_time">Scheduled Date</label>
                                        <input type="time" class="form-control" id="schedule_time"
                                            name="schedule_time" aria-label="schedule_time" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Name">Title<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control" id="event_title" placeholder="Title"
                                            name="event_title" aria-label="Title" />
                                        <span class="text-danger error-text event_title_error"></span>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="follower_id">Followers(CC)</label>
                                        <select class="form-select select2" name="follower_id[]"
                                            id="follower_id" data-allow-clear="true" multiple>
                                            @foreach ($users as $key => $type)
                                                <option value="{{ $key }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="party">Customer/Supplier/Vendor/Employee:</label>
                                        <select class="form-select select2" name="party_name"
                                            id="party_name" data-allow-clear="true">
                                            <option value=""></option>
                                            @foreach ($parties as $key => $type)
                                                <option value="{{ $type['party_name_id'] }}:{{ $type['type'] }}">{{ $type['name']}}  ({{ $type['type']}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="form-label" for="Description">Description</label>
                                        <textarea class="form-control" id="description" name="description" placeholder="Description" style="resize: none;"></textarea>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="product_id">Products:</label>
                                        <select class="form-select select2" name="product_id[]"
                                            id="product_id" data-allow-clear="true" multiple>
                                            @foreach ($products as $key => $type)
                                                <option value="{{ $type['id'] }}">{{ $type['product_name'] }} ( {{ $type['product_type'] }} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label" for="Price">Price</label>
                                        <input type="number" class="form-control" id="price" placeholder="Price"
                                            name="price" aria-label="Price" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Event</button>
                        <button type="reset" class="btn btn-label-secondary">Discard</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @include('my_event.__script')
@endsection
