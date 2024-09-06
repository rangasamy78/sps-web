<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Select Type Sub Category : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-control select2" id="selectTypeCategoryNameFilter" name="selectTypeCategoryNameFilter[]" data-allow-clear="true" multiple>
                <option value="">--Select Country--</option>
                @foreach($select_type_categories as $key => $select_type_category)
                <option value="{{ $key }}">{{ $select_type_category }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="selectTypeSubCategoryNameFilter" placeholder="Select Type Sub Category Name">
        </div>
    </div>
</div>&nbsp;
