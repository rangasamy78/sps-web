<div class="modal fade" id="customerContactTitleModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customerContactTitleForm"  class="form-horizontal">
                    <input type="hidden" name="customer_title_id" id="customer_title_id">
                    <div class="form-group">
                    <label for="name" class=" control-label pb-1">Customer Title <sup style="color:red"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="customer_title" name="customer_title" placeholder="Enter Customer Title" value="">
                        </div>
                        <span class="text-danger error-text customer_title_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" name="savedata" value="Save">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showCustomerContactTitleModal" tabindex="-1" aria-labelledby="showCustomerContactTitleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showCustomerContactTitleModalLabel">Show Customer Contact Title </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showCustomerContactTitleForm" name="showCustomerContactTitleForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class=" control-label">Customer Contact Title</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" id="customer_title" name="customer_title" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>