<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Suppliers : </span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        {{ $suppliers->supplier_name ?? '' }}<br>
                        {{ $suppliers->remit_address ?? '' }}<br>
                        {{ $suppliers->remit_suite ?? '' }}<br>
                        {{ $suppliers->remit_state ?? '' }} , {{ $suppliers->remit_city ?? '' }} , {{ $suppliers->remit_zip ?? '' }}<br>
                        {{ $suppliers->remit_country ? $suppliers->remit_country->country_name : '' }}<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Terms : </span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Request by</th>
                                    <th>Payment Terms</th>
                                    <th>Shippment Terms</th>
                                    <th>Required Ship Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $terms->requested_by_name ?? '' }} </td>
                                    <td>{{ $terms->response_payment_terms ?? '' }} </td>
                                    <td>{{ $terms->response_shipment_terms ?? '' }} </td>
                                    <td>{{ toDbDateDisplay($terms->response_ship_date ?? '') }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Products</span>:</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>req product</th>
                                    <th>Bundles</th>
                                    <th>Slabs</th>
                                    <th>Quantity</th>
                                    <th>Resp Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $product)
                                <tr>
                                    <td>{{ $product['product_name'] }} ( {{ $product['product_sku'] }} )</td>
                                    <td>{{ $product['requested_product'] }}</td>
                                    <td>{{ $product['picking_qty'] }}</td>
                                    <td>{{ $product['slab'] }}</td>
                                    <td>{{ $product['qty'] }}</td>
                                    <td>{{ $product['response_qty'] }}</td>
                                    <td>{{ $product['unit_price'] }}</td>
                                    <td>{{ $product['total_price'] }}</td>
                                    <td>{{ $product['comments'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
