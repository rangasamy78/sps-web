<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Payment Method : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="methodNameFilter" placeholder="Search Payment Method Name">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select select2" name="linkedAccountFilter[]" multiple id="linkedAccountFilter" data-allow-clear="true">
                <option value="">--Select Account--</option>
                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                <option value="{{ $linkedAccount['value'] }}">{{ $linkedAccount['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select select2" name="accountTypeFilter[]"  multiple  id="accountTypeFilter" data-allow-clear="true">
                <option value="">--Select Account Type--</option>
                @foreach($data['accountTypes'] as $key => $accountType)
                <option value="{{ $accountType['value'] }}">{{ $accountType['label'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;