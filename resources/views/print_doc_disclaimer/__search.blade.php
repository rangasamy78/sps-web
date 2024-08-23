<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="titleFilter" id="titleFilter" placeholder="Search Title">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select" name="select_type_category_id_filter" id="select_type_category_id_filter">
                <option value="">--Select Type Category--</option>
                @foreach($select_type_categories as $key => $select_type_category)
                    <option value="{{ $key }}">{{ $select_type_category }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select select_type_sub_category_id_filter" name="select_type_sub_category_id_filter" id="select_type_sub_category_id_filter">
                <option value="">--Select Type Sub Category--</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="policyFilter" id="policyFilter" placeholder="Search Policy">
        </div>
    </div>
</div>&nbsp;
