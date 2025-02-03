@extends('layouts.admin')

@section('title', 'Release Hold')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>

@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-2">
            <div class="col-6">
                <h4 class="card-title mb-0 fw-bold">
                    <span class="text-dark fw-bold">Release Hold # {{$hold->hold_code}}</span><br>
                </h4>
            </div>
        </div>
        <div class="app-ecommerce">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="releaseHoldForm">
                            <div class="card-body">
                                <div class="row">
                                    <!-- 1st column -->
                                    <div class="col-lg-3 col-sm-12">
                                        <div class="row">
                                            <div class="col">

                                                <!-- <div class="row">
                                                <span>{{ $holdDate }}</span>
                                            </div> -->
                                                <label class="form-label text-dark fw-bold" style="font-size:13pt">Hold #:{{$hold->hold_code}}
                                                    <div class="text-primary fw-bold" style="font-size:8pt">{{$holdDate??''}}</div>
                                                </label>
                                            </div>
                                        </div>
                                        @if(optional($location)->company_name)
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="form-label text-dark fw-bold" style="font-size:10pt">{{$location->company_name??''}}
                                                        <div class="text-primary fw-bold" style="font-size:8pt">Location</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="form-label text-dark fw-bold" style="font-size:10pt">{{$customer->customer_name??''}}
                                                        <div class="text-primary fw-bold" style="font-size:8pt">Customer</div>
                                                    </label>
                                                </div>
                                                @if(optional($hold)->bill_to_attn)
                                                <div class="row">
                                                    <label class="form-label text-dark" style="font-size:9pt"><i class="fi fi-rr-user"></i>
                                                        <span class="text-dark fw-bold">{{$hold->bill_to_attn??''}}</span>
                                                    </label>
                                                </div>
                                                @endif
                                                @if(optional($primaryPerson)->first_name)
                                                <div class="row">
                                                    <label class="form-label text-dark" style="font-size:9pt"><i class="fi fi-rr-user"></i>
                                                        <span class="text-dark fw-bold">{{$primaryPerson->first_name??''}} {{$primaryPerson->last_name??''}}</span>
                                                    </label>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 2nd column -->
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="row mb-2">
                                            <div class="col-8">
                                                <input type="hidden" name="hold_id" id="hold_id" value="{{$hold->id}}">
                                                <input type="hidden" name="is_released" id="is_released" value="1">
                                                <label class="form-label text-dark fw-bold">Release Date <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <input type="date" class="form-control" name="release_date" id="release_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label text-dark fw-bold">Release Hold Reason Codes <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="release_hold_reason" id="noResponse" value="No response from customer">
                                                    <label class="form-check-label" for="noResponse">
                                                        No response from customer
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="release_hold_reason" id="wantedToRelease" value="Customer wanted to release">
                                                    <label class="form-check-label" for="wantedToRelease">
                                                        Customer wanted to release
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" checked name="release_hold_reason" id="holdExpired" value="Hold expired">
                                                    <label class="form-check-label" for="holdExpired">
                                                        Hold expired
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="release_hold_reason" id="boughtOtherCompany" value="Home Owner Bought from other company">
                                                    <label class="form-check-label" for="boughtOtherCompany">
                                                        Home Owner Bought from other company
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="release_hold_reason" id="priceExpensive" value="Price was expensive">
                                                    <label class="form-check-label" for="priceExpensive">
                                                        Price was expensive
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- //3rd column -->
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label text-dark fw-bold">Internal Notes</label>
                                                <textarea type="text" class="form-control" name="internal_notes" id="internal_notes" rows="3">{{$hold->internal_notes}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label text-dark fw-bold">Printed Notes</label>
                                                <textarea type="text" class="form-control" name="printed_notes" id="printed_notes" rows="3">{{$hold->printed_notes}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top border-dark mb-4 mt-3"></div>

                                <div class="row mt-4">
                                    <div class="card-datatable table-responsive">
                                        <table class="table table-hover border-top" id="holdProductDataTable">
                                            <thead class="table-header-bold table-primary">
                                                <tr>
                                                    <th>Item#(Supplier Ref) - Lot </th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="hold_product">
                                                @foreach ($holdProducts as $index => $holdProduct)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="hold_product_id[]" id="hold_product_id[]" value="{{ $holdProduct->id }}">
                                                        <span style="font-size: 8pt;">{{ $holdProduct->product_name }}</span>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <input type="hidden" class="form-control" name="product_id[]" id="product_id[]" value="{{ $holdProduct->product_id }}">
                                                        </div>
                                                        <span class="text-danger error-text product_id_error"></span>
                                                    </td>
                                                    <td><input type="number" readonly class="form-control form-control-sm product-quantity" value="{{ $holdProduct->product_quantity }}" name="product_quantity[]" id="product_quantity[]" data-id="{{ $holdProduct->product_id }}" style="width: 100px;"></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-1">$</span>
                                                            <input type="number" class="form-control product-price form-control-sm"
                                                                name="product_unit_price[]" id="product_unit_price[]"
                                                                value="{{ $holdProduct->product_unit_price }}"
                                                                data-id="{{ $holdProduct->product_id }}" style="width: 120px;">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">$</span>
                                                            <input type="text" class="form-control form-control-sm product-amount"
                                                                id="product_amount[]" name="product_amount[]"
                                                                value="{{ $holdProduct->product_amount }}" readonly style="width: 100px;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="card-datatable table-responsive">
                                        <table class="table table-hover border" id="holdServiceDataTable">
                                            <thead class="table-header-bold table-primary">
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Description</th>
                                                    <th>Quantity X Unit Price = Extended</th>
                                                    <th>Tax</th>
                                                </tr>
                                            </thead>
                                            <tbody id="hold_service">
                                                @foreach ($holdServices as $holdService )
                                                <tr>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="hold_service_id[]" id="hold_service_id[]" value="{{ $holdService->id }}">
                                                        <select class="form-control form-control-sm" name="service_id[]" style="width:250px">
                                                            <option value="">Select Service</option>
                                                            @foreach ($data['services'] as $id=>$service_name)
                                                            <option value="{{$id}}" {{ $holdService && $holdService->service_id == $id ? 'selected' : '' }}>{{$service_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text service_id_error"></span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" name="service_description[]" value="{{$holdService->service_description}}">
                                                        <span class="text-danger error-text service_description_error"></span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex p-1 gap-2">
                                                            <input type="number" class="form-control form-control-sm service-quantity" name="service_quantity[]" style="width:100px" value="{{$holdService->service_quantity}}">
                                                            <span class="text-dark fw-bold me-1" style="font-size:8pt; white-space: nowrap;">EA</span>
                                                            <span class="text-dark fw-bold" style="font-size:8pt; white-space: nowrap;">x $</span>
                                                            <input type="number" class="form-control form-control-sm service-unit-price" name="service_unit_price[]" style="width:100px" value="{{$holdService->service_unit_price}}">
                                                            <span class="text-dark fw-bold" style="font-size:8pt; white-space: nowrap;">= $</span>
                                                            <input type="number" class="form-control form-control-sm service-amount" readonly name="service_amount[]" style="width:100px" value="{{$holdService->service_amount}}">
                                                        </div>
                                                        <span class="text-danger error-text _error"></span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input tax-check" value="1" name="is_tax[]" {{ isset($holdService->is_tax) && $holdService->is_tax ? 'checked' : '' }}>
                                                        <span class="text-danger error-text is_tax_error"></span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <label class="text-dark fw-bold mt-2">Sub Total:</label>
                                            <span class="mt-2 ms-4 fw-bold" id="hold_sub_total">$</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <label class="text-dark fw-bold mt-2">
                                                Tax
                                                @if(!empty($taxCode?->tax_code_label))
                                                ({{ $taxCode->tax_code_label }} - {{ $taxAmount?->tax_code_total ?? '0' }}%):
                                                @else
                                                ()
                                                @endif
                                            </label>
                                            <input type="hidden" readonly class="form-control  border-0 w-25" id="tax_code_amount" name="tax_code_amount" value="{{$taxAmount?->tax_code_total ?? '0' }}">
                                            <span class="mt-2 ms-4 fw-bold" id="tax_code_amount_label">$</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <label class="text-dark fw-bold mt-2">Total:</label>
                                            <span class="mt-2 ms-4 fw-bold" id="hold_total">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row text-end mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-dark" id="saveReleaseHoldAddToCardBtn" name="saveReleaseHoldAddToCardBtn">Release Hold and Add to Cart</button>
                    <button type="submit" class="btn btn-primary" id="saveReleaseHoldBtn" name="saveReleaseHoldBtn">Release Hold</button>
                    <button type="button" class="btn btn-secondary" id="cancelReleaseBtn" name="cancelReleaseBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<div class="content-backdrop fade"></div>
</div>
@endsection
@section('scripts')
@include('hold.release_hold.__script')
@endsection