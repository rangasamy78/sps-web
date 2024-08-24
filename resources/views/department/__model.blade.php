<div class="modal fade" id="departmentModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="departmentForm" name="departmentForm" class="form-horizontal">
                    <input type="hidden" name="department_id" id="department_id">
                    <div class="form-group">
                        <label for="name" class="form-label pb-1">Department Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="department_name" name="department_name"
                                placeholder="Enter Department Name" value="">
                        </div>
                        <span class="text-danger error-text department_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Department</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showDepartmentmodal" tabindex="-1" aria-labelledby="show-department-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-department-modal-label">Show Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showDepartmentForm" name="showDepartmentForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="form-label pb-1">Department Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="department_name" name="department_name"
                                placeholder="Enter Department Name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
