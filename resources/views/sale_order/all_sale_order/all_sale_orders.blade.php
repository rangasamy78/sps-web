<div class="tab-pane fade show active" id="allOpportunity" role="tabpanel">
  <h4 class="card-title">Sale Orders</h4>
  <div class="d-flex justify-content-between align-items-center row py-3 gap-2 gap-md-0">
    @include('sale_order.all_sale_order.__search')
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesSalesOrder">
      <thead class="table-header-bold">
        <tr>
          <th>SO #</th>
          <th>Date</th>
          <th>Cust. P.O #</th>
          <th>Job Name</th>
          <th>Delivery Type</th>
          <th>Req.Ship Dt</th>
          <th>ETA Date</th>
          <th>Bill To Customer</th>
          <th>Location</th>
          <th>Sales Person</th>
          <th>actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
