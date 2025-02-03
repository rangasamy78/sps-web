<div class="row saleOrderFilter">
    <div class="col-lg-4 col-sm-6 mb-2">
        <label class="mb-2 fw-bold">Search Sale Order: </label>
        <select id="saleOrderSearch" name="saleOrderSearch" multiple class="select2 form-select">
            <option value="1">SO #</option>
            <option value="2">Date</option>
            <option value="3">Cust. P.O #</option>
            <option value="4">Job Name</option>
            <option value="5">Delivery Type</option>
            <option value="6">Req.Ship Dt</option>
            <option value="7">ETA Date</option>
            <option value="8">Bill To Customer</option>
            <option value="9">Location</option>
            <option value="10">Sales Person</option>
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="salesOrderNumberDiv" style="display:none;">
        <label class="mb-2 fw-bold">SO #:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="salesOrderNumberFilter" id="salesOrderNumberFilter" data-allow-clear="true" placeholder="Search SO #">
    </div>
    
    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="salesOrderDateDiv" style="display:none;">
        <label class="mb-2 fw-bold">Date:</label>
        <input type="Date" class="form-control dt-input dt-full-name" id="salesOrderDateFilter" data-allow-clear="true" placeholder="Search Date">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="customerPoNumberDiv" style="display:none;">
        <label class="mb-2 fw-bold">Cust. P.O #:</label>
        <input type="text" class="form-control dt-input dt-full-name" id="customerPoNumberFilter" data-allow-clear="true" placeholder="Search Cust. P.O #">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="jobNameDiv" style="display:none;">
        <label class="mb-2 fw-bold">Job Name:</label>
        <input type="text" class="form-control dt-input dt-full-name" id="jobNameFilter" data-allow-clear="true" placeholder="Search Job Name">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="shipToTypeDiv" style="display:none;">
        <label class="mb-2 fw-bold">Delivery Type:</label>
        <select id="shipToTypeFilter" name="shipToTypeFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select Delivery Type--</option>
            <option value="Delivery">Delivery</option>
            <option value="Pick Up">Pick Up</option>
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="requestedShipDateDiv" style="display:none;">
        <label class="mb-2 fw-bold">Req.Ship Dt:</label>
        <input type="date" class="form-control dt-input dt-full-name" id="requestedShipDateFilter" data-allow-clear="true" placeholder="Search Req.Ship Dt">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="estDeliveryDateDiv" style="display:none;">
        <label class="mb-2 fw-bold">ETA Date:</label>
        <input type="date" class="form-control dt-input dt-full-name" id="estDeliveryDateFilter" data-allow-clear="true" placeholder="Search ETA Date">
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="billingCustomerDiv" style="display:none;">
        <label class="mb-2 fw-bold">Bill To Customer:</label>
        <select id="billingCustomerFilter" name="billingCustomerFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select Bill To Customer--</option>
            @foreach($data['customers'] as $customer)
            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="locationIdDiv" style="display:none;">
        <label class="mb-2 fw-bold">Location:</label>
        <select id="locationIdFilter" name="locationIdFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select Location--</option>
            @foreach ($data['companies'] as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-sm-6 filter-input mb-2" id="salesPersonDiv" style="display:none;">
        <label class="mb-2 fw-bold">Sales Person:</label>
        <select id="salesPersonFilter" name="salesPersonFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select Sales Person--</option>
            @foreach ($data['users'] as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

</div>
