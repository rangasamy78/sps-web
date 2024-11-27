<div class="tab-pane fade show" id="event" role="tabpanel">
    <h5>Add Event</h5>
    <table class="datatables-basic table table-striped" id="prePurchaseRequestEvent">
        <thead class="table-header-bold">
            <tr>
                <th>Sl.No</th>
                <td>Entered By</td>
                <td>Assigned To</td>
                <td>Title / Description</td>
                <td>Type</td>
                <td>Sch. Date / Time</td>
                <td>Products / Price</td>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="prePurchaseRequestEventModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="prePurchaseRequestEventModelForm" name="prePurchaseRequestEventModelForm"
                    class="form-horizontal">
                    <input type="hidden" name="pre_purchase_request_event_id" id="pre_purchase_request_event_id">
                    <input type="hidden" name="pre_purchase_request_id" id="pre_purchase_request_id" value="{{ $pre_purchase_request->id }}">
                    <input type="hidden" name="type" id="type" value="pre_purchase_request">
                    <input type="hidden" name="entered_by_id" id="entered_by_id" value="{{ auth()->user()->id }}">
                    <div class="form-group">
                        <p><b>Entered On</b> : {{ \Carbon\Carbon::now()->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="event_type_id" class="form-label">Event Type <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <select id="event_type_id" class="form-select select2" name="event_type_id" data-allow-clear="true">
                                <option value="">--Select Event Type--</option>
                                @foreach ($data['eventTypes'] as $key => $event_type)
                                    <option value="{{ $key }}">{{ $event_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text event_type_id_error"></span>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="schedule_date" class="form-label">Schedule Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" id="schedule_date" name="schedule_date" placeholder="Enter Schedule Date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="schedule_time" class="form-label">Schedule Time</label>
                                <div class="col-sm-12">
                                    <input type="time" class="form-control" id="schedule_time" name="schedule_time" placeholder="Enter Schedule Time" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="assigned_to_id" class="form-label">Assigned User <sup
                                style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <select id="assigned_to_id" class="form-select select2" name="assigned_to_id" data-allow-clear="true">
                                <option value="">--Select Event Type--</option>
                                @foreach ($data['users'] as $key => $user)
                                    <option value="{{ $key }}">{{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text assigned_to_id_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="follower_id" class="form-label">Followed User</label>
                        <div class="col-sm-12">
                            <select id="follower_id" class="form-select select2" name="follower_id[]"
                                data-allow-clear="true" multiple="true">
                                <option value="">--Select Event Type--</option>
                                @foreach ($data['users'] as $key => $user)
                                    <option value="{{ $key }}">{{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="event_title" class="form-label">Title <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="event_title" name="event_title"
                                placeholder="Enter Title" value="">
                        </div>
                        <span class="text-danger error-text event_title_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="product_id" class="form-label">Product Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <select id="product_id" class="form-select select2" name="product_id" data-allow-clear="true">
                                <option value="">--Select Product--</option>
                                @foreach ($data['products'] as $key => $product)
                                    <option value="{{ $key }}">{{ $product }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text product_id_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="price" class="form-label">Price <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="">
                        </div>
                        <span class="text-danger error-text price_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="description" class="form-label">Description</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveEventData" value="create">Save Event</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
