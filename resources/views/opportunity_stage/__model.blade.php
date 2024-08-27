<div class="modal fade" id="opportunityStageModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="opportunityStageForm" name="opportunityStageForm" class="form-horizontal">
                    <input type="hidden" name="opportunity_stage_id" id="opportunity_stage_id">
                    <div class="form-group">
                        <label for="Opportunity Stage" class="form-label">Opportunity Stage <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="opportunity_stage" name="opportunity_stage"
                                placeholder="Enter Opportunity Stage" value="">
                        </div>
                        <span class="text-danger error-text opportunity_stage_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Opportunity Stage</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showOpportunityStageModal" tabindex="-1" aria-labelledby="show-opportunity-stage-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-opportunity-stage-modal-label">Show Opportunity Stage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showOpportunityStageForm" name="showOpportunityStageForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Opportunity Stage" class="form-label">Opportunity Stage</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="opportunity_stage" name="opportunity_stage" disabled
                                value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
