@extends('layouts.admin')

@section('title', 'Purchase Order')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Purchase Order</h4>

    <div class="row mb-3">
      <div class="col">
        <div class="card pt-0 p-4">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>P.O.#</th>
                    <th>Date</th>
                    <th>Req. ShipDate</th>
                    <th>Age	</th>
                    <th>Supplier SO#</th>
                    <th>Inventory Supplier</th>
                    <th>Supplier Type</th>
                    <th>Container#	</th>
                    <th>Customer Reference	</th>
                    <th>Payment Terms	</th>
                    <th>Status	</th>
                    <th>Purchase Location		</th>
                    <th>Ship To		</th>
                    <th>Total	</th>
                    <th>Approval Status		</th>
                    <th>No. of Inv		</th>
                    <th>	</th>
                    <th>	</th>
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
@include('purchase_order.__scripts')
@include('purchase_order.product.__scripts')
@endsection
