<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-control select2" id="departmentFilter" name="departmentFilter" data-allow-clear="true">
                <option value="">--Select Department--</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="designationFilter" placeholder="Search Designation">
        </div>
    </div>
</div>&nbsp;