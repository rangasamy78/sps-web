  @extends('layouts.admin')

  @section('title', 'Expense Categories')

  @section('styles')
  @endsection
  @section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Expense Categories </h4>
      @include('expense_category.__search')
      <div class="row mb-3">
        <div class="card">
          <div class="row mb-2 p-2">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="expenseCategoryTable">
                <thead>
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Expense Category Name</th>
                    <th>Expense Account</th>
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
  @include('expense_category.__model')
  @endsection
  @section('scripts')
  @include('expense_category.__script')
  @endsection
