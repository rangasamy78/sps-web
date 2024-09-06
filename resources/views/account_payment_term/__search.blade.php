<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label ><b>Search Payment Terms : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="codeFilter" id="codeFilter" placeholder="Search Code">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input" name="labelFilter" id="labelFilter" placeholder="Search Label">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select select2" name="termFilter[]" id="termFilter" multiple >
                <option value="">--Select Payment Type--</option>
                @foreach ($account_types as $key => $account_type)
                <option value="{{ $account_type['value'] }}">{{ $account_type['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input" name="netDueFilter" id="netDueFilter" placeholder="Search Net Due Day">
        </div>
    </div>
</div>&nbsp;
