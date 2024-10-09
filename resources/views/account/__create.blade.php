@extends('layouts.admin')

@section('title', 'Add Account')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <form id="accountForm">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{route('accounts.index')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Account /</span>
                    Add Account</span>
                </a></h4>
            <div class="app-ecommerce">

                <div class="row">
                    <!-- First column-->
                    <div class="col-12 col-lg-7">
                        <!-- Account Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Account Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" id="account_id" name="account_id">
                                        <label class="form-label" for="account_number">Account Number <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control" id="account_number" placeholder="Enter Account Number" name="account_number" aria-label="Supplier Name" />
                                        <span class="text-danger error-text account_number_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="code">Account Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <input type="text" class="form-control" id="account_name" placeholder="Enter Account Name" name="account_name" aria-label="Supplier Name" />
                                        <span class="text-danger error-text account_name_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="account_type_id">Account Type <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="account_type_id" name="account_type_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($accountTypes as $accountType)
                                            <option value="{{ $accountType->id }}">{{ $accountType->account_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text account_type_id_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="account_sub_type_id">Account Sub Type</label>
                                        <select id="account_sub_type_id" name="account_sub_type_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($accountSubTypes as $accountSubType)
                                            <option value="{{ $accountSubType->id }}">{{ $accountSubType->sub_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text account_sub_type_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="special_account_type_id">Special Account Type</label>
                                        <select id="special_account_type_id" name="special_account_type_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($specialAccountTypes as $specialAccountType)
                                            <option value="{{ $specialAccountType->id }}">{{ $specialAccountType->special_account_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text special_account_type_id_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="account_operating_location_id">Account's Operating Location</label>
                                        <select id="account_operating_location_id" name="account_operating_location_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text account_operating_location_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="alternate_number">Alternate Number</label>
                                        <input type="text" class="form-control" id="alternate_number" placeholder="Enter Alternate Number" name="alternate_number" aria-label="Alternate Number" />
                                        <span class="text-danger error-text alternate_number_error"></span>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label" for="alternate_name">Alternate Name</label>
                                        <input type="text" class="form-control" id="alternate_name" placeholder="Enter Alternate Name" name="alternate_name" aria-label="Alternate Name" />
                                        <span class="text-danger error-text alternate_name_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="is_sub_account_of_id">Is Sub Account Of</label>
                                        <select id="is_sub_account_of_id" name="is_sub_account_of_id" class="select2 form-select" data-allow-clear="true">
                                        </select>
                                        <span class="text-danger error-text is_sub_account_of_id_error"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="currency_id">Currency <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                        <select id="currency_id" name="currency_id" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--select--</option>
                                            @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->currency_name }}-{{ $currency->currency_code }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text currency_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="statement_end_day">Statement End Day</label>
                                        <input type="text" class="form-control" id="statement_end_day" placeholder="Enter Statement End Day" name="statement_end_day" aria-label="Statement End Day" />
                                        <span class="text-danger error-text statement_end_day_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Account Information -->
                        <!-- instruction information -->
                        <div class="card mb-4 bankCard" style="display:none">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Bank Information</h5>
                            </div>
                            <div class="card-body">

                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row mb-1">
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="bank_name">Bank Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <input type="text" class="form-control" id="bank_name" placeholder="Enter Bank Name" name="bank_name" aria-label="Bank Name" />
                                                <span class="text-danger error-text bank_name_error"></span>
                                            </div>

                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="branch_name">Branch Name</label>
                                                <input type="text" class="form-control" id="branch_name" placeholder="Enter Branch Name" name="branch_name" aria-label="Branch Name" />
                                                <span class="text-danger error-text branch_name_error"></span>
                                            </div>
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="manager_name">Manager Name</label>
                                                <input type="text" class="form-control" id="manager_name" placeholder="Enter Manager Name" name="manager_name" aria-label="Manager Name" />
                                                <span class="text-danger error-text manager_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="phone">Phone</label>
                                                <input type="text" class="form-control" id="phone" placeholder="Enter Phone" name="phone" aria-label="Phone" />
                                                <span class="text-danger error-text phone_error"></span>
                                            </div>
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="fax">Fax</label>
                                                <input type="text" class="form-control" id="fax" placeholder="Enter Fax" name="fax" aria-label="Fax" />
                                                <span class="text-danger error-text fax_error"></span>
                                            </div>
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="website">Website</label>
                                                <input type="text" class="form-control" id="website" placeholder="Enter Website" name="website" aria-label="Website" />
                                                <span class="text-danger error-text website_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="swift_code">Swift Code</label>
                                                <input type="text" class="form-control" id="swift_code" placeholder="Enter Swift Code" name="swift_code" aria-label="Swift Code" />
                                                <span class="text-danger error-text swift_code_error"></span>
                                            </div>
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="routing_number">Routing Number</label>
                                                <input type="text" class="form-control" id="routing_number" placeholder="Enter Routing Number" name="routing_number" aria-label="Routing Number" />
                                                <span class="text-danger error-text routing_number_error"></span>
                                            </div>
                                            <div class="mb-3 col-12 col-lg-4">
                                                <label class="form-label mb-1" for="bank_account_number">Account Number</label>
                                                <input type="text" class="form-control" id="bank_account_number" placeholder="Enter Account Number" name="bank_account_number" aria-label="Account Number" />
                                                <span class="text-danger error-text bank_account_number_error"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col d-flex align-items-center">
                                                <input class="form-check-input" type="checkbox" value="1" id="is_allow_printing_checks" name="is_allow_printing_checks" />
                                                <label class="form-label ps-2 mb-0" for="is_allow_printing_checks"> Allow Printing Checks from this Account </label>
                                                <span class="text-danger error-text is_allow_printing_checks_error ms-2"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /Instruction information -->
                    </div>
                    <!-- /Second column -->

                    <!-- Second column -->
                    <div class="col-12 col-lg-5">
                        <!-- Contact Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Account Settings</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row mb-4">
                                    <div class="col d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_default_account" name="is_default_account" />
                                        <label class="form-label ps-2 mb-0" for="is_default_account">Default account in Special Account Type</label>
                                        <span class="text-danger error-text is_default_account_error ms-2"></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_budgeted_account" name="is_budgeted_account" />
                                        <label class="form-label ps-2 mb-0" for="is_budgeted_account">This account is Budgeted</label>
                                        <span class="text-danger error-text is_budgeted_account_error ms-2"></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_tax_account" name="is_tax_account" />
                                        <label class="form-label ps-2 mb-0" for="is_tax_account">This account is a Tax Account</label>
                                        <span class="text-danger error-text is_tax_account_error ms-2"></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_reconciled_account" name="is_reconciled_account" />
                                        <label class="form-label ps-2 mb-0" for="is_reconciled_account">This account is Reconciled</label>
                                    </div>
                                    <span class="text-danger error-text is_reconciled_account_error ms-2"></span>
                                </div>
                                <div class="row mb-4">
                                    <div class="col d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_allow_bank_reconciliation" name="is_allow_bank_reconciliation" />
                                        <label class="form-label ps-2 mb-0" for="is_allow_bank_reconciliation"> Allow bank reconciliation with multiple dates</label>
                                        <span class="text-danger error-text is_allow_bank_reconciliation_error ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Contact Card -->
                        <!-- Remit to address Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Instructions</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="row">
                                    <div class="mb-3 col">
                                        <label class="form-label mb-1" for="internal_notes">Internal Notes </label>
                                        <textarea id="internal_notes" name="internal_notes" class="form-control" rows="3" placeholder="Enter Internal Notes" style="resize:none"></textarea>
                                        <span class="text-danger error-text internal_notes_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" class="form-control" id="status" name="status" value="1" aria-label="status" />
                                </div>
                            </div>
                        </div>
                        <!-- /remit to address Card -->
                        <!-- /Organize Card -->

                    </div>
                    <!-- /Second column -->
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary btn-md" id="savedata" name="savedata">Save New Account</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton" name="cancelButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </form>
</div>

@endsection
@section('scripts')
@include('account.__script')
@endsection