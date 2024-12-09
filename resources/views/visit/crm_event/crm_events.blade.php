<div class="tab-pane" id="CRMEvent" role="tabpanel">
    <h5 class="">CRM</h5>
    <div class="row">
        <input type="text" class="form-control" hidden name="opportunity_id" id="opportunity_id" value="{{ $opportunity->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="visitCrmEvent">
        <thead class="table-header-bold">
            <tr>
                <th>&nbsp;</th>
                <th>Entered By</th>
                <th>Assigned To</th>
                <th>Title / Description</th>
                <th>Type</th>
                <th>Sch.Date / Time</th>
                <th>Products / Price</th>
            </tr>
        </thead>
        <tbody id="opportunityFileUploadRow">
        </tbody>
    </table>
</div>

<!-- offcanvas for add crm event -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="crmEvent" aria-labelledby="crmEventLabel">
    <div class="offcanvas-header">
        <h5 id="crmEventLabel" class="offcanvas-title">New Event</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form id="addCrmEventForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <input type="hidden" class="form-control" id="entered_by_id" name="entered_by_id" value="{{Auth::id()}}">
                    <input type="hidden" class="form-control" id="party_name" name="party_name" value="{{$customer->customer_name}}">
                    <input type="hidden" class="form-control" id="type" name="type" value="visit">
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value="{{$visit->id}}">
                    <label class="form-label">Entered On: <span id="currentDateTime" class="fw-bold text-dark"></span></label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Type</label>
                    <select class="form-select" id="event_type_id" name="event_type_id">
                        <option value="">--select--</option>
                        @foreach($data['eventTypes'] as $id => $event_type_name)
                        <option value="{{ $id }}">{{ $event_type_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text event_type_id_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-7">
                    <label class="form-label">Schedule Date</label>
                    <input type="date" class="form-control" id="schedule_date" name="schedule_date">
                    <span class="text-danger error-text schedule_date_error"></span>
                </div>
                <div class="col-5">
                    <label class="form-label">Time</label>
                    <input type="time" class="form-control" id="schedule_time" name="schedule_time">
                    <span class="text-danger error-text schedule_time_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Assigned To</label>
                    <select class="form-select" id="assigned_to_id" name="assigned_to_id">
                        <option value="">--select--</option>
                        @foreach($data['users'] as $id => $first_name)
                        <option value="{{ $id }}" {{ Auth::id() == $id ? 'selected' : '' }}>{{ $first_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text assigned_to_id_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Followers (CC)</label>
                    <select class="form-select" id="follower_id" name="follower_id">
                        <option value="">--select--</option>
                        @foreach($data['users'] as $id => $first_name)
                        <option value="{{ $id }}">{{ $first_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text follower_id_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" id="event_title" name="event_title">
                    <span class="text-danger error-text event_title_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Product</label>
                    <div class="input-group">
                        <input type="hidden" class="form-control bg-label-secondary" readonly id="product_id" name="product_id" />
                        <input type="text" class="form-control bg-label-secondary cursor-pointer" readonly id="product_name" name="product_name" data-bs-toggle="modal" data-bs-target="#searchProduct" />
                        <span class="input-group-text bg-primary cursor-pointer" data-bs-toggle="modal" data-bs-target="#searchProduct">
                            <i class="fi fi-rr-search text-white"></i>
                        </span>
                        <span class="text-danger error-text product_id_error"></span>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price">
                    <span class="text-danger error-text price_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Description</label>
                    <textarea type="text" rows="4" class="form-control" id="description" name="description"></textarea>
                    <span class="text-danger error-text description_error"></span>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-primary" id="saveEvent" name="saveEvent">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- end offcanvas of crm event -->
<!-- pop up product -->
<div class="modal fade" id="searchProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">List of Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row accountFilter">
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Name:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" name="productNameFilter" id="productNameFilter" data-allow-clear="true" placeholder="Search by Product Name">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Code:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="codeFilter" name="codeFilter" data-allow-clear="true" placeholder="Search by Product Code">
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="productListTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>Code</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- end pop up product -->