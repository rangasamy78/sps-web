
<div class="card">
    <div class="row g-3 mb-3 p-3">
    <label><b>Search Service : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="serviceNameFilter" id="serviceNameFilter" placeholder="Search Name / SKU ">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="serviceCategoryFilter" id="serviceCategoryFilter" data-allow-clear="true">
            <option value="">--Select Service Category--</option>
            @foreach($service_categories as $type)
                <option value="{{ $type->id }}">{{ $type->service_category }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="serviceTypeFilter" id="serviceTypeFilter" data-allow-clear="true">
            <option value="">--Select Service Type--</option>
            @foreach($service_types as $type)
                <option value="{{ $type->id }}">{{ $type->service_type }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="serviceGroupFilter" id="serviceGroupFilter" data-allow-clear="true">
            <option value="">--Select Group--</option>
            @foreach($product_groups as $group)
                <option value="{{ $group->id }}">{{ $group->product_group_name }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="servicePriceFilter" id="servicePriceFilter" placeholder="Search Price ">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select select2" name="serviceUomFilter" id="serviceUomFilter" data-allow-clear="true">
                <option value="">--Select Group--</option>
                @foreach($unit_measures as $type)
                    <option value="{{ $type->id }}">{{ $type->unit_measure_name }}</option>
                    @endforeach
            </select>
            </div>
    </div>
</div>&nbsp;
