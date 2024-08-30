@extends('layouts.admin')

@section('title', 'PickTicket Restriction')

@section('styles')
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> PickTicket Restrictions</h4>
        <div class="card">
            <div style="overflow:hidden;width:96%;margin:auto;">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <form name="pickTicketRestrictionForm" id="pickTicketRestrictionForm">
                        <div class="row">
                            <div class="card mb-6">
                                <div class="card-body">
                                    <div class="row mt-4 gap-2 gap-sm-0">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <p class="mb-1 card-subtitle mt-0">Enable PickTicket Restriction </p>
                                        </div>
                                        <input type="hidden" value="{{ isset($pickTicketRestrictionDetail['id']) && $pickTicketRestrictionDetail['id'] ? $pickTicketRestrictionDetail['id'] : 0 }}"
                                            name="pick_ticket_restriction_id" id="pick_ticket_restriction_id">
                                        <div class="col-12 col-sm-6 col-md-8">
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" {{ isset($pickTicketRestrictionDetail['enable_pick_ticket_restriction']) && $pickTicketRestrictionDetail['enable_pick_ticket_restriction'] == 1 ? 'checked' : '' }}
                                                    name="enable_pick_ticket_restriction" id="enable_pick_ticket_restriction" value='1'>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="ri-check-line"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="ri-close-line"></i>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="pickTicketDisplay"
                                        style="{{ isset($pickTicketRestrictionDetail['enable_pick_ticket_restriction']) && $pickTicketRestrictionDetail['enable_pick_ticket_restriction'] != 0 ? '' : 'display: none' }}">
                                        <div class="row mt-4 gap-2 gap-sm-0">
                                            <div class="col-12 col-sm-6 col-md-3" style="padding-top: 1%;">
                                                <p class="mb-1 card-subtitle mt-0">Default PickTicket Restriction</p>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-8">
                                                <label class="switch switch-primary">
                                                <div class="row">
                                                    <div class="col-md mb-md-0 mb-2">
                                                        <div class="form-check custom-option custom-option-label custom-option-basic">
                                                            <label class="form-check-label custom-option-content" for="default_pick_ticket_restriction1">
                                                                <input name="default_pick_ticket_restriction" class="form-check-input" type="radio" value="1" id="default_pick_ticket_restriction1"
                                                                    {{ isset($pickTicketRestrictionDetail['default_pick_ticket_restriction']) && $pickTicketRestrictionDetail['default_pick_ticket_restriction'] == 1 ? 'checked' : '' }}>
                                                                <span class="custom-option-header">
                                                                    <span class="h6 mb-0">Slab</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-check custom-option custom-option-label custom-option-basic">
                                                            <label class="form-check-label custom-option-content" for="default_pick_ticket_restriction2">
                                                                <input name="default_pick_ticket_restriction" class="form-check-input" type="radio" value="2" id="default_pick_ticket_restriction2"
                                                                    {{ isset($pickTicketRestrictionDetail['default_pick_ticket_restriction']) && $pickTicketRestrictionDetail['default_pick_ticket_restriction'] == 2 ? 'checked' : '' }}>
                                                                <span class="custom-option-header">
                                                                    <span class="h6 mb-0">Lot</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-check custom-option custom-option-label custom-option-basic">
                                                            <label class="form-check-label custom-option-content" for="default_pick_ticket_restriction3">
                                                                <input name="default_pick_ticket_restriction" class="form-check-input" type="radio" value="3" id="default_pick_ticket_restriction3"
                                                                    {{ isset($pickTicketRestrictionDetail['default_pick_ticket_restriction']) && $pickTicketRestrictionDetail['default_pick_ticket_restriction'] == 3 ? 'checked' : '' }}>
                                                                <span class="custom-option-header">
                                                                    <span class="h6 mb-0">Product</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 gap-2 gap-sm-0">
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <p class="mb-1 card-subtitle mt-0">IS PickTicket Restriction Required ?</p>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-8">
                                                <label class="switch switch-primary">
                                                    <input type="checkbox" class="switch-input" name="pick_ticket_restriction_required"  id="pick_ticket_restriction_required" value="1"
                                                        {{ isset($pickTicketRestrictionDetail['pick_ticket_restriction_required']) && $pickTicketRestrictionDetail['pick_ticket_restriction_required'] ? 'checked' : '' }}>
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on">
                                                            <i class="ri-check-line"></i>
                                                        </span>
                                                        <span class="switch-off">
                                                            <i class="ri-close-line"></i>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mt-4 gap-2 gap-sm-0">
                                            <div class="col-12 col-sm-6 col-md-3" style="padding-top: 1%;">
                                                <p class="mb-1 card-subtitle mt-0">Lot Restriction is based on</p>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-8">
                                                <label class="switch switch-primary">
                                                <div class="row">
                                                    <div class="col-md mb-md-0 mb-2">
                                                        <div class="form-check custom-option custom-option-label custom-option-basic">
                                                            <label class="form-check-label custom-option-content" for="lot_restriction_based_on1">
                                                                <input name="lot_restriction_based_on" class="form-check-input" type="radio" value="1" id="lot_restriction_based_on1"
                                                                    {{ isset($pickTicketRestrictionDetail['default_lot_restriction_based_on']) && $pickTicketRestrictionDetail['default_lot_restriction_based_on'] == 1 ? 'checked' : '' }}>
                                                                <span class="custom-option-header">
                                                                    <span class="h6 mb-0">Lot/Block</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-check custom-option custom-option-label custom-option-basic">
                                                            <label class="form-check-label custom-option-content" for="lot_restriction_based_on2">
                                                                <input name="lot_restriction_based_on" class="form-check-input" type="radio" value="2" id="lot_restriction_based_on2"
                                                                    {{ isset($pickTicketRestrictionDetail['default_lot_restriction_based_on']) && $pickTicketRestrictionDetail['default_lot_restriction_based_on'] == 2 ? 'checked' : '' }}>
                                                                <span class="custom-option-header">
                                                                    <span class="h6 mb-0">Bundle</span>
                                                                </span>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-check custom-option custom-option-label custom-option-basic">
                                                            <label class="form-check-label custom-option-content" for="lot_restriction_based_on3">
                                                                <input name="lot_restriction_based_on" class="form-check-input" type="radio" value="3" id="lot_restriction_based_on3"
                                                                    {{ isset($pickTicketRestrictionDetail['default_lot_restriction_based_on']) && $pickTicketRestrictionDetail['default_lot_restriction_based_on'] == 3 ? 'checked' : '' }}>
                                                                <span class="custom-option-header">
                                                                    <span class="h6 mb-0">Supp.Ref</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('pick_ticket_restriction.__scripts')
@endsection
