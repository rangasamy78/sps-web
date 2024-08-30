@extends('layouts.admin')

@section('title', 'Credit Check Setting')

@section('styles')
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Credit Check Settings</h4>
        <div class="card">
            <div style="overflow:hidden;width:96%;margin:auto;">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <from name="creditCheckSettingForm" id="creditCheckSettingForm">
                        <div class="row">
                            <div class="card mb-6">
                                <div class="card-header">
                                    <h5 class="card-tile mb-0">Turn ON / OFF Credit check for below transactions:</h5>
                                </div>
                                <div class="card-body" style="padding-left: 3%;">
                                    <div class="row mt-4 gap-2 gap-sm-0">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <p class="mb-1 card-subtitle mt-0"> Pick Ticket / Packinglist </p>
                                        </div>
                                        <input type="hidden" value="{{ isset($creditCheckSettingDetail['id']) && $creditCheckSettingDetail['id'] ? $creditCheckSettingDetail['id'] : 0 }}"
                                            name="credit_check_setting_id" id="credit_check_setting_id">
                                        <div class="col-12 col-sm-6 col-md-8">
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" {{ isset($creditCheckSettingDetail['packing_list']) && $creditCheckSettingDetail['packing_list'] == 1 ? 'checked' : '' }}
                                                    name="packing_list" id="packing_list" value='1'>
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
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <p class="mb-1 card-subtitle mt-0"> Invoice </p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-8">
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" {{ isset($creditCheckSettingDetail['invoice']) && $creditCheckSettingDetail['invoice'] == 1 ? 'checked' : '' }}
                                                    name="invoice" id="invoice" value='1'>
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
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <p class="mb-1 card-subtitle mt-0"> Include Past Due AR in Credit check </p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-8">
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" {{ isset($creditCheckSettingDetail['credit_check']) && $creditCheckSettingDetail['credit_check'] == 1 ? 'checked' : '' }}
                                                    name="credit_check" id="credit_check" value='1'>
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
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <p class="mb-1 card-subtitle mt-0"> Purchase Order </p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-8">
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" {{ isset($creditCheckSettingDetail['purchase_order']) && $creditCheckSettingDetail['purchase_order'] == 1 ? 'checked' : '' }}
                                                    name="purchase_order" id="purchase_order" value='1'>
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
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <p class="mb-1 card-subtitle mt-0"> Relock the Sales Order on update </p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-8">
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" {{ isset($creditCheckSettingDetail['relock_sales_order']) && $creditCheckSettingDetail['relock_sales_order'] == 1 ? 'checked' : '' }}
                                                    name="relock_sales_order" id="relock_sales_order" value='1'>
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
    @include('credit_check_setting.__scripts')
@endsection
