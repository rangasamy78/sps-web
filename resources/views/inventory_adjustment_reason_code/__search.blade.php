<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-control select2" id="adjustmentTypeFilter" name="adjustmentTypeFilter" data-allow-clear="true">
                <option value="">--Select Adjustment Type--</option>
                @foreach($adjustment_types as $key => $adjustment_type)
                <option value="{{ $key }}">{{ $adjustment_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            <input type="text" class="form-control dt-input dt-full-name" id="reasonFilter" placeholder="Reason">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select id="incomeExpenseAccountFilter" class="form-select select2" name="incomeExpenseAccountFilter" data-allow-clear="true">
                <option value="">--Select Income Expense Account--</option>
                <option value="50010 - Inventory Adjustment">50010 - Inventory Adjustment</option>
            </select>
        </div>
    </div>
</div>&nbsp;