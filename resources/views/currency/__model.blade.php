<div class="modal fade" id="currencyModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="currencyForm"  class="form-horizontal">
                    <input type="hidden" name="currency_id" id="currency_id">
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Currency Code<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="Enter Currency Code" value="">
                        </div>
                        <span class="text-danger error-text currency_code_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Currency Name<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="currency_name" name="currency_name" placeholder="Enter Currency Name" value="">
                        </div>
                        <span class="text-danger error-text currency_name_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Currency (Symbol)<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" placeholder="Enter Currency Symbol" value="">
                        </div>
                        <span class="text-danger error-text currency_symbol_error"></span>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Exchange Rate<sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="currency_exchange_rate" name="currency_exchange_rate" placeholder="Enter Currency Exchange Rate" value="">
                        </div>
                        <span class="text-danger error-text currency_exchange_rate_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" name="savedata" value="Save">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showCurrencyModal" tabindex="-1" aria-labelledby="showCurrencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showCurrencyModalLabel">Show Currency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="currencyShowForm" name="currencyShowForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Currency Code</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="currency_code" name="currency_code" value="">
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Currency Name</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="currency_name" name="currency_name" value="">
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Currency (Symbol)</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="currency_symbol" name="currency_symbol" value="">
                        </div>
                    </div>
                    <div class="form-group mb-2 p-1">
                        <label for="name" class="form-label pb-1">Exchange Rate</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="currency_exchange_rate" name="currency_exchange_rate" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
