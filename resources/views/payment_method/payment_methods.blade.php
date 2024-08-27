  @extends('layouts.admin')

  @section('title', 'Payment Methods')

  @section('styles')
  @endsection
  @section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>Payment Methods</h4>
      @include('payment_method.__search')
      <div class="row mb-3">
        <div class="col">
          <div class="card p-4 pt-0">
            <div class="row">
              <div class="col">
                <table class="datatables-basic table tables-basic border-top table-striped" id="createPaymentMethodTable">
                  <thead class="table-header-bold">
                    <tr class="odd gradeX">
                      <th>Sl.No</th>
                      <th>Payment Method Name</th>
                      <th>Account</th>
                      <th>Account Type</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('payment_method.__model')
  @endsection

  @section('scripts')
  @include('payment_method.__script')
  @endsection