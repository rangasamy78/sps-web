<div class="card">
    <div class="row g-3 mb-3 p-2">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <select id="unitMeasureEntityFilter" class="form-select select2" name="unitMeasureEntityFilter" data-allow-clear="true">
                <option value="">--Select Unit Measure Entity--</option>
                @foreach($unitMeasureOptions as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
       
        <div class="col-12 col-sm-6 col-lg-2">
            <input type="text" class="form-control dt-input dt-full-name" id="unitMeasureNameFilter" placeholder="Unit Measure Name">
        </div>
    </div>
</div>&nbsp;
