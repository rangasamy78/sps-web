<!-- Modal for designation -->
<div class="modal fade" id="designationModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="designationForm" class="form-horizontal">
                    <div class="table-responsive">
                        <table class="datatables-basic table tables-basic border-top table-striped" id="designationTable">
                            <thead>
                                <tr class="odd gradeX">
                                    <th>Sl.No</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row_0" class="default-row">
                                    <td class="slno">1</td>
                                    <td>
                                        <select class="form-select form-select-sm department" name="department_id_[]" id="department_id_0">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text department_error"></span>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm designation" name="designation_name_[]" id="designation_name_0">
                                        <span class="text-danger error-text designation_error"></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm rounded-pill btn-icon btn-success" id="addRowDesignation" name="addRowDesignation">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" id="last_row" name="last_row" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveDesignation" name="saveDesignation" value="Save">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- update -->
<div class="modal fade" id="designationUpdateModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelUpdateHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="designationUpdateForm" class="form-horizontal">
                    <input type="hidden" name="designation_id" id="designation_id">
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label">Department <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select class="form-select " name="department_id" id="department_id">
                                <option value="">--Select--</option>
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->department_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text department_id_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Designation <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="designation_name" id="designation_name">
                        </div>
                        <span class="text-danger error-text designation_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="updateDesignation" name="updateDesignation">Update Designation</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showDesignationModal" tabindex="-1" aria-labelledby="showDesignationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDesignationModalLabel">Show Designation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="designationShowForm" name="deginationShowForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Department</label>
                        <div class="col-sm-12">
                            <select class="form-select " disabled name="department_id" id="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->department_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Designation</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="designation_name" name="designation_name" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
