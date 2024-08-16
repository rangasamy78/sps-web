<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-2">
            <input type="text" class="form-control dt-input dt-full-name" id="accountCodeFilter" placeholder="Search Account Code">
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            <input type="text" class="form-control dt-input dt-full-name" id="accountNameFilter" placeholder="Search Account Name">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select" name="accountTypeFilter" id="accountTypeFilter">
                <option value="">Select Account Type</option>
                @foreach($accountTypes as $accountType)
                    <option value="{{$accountType->id}}">{{$accountType->account_type_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select" name="accountSubTypeFilter" id="accountSubTypeFilter">
                <option value="">Select Account Sub Type</option>
                @foreach($accountSubTypes as $accountSubType)
                    <option value="{{$accountSubType->id}}">{{$accountSubType->sub_type_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
