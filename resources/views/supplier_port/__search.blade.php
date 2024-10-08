<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Supplier Port : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="supplierPortNameFilter" placeholder="Supplier Port Name">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="avgDaysFilter" placeholder="Avg days">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-control select2" id="countryFilter" name="countryFilter[]" multiple >
                <option value="">--Select Country--</option>
                @foreach($countries as $key => $country)
                <option value="{{ $key }}">{{ $country }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
