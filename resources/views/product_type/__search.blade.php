<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Product Type : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="productTypeFilter" placeholder="Product Type">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-control select2" id="inventoryGLAccountFilter" name="inventoryGLAccountFilter[]" multiple>
                <option value="">--Select Inventory GL Account--</option>
                @foreach($inventories as $key => $inventory)
                    <option value="{{ $inventory['value'] }}">{{ $inventory['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select id="salesGLAccountFilter" class="form-select select2" name="salesGLAccountFilter[]" multiple>
                <option value="">--Select Sales GL Account--</option>
                @foreach($sales as $key => $sale)
                    <option value="{{ $sale['value'] }}">{{ $sale['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select id="cogsGLAccountFilter" class="form-select select2" name="cogsGLAccountFilter[]" multiple>
                <option value="">--Select Cogs GL Account--</option>
                @foreach($cogs as $key => $cog)
                    <option value="{{ $cog['value'] }}">{{ $cog['label'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
