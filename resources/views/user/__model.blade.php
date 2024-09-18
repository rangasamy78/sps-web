<div class="modal fade" id="userModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="Name" class="pb-1 form-label">Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name" value="">
                        </div>
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Code <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control"  id="code" name="code"
                                placeholder="Enter Code" value="">
                        </div>
                        <span class="text-danger error-text code_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Email<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter Email" value="">
                        </div>
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Password <span id="password_mandatory"><sup style="color:red; font-size: 0.9rem;"><strong>*</strong></span></label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter Password" value="">
                        </div>
                        <span class="text-danger error-text password_error"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Confirm Password<span id="c_password_mandatory"><sup style="color:red; font-size: 0.9rem;"><strong>*</strong></span></label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                placeholder="Enter Confirm Password" value="">
                        </div>
                        <span class="text-danger error-text password_confirmation_error"></span>
                    </div>

                    <div class="form-group mt-3">
                    <label for="Department" class="form-label">Department <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select class="form-select select2 " name="department_id" id="department_id" data-allow-clear="true">
                            <option value="">Select Department</option>
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->department_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text department_id_error"></span>
                    </div>
                    <div class="form-group mt-3">
                    <label for="Department" class="form-label">Designation <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select class="form-select" name="designation_id" id="designation_id" data-allow-clear="true">
                            <option value="">Select Designation</option>
                            </select>
                        </div>
                        <span class="text-danger error-text designation_id_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save User</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="show-user-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-user-modal-label">Show User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showUserForm" name="showUserForm" class="form-horizontal">
                <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="Name" class="pb-1 form-label">Name </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="name" name="name"
                                placeholder="" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="code" name="code"
                                placeholder="" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control"  disabled id="email" name="email"
                                placeholder="" value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                    <label for="Department" class="form-label">Department </label>
                        <div class="col-sm-12">
                            <select class="form-select " name="department_id" disabled id="department_id">
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->department_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                    <label for="Department" class="form-label">Designation </label>
                        <div class="col-sm-12">
                            <select class="form-select" name="designation_id" disabled  id="designation_id">
                                @foreach($designations as $desig)
                                <option value="{{$desig->id}}">{{$desig->designation_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
