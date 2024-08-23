  @extends('layouts.admin')

  @section('title', 'Linked Account')

  @section('styles')
  @endsection
  @section('content')
  <!-- Content -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <!-- //toast -->
      <div class="container-toast">

      </div>
      <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Linked Account</h4>
      <div class="row mb-3">
        <!-- DataTable with Buttons -->

        <div class="card p-4 pt-0">
          <!-- </div> -->
          <div class="row">

            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="createLinkedAccountTable">
                <thead class="table-header-bold">
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
  <!-- / Content -->
  @include('linked_account.__model')
  @endsection

  @section('scripts')
  @include('linked_account.__script')
  @endsection