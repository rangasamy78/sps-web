<div class="row accountFilter">
    <div class="col-lg-4 col-sm-6 mb-2">
        <label class="mb-2 fw-bold">Search Account: </label>
        <select id="accountSearch" name="accountSearch" multiple class="select2 form-select">
            <option value="1">Account Number</option>
            <option value="2">Account Name</option>
            <option value="3">Alternate Number</option>
            <option value="4">Alternate Name</option>
            <option value="5">Account Type</option>
            <option value="6">Sub Account Type</option>
            <option value="7">Special Account Type</option>
            <option value="8">Sub Account of</option>
            <option value="9">Status</option>
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="accountNumberDiv" style="display:none;">
        <label class="mb-2 fw-bold">Account Number:</label>
        <input type=" text" class="form-control dt-input dt-full-name" name="accountNumberFilter" id="accountNumberFilter" data-allow-clear="true" placeholder="Search Account Number">
    </div>
    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="accountNameDiv" style="display:none;">
        <label class="mb-2 fw-bold">Account Name:</label>
        <input type=" text" class="form-control dt-input dt-full-name" id="accountNameFilter" data-allow-clear="true" placeholder="Search Account Name">
    </div>
    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="alternateNumberDiv" style="display:none;">
        <label class="mb-2 fw-bold">Alternate Number:</label>
        <input type=" text" class="form-control dt-input dt-full-name" id="alternateNumberFilter" data-allow-clear="true" placeholder="Search Alternate Number">
    </div>
    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="alternateNameDiv" style="display:none;">
        <label class="mb-2 fw-bold">Alternate Name:</label>
        <input type=" text" class="form-control dt-input dt-full-name" id="alternateNameFilter" data-allow-clear="true" placeholder="Search Alternate Name">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="accountTypeDiv" style="display:none;">
        <label class="mb-2 fw-bold">Account Type:</label>
        <select id="accountTypeFilter" name="accountTypeFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select account type--</option>
            @foreach($accountTypes as $accountType)
            <option value="{{ $accountType->id }}">{{ $accountType->account_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="subAccountTypeDiv" style="display:none;">
        <label class="mb-2 fw-bold">Sub Account Type:</label>
        <select id="subAccountTypeFilter" name="subAccountTypeFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select sub account type--</option>
            @foreach($accountSubTypes as $accountSubType)
            <option value="{{ $accountSubType->id }}">{{ $accountSubType->sub_type_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="specialAccountTypeDiv" style="display:none;">
        <label class="mb-2 fw-bold">Special Account Type:</label>
        <select id="specialAccountTypeFilter" name="specialAccountTypeFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select special account type--</option>
            @foreach($specialAccountTypes as $specialAccountType)
            <option value="{{ $specialAccountType->id }}">{{ $specialAccountType->special_account_type_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="subAccountOfDiv" style="display:none;">
        <label class="mb-2 fw-bold">Sub Account of:</label>
        <select id="subAccountOfFilter" name="subAccountOfFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select sub account of--</option>
            @foreach($accounts as $account)
            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="statusDiv" style="display:none;">
        <label class="mb-2 fw-bold">Status:</label>
        <select id="statusFilter" name="statusFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select status--</option>
            <option value="1">Active</option>
            <option value="2">InActive</option>
        </select>
    </div>
</div>