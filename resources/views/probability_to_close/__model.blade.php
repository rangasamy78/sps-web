<div class="modal fade" id="probabilityToCloseModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="probabilityToCloseForm" name="probabilityToCloseForm" class="form-horizontal">
                    <input type="hidden" name="probability_to_close_id" id="probability_to_close_id">
                    <div class="form-group">
                        <label for="Probability To Close" class="pb-1 form-label">Probability To Close <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="probability_to_close" name="probability_to_close"
                                placeholder="Enter Probability To Close" value="">
                        </div>
                        <span class="text-danger error-text probability_to_close_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Probability To Close</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showProbabilityToCloseModal" tabindex="-1" aria-labelledby="show-probability_to_close-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-probability_to_close-modal-label">Show Probability To Close</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProbabilityToCloseForm" name="showProbabilityToCloseForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Probability To Close" class="col-sm-4 form-label">Probability To Close</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="probability_to_close" name="probability_to_close" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
