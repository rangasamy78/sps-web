<div class="modal fade" id="projectTypeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="projectTypeForm" name="projectTypeForm" class="form-horizontal">
                    <input type="hidden" name="project_type_id" id="project_type_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 form-label">Project Type Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="project_type_name" name="project_type_name"
                                placeholder="Enter Project Type Name" value="">
                        </div>
                        <span class="text-danger error-text project_type_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Project Type</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showProjectTypeModal" tabindex="-1" aria-labelledby="show-project-type-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-project-type-modal-label">Show Project Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showProjectTypeForm" name="showProjectTypeForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 form-label">Project Type Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="project_type_name" name="project_type_name"
                                placeholder="Enter Project Type Name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
