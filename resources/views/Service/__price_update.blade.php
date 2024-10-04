
@extends('layouts.admin')
@section('title', '
Update Pricing')
@section('styles')
<style>
  .product-link {
    color: black;
    text-decoration: none;
}

.associate-link:hover {
    text-decoration: underline;
}

</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Product /</span><span> Update Pricing</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">{{ $product->product_name ?? '' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Alternate Name"><span class="text-dark fw-bold"> Pref. Supplier: </span> </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Generic Name"><span class="">Error!!!- Purchase Discount Ratio is not defined for this product.
                                        Error!!!- Supplier List Cost is not defined for this product.</label>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Safety Minimum Ratio (SR):"><span class="text-dark fw-bold">Safety Minimum Ratio (SR):: </span> </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Purchase Discount Ratio (%)"><span class="text-dark fw-bold">Purchase Discount Ratio (%): </span></label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for=""><span class="">Step 1: Supplier List Cost (SLC) : </span> </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for=""><span class="">Step 2: Suplier Net Cost (SNC = SLC * PDR) </span></label>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for=""><span class="">Step 3: Purchase Cost Home Currency (PCHC = SNC * CONV) :</span></label>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for=""><span class="">Step 4: Purchase Cost Landed (LC = PCHC * FR): </span> </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for=""><span class="">Step 5: Safety Price (SP = LC * SR) : </span></label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for=""><span class="">Step 6: Homeowner Price - Loose Slab Price (Price1) : </span> </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="GL Cost Of Goods Sold Account"><span class="text-dark fw-bold">Percentage Room: </span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                        <p class="d-flex align-items-center">
                            Avg. Landed Cost: $0.00
                            Last Landed Cost: $0.00
                            Avg. FOB Cost: $0.00
                            Last FOB Cost:$0.00
                        </p>
                        <p><b>Price Limits:<br> </b></p>
                        <p class="d-flex align-items-center">
                            <span> Min Price limit: $ </span>&nbsp;<input type="text" class="form-control"
                                style="width:75px" name="min_price_limit"> &nbsp;
                            <span> Max Price limit: $</span> &nbsp;<input type="text" class="form-control"
                                style="width:75px" name="max_price_limit">
                        </p>
                        <p class="d-flex align-items-center">
                            <b><input type="radio" checked name="price_radio" id="price_radio_p1"> Calculate P1, P2, P3 etc
                                discounted off of P1</b>
                            &nbsp;$&nbsp;<input type="text" class="form-control" style="width:75px"
                                name="discount_off_p1">
                        </p>
                        <p class="d-flex align-items-center">
                            <b><input type="radio" name="price_radio" id="price_radio_existing"> Increase existing
                                prices by</b>
                            &nbsp;$&nbsp;<input type="text" class="form-control" style="width:75px"
                                name="increase_existing_prices">
                        </p>
                        <p class="d-flex align-items-center">
                            <b><input type="radio" name="price_radio" id="price_radio_discount"> Discount existing
                                prices by</b>
                            &nbsp;$&nbsp;<input type="text" class="form-control" style="width:75px"
                                name="discount_existing_prices">
                        </p>
                        <p class="d-flex align-items-center">
                            <b><input type="radio" name="price_radio" id="price_radio_increase"> Increase existing
                                prices by</b>
                            &nbsp;$&nbsp;<input type="text" class="form-control" style="width:75px"
                                name="increase_existing_prices_by">
                        </p>
                        <p class="d-flex align-items-center">
                            <b><input type="radio" name="price_radio" id="price_radio_discount"> Discount existing
                                prices by</b>
                            &nbsp;$&nbsp;<input type="text" class="form-control" style="width:75px"
                                name="discount_existing_prices_by">
                        </p>
                    </div>




                </div>


                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><b>Label</b></th>
                                    <th><b>Current Prices</b></th>
                                    <th><b>New Prices</b></th>
                                    <th><b>Difference</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Homeowner Price - Loose Slab Price</td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="homeowner_price_current" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="homeowner_price_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="homeowner_price_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bundle Price - Bundle Price </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundle_price_current" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundle_price_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundle_price_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Special Price - Special Price </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="special_price_current" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="special_price_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="special_price_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Loose Slab Price Per SQFT - Price4 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="looseslab_price_current" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="looseslab_price_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="looseslab_price_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bundle Price Per SQFT - Price5 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundleprice_sqft_current" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundleprice_sqft_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundleprice_sqft_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Special Price Per SQFT - Price6 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="specialprice_sqft_current" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="specialprice_sqft_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="specialprice_sqft_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Owner Approval Price Per SQFT - Price7 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="owner_approval_current" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="owner_approval_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="owner_approval_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Loose Slab Price Per Slab - Price8 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="looseslab_per_current" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="looseslab_per_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="looseslab_per_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bundle Price Per Slab - Price9 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundleprice_per_current" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundleprice_per_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="bundleprice_per_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Special Price Per Slab - Price10 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="spl_price_current" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="spl_price_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="spl_price_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Owner Approval Price Per Slab - Price11 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="owner_approval_current" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="owner_approval_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="owner_approval_difference" value=""
                                                readonly></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Price12 - Price12 </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="price12_current" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="price12_new" value=""></div>
                                    </td>
                                    <td>
                                        <div class="input-wrapper"><span>$</span><input type="text"
                                                class="form-control input-sm" id="price12_difference" value="" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: center;">
                                        <button type="submit" class="btn btn-primary">Calculate & Review</button>
                                        <button type="submit" class="btn btn-primary">Update New Prices</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /first column -->
            </div>
        
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>



@endsection
@section('scripts')
@include('product.__scripts')
@endsection
