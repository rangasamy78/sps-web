
@extends('layouts.admin')
@section('title', 'Show Product')
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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Product /</span><span> Show Product</span></h4>
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
                                        <label for="Alternate Name"><span class="text-dark fw-bold">Alternate Name: </span> {{ $product->product_alternate_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Generic Name"><span class="text-dark fw-bold">Generic Name: </span>{{ $product->generic_name ?? '' }}</label>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Type / Form"><span class="text-dark fw-bold">Type / Form: </span> {{ $product->product_type->product_type ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Category / Nature"><span class="text-dark fw-bold">Category / Nature: </span>{{ $product->product_category->product_category_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Sub Category"><span class="text-dark fw-bold">Sub Category: </span> {{ $product->product_sub_category->product_sub_category_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Group"><span class="text-dark fw-bold">Group: </span>{{ $product->product_group->product_group_name ?? '' }}</label>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Finish"><span class="text-dark fw-bold">Finish: </span>{{ $product->product_finish->finish ?? '' }}</label>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Thickness"><span class="text-dark fw-bold">Thickness: </span> {{ $product->product_thickness->product_thickness_name ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="GL Inventory Link Account"><span class="text-dark fw-bold">GL Inventory Link Account: </span>{{ $product->product_type->product_type ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="GL Income Account"><span class="text-dark fw-bold">GL Income Account: </span> {{ $product->product_type->product_type ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="GL Cost Of Goods Sold Account"><span class="text-dark fw-bold">GL Cost Of Goods Sold Account: </span>{{ $product->product_type->product_type ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="Base Color"><span class="text-dark fw-bold">Base Color: </span>{{ $product->product_color->product_color ?? '' }}</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3">
                            <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">
                                Selling Prices for this Product: 
                                    <a href="{{ route('products.price_update', $product->id) }}" style="text-decoration: none;">
                                        <span style="font-size: 1.5em;">&#128425;</span>
                                    </a>
                                   
                                </h5>
                            </h5>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="primary_phone"><span class="text-dark fw-bold">Homeowner Price - Loose Slab Price:</span> {{ $product->product_price->homeowner_price ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="secondary_phone"><span class="text-dark fw-bold">Bundle Price - Bundle Price:</span> {{ $product->product_price->bundle_price ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="mobile"><span class="text-dark fw-bold">Special Price - Special Price:</span> {{ $product->product_price->special_price ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Loose Slab Price Per SQFT - Price4:</span> {{ $product->product_price->loose_slab_price ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="mobile"><span class="text-dark fw-bold">Bundle Price Per SQFT - Price5:</span> {{ $product->product_price->bundle_price_sqft ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Special Price Per SQFT - Price6:</span> {{ $product->product_price->special_price_per_sqft ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Owner Approval Price Per SQFT - Price7:</span> {{ $product->product_price->owner_approval_price ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Loose Slab Price Per Slab - Price8:</span> {{ $product->product_price->loose_slab_per_slab ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Bundle Price Per Slab - Price9:</span> {{ $product->product_price->bundle_price_per_slab ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Special Price Per Slab - Price10:</span> {{ $product->product_price->special_price_per_slab ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Owner Approval Price Per Slab - Price11:</span> {{ $product->product_price->owner_approval_price_per_slab ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="website"><span class="text-dark fw-bold">Price12 - Price12:</span> {{ $product->product_price->price12 ?? '' }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Reorder Levels:
                                </h5>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="primary_phone"><span class="text-dark fw-bold">Preferred Supplier:</span> </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="secondary_phone"><span class="text-dark fw-bold">Supplier Url:</span> </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="mobile"><span class="text-dark fw-bold">Brand:</span> </label>
                                    </div>
                                </div>

                                <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Units:
                                </h5>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="primary_phone"><span class="text-dark fw-bold">Base UOM:</span> {{ $product->unit_measure->unit_measure_name ?? '' }}</label>
                                    </div>
                                </div>
                               

                                <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Inventory Balance:
                                </h5>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="primary_phone"><span class="text-dark fw-bold">Available:</span> </label>
                                    </div>
                                </div>
                               
                            </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /first column -->
            </div>
            <d<div class="row">
    <div class="col-12 order-0 order-md-1">
        <!-- Navigation -->
        <div class="col-12 mx-auto card-separator">
            <div class="d-flex justify-content-between mb-3 pe-md-3">
                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                    <li class="nav-item me-3">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#inventory">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Inventory</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#special_pricing">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Special Pricing</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#supplier_prices">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Supplier Prices</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allocated">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Allocated</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#visit">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Visit</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sample_orders">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Sample Orders</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quotes">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Quotes</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#open_sos">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Open SOs</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#open_pos">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Open POs</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#in_transit">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">In Transit</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#web">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Web</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#info">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Info</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">Files</span>
                        </button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                            <i class="bx bx-wallet me-2"></i>
                            <span class="align-middle">CRM</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
          
            <div class="card-body">
                <div class="row">
                    <div class="col-12 pt-4 pt-md-0">
                        <div class="tab-content p-0 pe-md-5 ps-md-3">
                            <div class="tab-pane fade show active" id="inventory">
                                @include('product.details.inventory')
                            </div>
                            <div class="tab-pane fade" id="special_pricing">
                                @include('product.details.special_pricing')
                            </div>
                            <div class="tab-pane fade" id="supplier_prices">
                                @include('product.details.supplier_prices')
                            </div>
                            <div class="tab-pane fade" id="allocated">
                                @include('product.details.allocated')
                            </div>
                            <div class="tab-pane fade" id="visit">
                                @include('product.details.visit')
                            </div>
                            <div class="tab-pane fade" id="sample_orders">
                                @include('product.details.sample_orders')
                            </div>
                            <div class="tab-pane fade" id="quotes">
                                @include('product.details.quotes')
                            </div>
                            <div class="tab-pane fade" id="open_sos">
                                @include('product.details.open_sos')
                            </div>
                            <div class="tab-pane fade" id="open_pos">
                                @include('product.details.open_pos')
                            </div>
                            <div class="tab-pane fade" id="in_transit">
                                @include('product.details.in_transit')
                            </div>
                            <div class="tab-pane fade" id="web">
                            @include('product.details.web')
                            </div>
                            <div class="tab-pane fade" id="info">
                            @include('product.details.info')
                            </div>
                            <div class="tab-pane fade" id="files">
                            @include('product.details.files')
                            </div>
                            <div class="tab-pane fade" id="crm">
                            @include('product.details.crm')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@include('product.__scripts')
@endsection
