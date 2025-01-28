<div class="modal fade" id="showQuoteHeaderForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quoteHeaderForm" class="form-horizontal">
                    <input type="hidden" name="quote_header_name_id" id="quote_header_name_id">
                    <div class="form-group">
                        <label for="name" class="form-label pb-1">Quote Header <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></sup>
                        </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="quote_header_name" name="quote_header_name" placeholder="Enter Quote Header" value="">
                        </div>
                        <span class="text-danger error-text quote_header_name_error"></span>
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
<div class="modal fade" id="showQuoteHeaderModal" tabindex="-1" aria-labelledby="showQuoteHeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showQuoteHeaderModalLabel">Show Quote Header Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showQuoteHeaderForm" name="showQuoteHeaderForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label pb-2">Quote Header Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="quote_header_name" name="quote_header_name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>