<div class="tab-pane fade show active" id="po_details" role="tabpanel">
    <table class="datatables-basic table tables-basic border-top table-striped" id="po_details">
        <thead class="table-header-bold">
            <tr>
                <th>Service/Supplies</th>
                <th>Type</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Fullfilled Qty</th>
                <th>Uom</th>
                <th>Unit Cost</th>
                <th>Extended</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
            @endphp

            @foreach ($vendor_po_details as $detail)
            @php
            $extended = $detail->quantity * $detail->unit_cost;
            $total += $extended;
            @endphp
            <tr>
                <td>{{ $detail->service ?? '' }}</td>
                <td>{{ "Service" }}</td>
                <td>{{ $detail->description }}</td>
                <td>{{ number_format($detail->quantity, 2) }}</td>
                <td>{{ "0.00" }}</td>
                <td>{{ $detail->uom }}</td>
                <td>{{ number_format($detail->unit_cost, 2) }}</td>
                <td>{{ number_format($extended, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6"></td>
                <td><strong>Total:</strong></td>
                <td><strong>{{ number_format($total, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td><strong>Balance Due:</strong></td>
                <td><strong>{{ number_format($total, 2) }}</strong></td>

            </tr>
        </tbody>
    </table>
</div>