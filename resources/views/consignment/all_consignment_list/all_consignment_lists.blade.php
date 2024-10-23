<div class="tab-pane fade show active" id="allAccount" role="tabpanel">
  <h4 class="card-title">Consignment</h4>
  <div class="row pt-2">
    <div class="col-12">
      <div class="d-flex gap-lg-4">
        <div class="form-check">
          <input class="form-check-input radio_dash" type="radio" checked name="radioGroup" id="radio1" value="1">
          <label class="form-check-label" for="radio1">Active Consignment Locations </label>
        </div>
        <div class="form-check">
          <input class="form-check-input radio_dash" type="radio" name="radioGroup" id="radio2" value="0">
          <label class="form-check-label" for="radio2">Inactive Consignment Locations</label>
        </div>
        <div class="form-check">
          <input class="form-check-input radio_dash" type="radio" name="radioGroup" id="radio3" value="2">
          <label class="form-check-label" for="radio3">Both</label>
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-between align-items-center row py-3 gap-2 gap-md-0">
    @include('consignment.all_consignment_list.__search')
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesConsignment">
      <thead class="table-header-bold">
        <tr>
          <th>&nbsp;</th>
          <th>Consignment Location</th>
          <th>Parent Location</th>
          <th>SetUp Date</th>
          <th>Type</th>
          <th>Billing Address</th>
          <th>Shipping Address</th>
          <th>Phone</th>
          <th width="250px">Sales Rep/Price Level</th>
          <th>Pmt.terms/Sales Tax</th>
          <th>Notes</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>