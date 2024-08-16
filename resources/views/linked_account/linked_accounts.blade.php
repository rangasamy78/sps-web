  @extends('layouts.admin')

  @section('title', 'Linked Account')

  @section('styles')
  @endsection
  @section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>Linked Account</h4>
      @include('linked_account.__search')
      <div class="row mb-3">
      <div class="col">
        <div class="card">
          <div class="row mb-2 p-2">
            <div class="col">
              <table class=" datatables-basic table tables-basic border-top table-striped" id="createLinkedAccountTable">
                <thead>
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Account Code</th>
                    <th>Account Name</th>
                    <th>Account Type</th>
                    <th>Account Sub Type</th>
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
  @include('linked_account.__model')
  @endsection
  @section('scripts')
  @include('linked_account.__script')
  @endsection