
<div class="card">
    <div class="row g-3 mb-3 p-3">
    <label><b>Search Product : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="productNameFilter" id="productNameFilter" placeholder="Search Name / Alt.Name/ SKU / Legacy SKU">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productTypeFilter" id="productTypeFilter" data-allow-clear="true">
            <option value="">--Select Type / Form--</option>
            @foreach($product_type as $type)
                <option value="{{ $type->id }}">{{ $type->product_type }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productCategoryFilter" id="productCategoryFilter" data-allow-clear="true">
            <option value="">--Select Category / Nature--</option>
            @foreach($product_category as $category)
                <option value="{{ $category->id }}">{{ $category->product_category_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productSubCategoryFilter" id="productSubCategoryFilter" data-allow-clear="true">
            <option value="">--Select Sub Category--</option>
        </select>
    </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productGroupFilter" id="productGroupFilter" data-allow-clear="true">
            <option value="">--Select Group--</option>
            @foreach($product_group as $group)
                <option value="{{ $group->id }}">{{ $group->product_group_name }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productThicknessFilter" id="productThicknessFilter" data-allow-clear="true">
            <option value="">--Select Thickness--</option>
            @foreach($product_thickness as $thickness)
                <option value="{{ $thickness->id }}">{{ $thickness->product_thickness_name }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productOriginFilter" id="productOriginFilter" data-allow-clear="true">
            <option value="">--Select Origin--</option>
            @foreach($country as $cntry)
                <option value="{{ $cntry->id }}">{{ $cntry->country_name }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="priceRangeFilter" id="priceRangeFilter" data-allow-clear="true">
            <option value="">--Select Price Range--</option>
                @foreach($product_price_range as $price)
                <option value="{{ $price->id }}">{{ $price->product_price_range }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
