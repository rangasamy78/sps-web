<div class="row consignmetFilter">
    <div class="col-lg-4 col-sm-6 mt-2">
        <label class="mb-2 fw-bold">Filter Consignment: </label>
        <select id="consignmentSearch" name="consignmentSearch" multiple class="select2 form-select">
            <option value="1">Consignmet Location</option>
            <option value="2">Code</option>
            <option value="3">Contact Name</option>
            <option value="4">Parent Location</option>
            <option value="5">SetUp Date</option>
            <option value="6">Type</option>
            <option value="7">Billing Address</option>
            <option value="8">Shipping Address</option>
            <option value="9">Phone1</option>
            <option value="10">Phone2</option>
            <option value="11">Mobile</option>
            <option value="12">Sale Rep</option>
            <option value="13">Price Level</option>
            <option value="14">Payment Terms</option>
            <option value="15">Tax</option>
        </select>
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="consignmentLocationDiv" style="display:none">
        <label class="mb-2 fw-bold">Consignmet Location:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="consignmentLocationFilter" id="consignmentLocationFilter" data-allow-clear="true" placeholder="Search by Consignment Location">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="codeDiv" style="display:none">
        <label class="mb-2 fw-bold">Code:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="codeFilter" id="codeFilter" data-allow-clear="true" placeholder="Search by Code">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="contactNameDiv" style="display:none">
        <label class="mb-2 fw-bold">Contact Name:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="contactNameFilter" id="contactNameFilter" data-allow-clear="true" placeholder="Search by Contact Name">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="parentLocationDiv" style="display:none">
        <label class="mb-2 fw-bold">Parent Location:</label>
        <select id="parentLocationFilter" name="parentLocationFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select parent location--</option>
            @foreach($companies as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="setUpDateDiv" style="display:none">
        <label class="mb-2 fw-bold">SetUp Date:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="dateFilter" id="dateFilter" data-allow-clear="true" placeholder="Search by SetUp Date">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="typeDiv" style="display:none">
        <label class="mb-2 fw-bold">Type:</label>
        <select id="typeFilter" name="typeFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select type--</option>
            @foreach($customerTypes as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="billingAddressDiv" style="display:none">
        <label class="mb-2 fw-bold">Billing Address:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="billingAddressFilter" id="billingAddressFilter" data-allow-clear="true" placeholder="Search by Billing Address">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="shippingAddressDiv" style="display:none">
        <label class="mb-2 fw-bold">Shipping Address:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="shippingAddressFilter" id="shippingAddressFilter" data-allow-clear="true" placeholder="Search by Shipping Address">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="phone1Div" style="display:none">
        <label class="mb-2 fw-bold">Phone1:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="phone1Filter" id="phone1Filter" data-allow-clear="true" placeholder="Search by phone1">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="phone2Div" style="display:none">
        <label class="mb-2 fw-bold">Phone2:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="phone2Filter" id="phone2Filter" data-allow-clear="true" placeholder="Search by phone2">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="mobileDiv" style="display:none">
        <label class="mb-2 fw-bold">Mobile:</label>
        <input type="text" class="form-control dt-input dt-full-name" name="mobileFilter" id="mobileFilter" data-allow-clear="true" placeholder="Search by mobile">
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="saleDiv" style="display:none">
        <label class="mb-2 fw-bold">Sale Rep:</label>
        <select id="saleFilter" name="saleFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select sales representative--</option>
            @foreach($users as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="priceLevelDiv" style="display:none">
        <label class="mb-2 fw-bold">Price Level:</label>
        <select id="priceLevelFilter" name="priceLevelFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select price level--</option>
            @foreach($priceListLabels as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="paymentTermsDiv" style="display:none">
        <label class="mb-2 fw-bold">Payment Terms:</label>
        <select id="paymentTermFilter" name="paymentTermFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select payment terms--</option>
            @foreach($accountPaymentTerms as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 col-sm-6 filter-input mt-2" id="taxDiv" style="display:none">
        <label class="mb-2 fw-bold">Tax:</label>
        <select id="taxFilter" name="taxFilter" class="select2 form-select" data-allow-clear="true">
            <option value="">--select tax--</option>
            @foreach($salesTaxs as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>