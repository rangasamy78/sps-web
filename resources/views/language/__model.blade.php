<div class="modal fade" id="languageModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="languageForm" name="languageForm" class="form-horizontal">
                    <input type="hidden" name="language_id" id="language_id">
                    <div class="form-group">
                        <label for="language_name" class="form-label">Languages Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="language_name" name="language_name"
                                placeholder="Enter Languages Name" value="">
                        </div>
                        <span class="text-danger error-text language_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Languages</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showLanguagesmodal" tabindex="-1" aria-labelledby="show-language-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-language-modal-label">Show Languages</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showLanguagesForm" name="showLanguagesForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="language_name" class="form-label">Languages Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="language_name" name="language_name"
                                placeholder="" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
