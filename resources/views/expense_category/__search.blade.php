<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="expenseCategoryFilter" placeholder="Search Expense Category Name">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select" name="expenseAccountFilter" id="expenseAccountFilter">
                <option value="">Select Expense Account</option>
                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                    <option value="{{ $linkedAccount['value'] }}" >{{ $linkedAccount['label'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
