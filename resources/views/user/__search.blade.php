<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search User : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="nameFilter" placeholder="Name">
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            <input type="text" class="form-control dt-input dt-full-name" id="codeFilter" placeholder="Code">
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            <input type="text" class="form-control dt-input dt-full-name" id="emailFilter" placeholder="Email">
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
        <select class="form-control select2" id="departmentFilter" name="departmentFilter[]" multiple >
                <option value="">--Select Department--</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-control select2" id="designationFilter" name="designationFilter[]" multiple >
                <option value="">--Select Designation--</option>
                @foreach($designations as $desg)
                <option value="{{ $desg->id }}">{{ $desg->designation_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
