<div class="row g-3 mb-3 p-3">
    <div class="col-12 col-sm-6 col-lg-2">
        <input type="text" class="form-control dt-input dt-full-name" id="labelFilter" placeholder="Search Label">
    </div>
    <div class="col-12 col-sm-6 col-lg-2">
        <input type="text" class="form-control dt-input dt-full-name" id="lengthFilter" placeholder="Search Length">
    </div>
    <div class="col-12 col-sm-6 col-lg-2">
        <input type="text" class="form-control dt-input dt-full-name" id="widthFilter" placeholder="Search Width">
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <input type="text" class="form-control dt-input dt-full-name" id="heightFilter" placeholder="Search Height">
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <select id="binTypeIdFilter" class="form-select select2" name="bin_type_id" data-allow-clear="true">
            <option value="">--Select Event Type--</option>
            @foreach ($binTypes as $key => $bin_type)
                <option value="{{ $key }}">{{ $bin_type }}</option>
            @endforeach
        </select>
    </div>
</div>
