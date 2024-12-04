<div class="row">
    <div class="col">
        <input type="hidden" name="po_id" id="po_id" value="{{ $purchase_order->id ?? '' }}">
        <table class="datatables-basic table tables-basic border-top table-striped" id="poProductData">
            <thead class="table-header-bold">
                <tr>
                    <th>SKU / Generic SKU</th>
                    <th>Product</th>
                    <th></th>
                    <th></th>
                    <th>Cust/Loc Ref</th>
                    <th>Qty</th>
                    <th>Fulfilled</th>
                    <th>Balance</th>
                    <th>Unit Price</th>
                    <th>Extended</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subTotal = 0; 
                @endphp

                @foreach ($productPo as $product)
                    @php
                        $extended = $product->extended ?? 0; 
                        $subTotal += $extended; 
                    @endphp
                    <tr>
                        <td>{{ $product->product_sku ?? 'N/A' }}</td>
                        <td>{{ $product->product_name ?? 'N/A' }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $product->quantity ?? '0' }}</td>
                        <td>{{ $product->fulfilled ?? '0' }}</td>
                        <td>{{ $product->balance ?? '0' }}</td>
                        <td>${{ number_format($product->unit_price ?? 0, 2) }}</td>
                        <td>${{ number_format($extended, 2) }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" class="text-end"><strong>Sub Total:</strong></td>
                    <td colspan="2">${{ number_format($subTotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="9" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2">${{ number_format($total ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="9" class="text-end"><strong>Balance Due:</strong></td>
                    <td colspan="2">${{ number_format($balanceDue ?? 0, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
