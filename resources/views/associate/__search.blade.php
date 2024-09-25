<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Associate : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="associateNameFilter" id="associateNameFilter" placeholder="Search Name / ID / Code / Contact Name">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="addressFilter" id="addressFilter" placeholder="Search Address">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="phoneFilter" id="phoneFilter" placeholder="Search Phone / Fax / Email">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select select2" name="associateTypeFilter[]" id="associateTypeFilter" multiple >
                <option value="">--Select Associate Type--</option>
                @foreach($associate_type as $type)
                    <option value="{{ $type->id }}">{{ $type->customer_type_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
