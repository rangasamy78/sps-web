<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select" name="viewInFilter" id="viewInFilter">
                <option value="">Select View In</option>
                @foreach($viewInOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="fileTypeFilter" id="fileTypeFilter" placeholder="Search File Type">
        </div>        
    </div>
</div>&nbsp;
