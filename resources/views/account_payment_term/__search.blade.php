<div class="card">
    <div class="row g-3 mb-3 p-3">
        <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label"><b style="margin-left: 8px;">Code : </b></label>
            <input type="text" class="form-control dt-input dt-full-name" id="codeFilter" placeholder="Search Code..">
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label"><b style="margin-left: 8px;">Label : </b></label>
            <input type="text" class="form-control dt-input" id="labelFilter" placeholder="Search Label..">
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label"><b style="margin-left: 8px;">Types : </b></label>
            <select class="form-select" name="termFilter" id="termFilter">
                <option value="">Select Payment Type</option>
                @foreach ($account_types as $key => $account_type)
                    <option value="{{ $key }}">{{ $account_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label"><b style="margin-left: 8px;">Net Due : </b></label>
            <input type="text" class="form-control dt-input" id="netDueFilter" placeholder="Search Net Due Day..">
        </div>
        <div class="col-12 col-sm-6 col-lg-4 d-flex justify-content-end align-items-end">
            <button class="btn btn-primary" type="button" id="createPaymentTerm" name="createPaymentTerm">
                <i class="bx bx-plus me-sm-1"></i> New Standard Payment Term
            </button>
        </div>
    </div>
</div>&nbsp;
