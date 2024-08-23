<div class="modal fade" id="endUseSegmentModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="endUseSegmentForm"  class="form-horizontal">
                    <input type="hidden" name="end_use_segment_id" id="end_use_segment_id">
                    <div class="form-group">
                    <label for="name" class="form-label pb-1">End Use Segment <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="end_use_segment" name="end_use_segment" placeholder="Enter End Use Segment" value="">
                        </div>
                        <span class="text-danger error-text end_use_segment_error"></span>
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


<div class="modal fade" id="showEndUseSegmentModal" tabindex="-1" aria-labelledby="showEndUseSegmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showEndUseSegmentModalLabel">Show End Use Segement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="endUseSegmentShowForm" name="endUseSegmentShowForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label">End Use Segment</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" id="end_use_segment" name="end_use_segment" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>