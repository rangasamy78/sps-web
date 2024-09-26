<div class="row supplierFilter">
    <div class="col-lg-4 col-sm-6 mb-2">
        <label class="mb-2 fw-bold">Inventory Suppliers: </label>
        <select id="supplierSearch" name="supplierSearch" multiple class="select2 form-select">
            <option value="1">Supplier Name</option>
            <option value="2">Currency</option>
            <option value="3">Supplier Type</option>
            <option value="4">Address</option>
            <option value="5">Phone</option>
            <option value="6">Location</option>
            <option value="7">Payment Terms</option>
            <option value="8">Language</option>
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="supplierNameDiv" style="display:none;">
        <label class="mb-2 fw-bold">Supplier Name:</label>
        <input type=" text" class="form-control dt-input dt-full-name" id="supplierNameFilter" data-allow-clear="true" placeholder="Search Supplier Name">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="currencyDiv" style="display:none;">
        <label class="mb-2 fw-bold">Currency:</label>
        <select id="currencyFilter" name="currencyFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select currency--</option>
            @foreach($currencies as $currency)
            <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="supplierTypeDiv" style="display:none;">
        <label class="mb-2 fw-bold">Supplier Type:</label>
        <select id="supplierTypeFilter" name="supplierTypeFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select supplier type--</option>
            @foreach($supplierTypes as $supplierType)
            <option value="{{ $supplierType->id }}">{{ $supplierType->supplier_type_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="addressDiv" style="display:none;">
        <label class="mb-2 fw-bold">Address:</label>
        <input type="text" class="form-control dt-input dt-full-name" id="addressFilter" data-allow-clear="true" placeholder="Search Address">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="phoneDiv" style="display:none;">
        <label class="mb-2 fw-bold">Phone:</label>
        <input type="text" class="form-control dt-input dt-full-name" id="phoneFilter" data-allow-clear="true" placeholder="Search Phone Number">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="locationDiv" style="display:none;">
        <label class="mb-2 fw-bold">Location:</label>
        <select id="locationFilter" name="locationFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select location--</option>
            @foreach($companies as $company)
            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="paymentTermDiv" style="display:none;">
        <label class="mb-2 fw-bold">Payment Term:</label>
        <select id="paymentTermFilter" name="paymentTermFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select payment term--</option>
            @foreach($paymentTerms as $paymentTerm)
            <option value="{{ $paymentTerm->id }}">{{ $paymentTerm->payment_label }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="languageDiv" style="display:none;">
        <label class="mb-2 fw-bold">Language:</label>
        <select id="languageFilter" name="languageFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select language--</option>
            @foreach($languages as $language)
            <option value="{{ $language->id }}">{{ $language->language_name }}</option>
            @endforeach
        </select>
    </div>
</div>