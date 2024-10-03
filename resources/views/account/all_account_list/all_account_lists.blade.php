<div class="tab-pane fade show active" id="allAccount" role="tabpanel">
  <h4 class="card-title">Account</h4>
  <div class="d-flex justify-content-between align-items-center row py-3 gap-2 gap-md-0">
    @include('account.all_account_list.__search')
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesAccount">
      <thead class="table-header-bold">
        <tr>
          <th>Sl.No</th>
          <th>Account Number</th>
          <th>Account Name</th>
          <th>Alternate Number</th>
          <th>Alternate Name</th>
          <th>Account Type</th>
          <th>Account Sub Type</th>
          <th>Special Account Type</th>
          <th>Sub Account Of</th>
          <th>Balance</th>
          <th>Status</th>
          <th>actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

  </div>
</div>