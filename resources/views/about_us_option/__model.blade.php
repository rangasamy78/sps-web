<div class="modal fade" id="aboutUsOptionModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="aboutUsOptionForm"  class="form-horizontal">
                    <input type="hidden" name="how_did_you_hear_option_id" id="how_did_you_hear_option_id">
                    <div class="form-group">
                    <label for="name" class=" control-label pb-1">How did you hear Option<sup style="color:red"><strong>*</strong></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="how_did_you_hear_option" name="how_did_you_hear_option" placeholder="Enter How did you hear Option" value="">
                        </div>
                        <span class="text-danger error-text how_did_you_hear_option_error"></span>
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


<div class="modal fade" id="showAboutUsOptionModal" tabindex="-1" aria-labelledby="showAboutUsOptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showAboutUsOptionModalLabel">Show How did you hear Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showAboutUsOptionForm" name="showAboutUsOptionForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class=" control-label">How did you hear Option</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" id="how_did_you_hear_option" name="how_did_you_hear_option" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>