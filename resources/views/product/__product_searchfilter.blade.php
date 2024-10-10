
<div class="card">
    <div class="row g-3 mb-3 p-3">
    <label><b>Search Product : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productNameFilter" id="productNameFilter" data-allow-clear="true">
            <option value="">--Select Name / Alt.Name / SKU--</option>
            @foreach($product as $prd)
                <option value="{{ $prd->id }}">{{ $prd->product_name }}</option>
                @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productKindFilter" id="productKindFilter" data-allow-clear="true">
            <option value="">--Select Kind--</option>
            @foreach($product_kind as $kind)
                <option value="{{ $kind->id }}">{{ $kind->product_kind_name  }}</option>
                @endforeach
        </select>
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
            <option value="">--Select Category--</option>
            @foreach($product_category as $category)
                <option value="{{ $category->id }}">{{ $category->product_category_name }}</option>
            @endforeach
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
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productUomFilter" id="productUomFilter" data-allow-clear="true">
            <option value="">--Select Basic UOM--</option>
            @foreach($unit_measure as $uom)
                <option value="{{ $uom->id }}">{{ $uom->unit_measure_name }}</option>
                @endforeach
        </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
        <select class="form-select select2" name="productColorFilter" id="productColorFilter" data-allow-clear="true">
            <option value="">--Select Base Color--</option>
            @foreach($product_color as $color)
                <option value="{{ $color->id }}">{{ $color->product_color }}</option>
                @endforeach
        </select>
        </div>
    </div>
</div>&nbsp;
