@extends('layouts.admin')

@section('title', 'Freight Bills')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Freight Bills</h4>

    <div class="row mb-3">
      <div class="col">
        <div class="card pt-0 p-4">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Bill Inv#</th>
                    <th>P.O #</th>
                    <th>Invoice Dt.</th>
                    <th>Due Date</th>
                    <th>Non Inventory Vendor	</th>
                    <th>Location</th>
                    <th>Amount</th>
                    <th>Balance Due	</th>
                    <th>Supplier</th>
                    <th>SIPL Inv#	</th>
                    <th>SIPL Inv. Dt.	</th>
                    <th>SIPL Ship Dt.	</th>
                    <th>Container#	</th>
                    <th>SIPL Amount	</th>
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

@endsection
@section('scripts')
@include('freight_bill.__script')
@endsection
