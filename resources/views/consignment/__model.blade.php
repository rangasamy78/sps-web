<div class="modal fade" id="ConsignmentModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consignment Location Setup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="consignmentForm" class="form-horizontal">
                    <input type="hidden" name="consignment_location_id" id="consignment_location_id" value="{{$customer->id}}">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="name" class="form-label pb-1">Customer Name </label>
                        </div>
                        <div class="col-md-7">
                            <label class="fw-bold text-dark fs-6">{{$customer->customer_name}}</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            <label for="name" class="form-label pb-1">Consignment Location on</label>
                        </div>
                        <div class="col-lg-6 col-10">
                            <input type="date" class="form-control text-dark border-dark" id="consignment_date" name="consignment_date">
                            <input type="hidden" class="form-control text-dark border-dark" id="consignment_type" name="consignment_type" value="customer">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveconsignment" name="saveconsignment" value="Save">SetUp</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


