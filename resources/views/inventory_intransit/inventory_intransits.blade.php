@extends('layouts.admin')

@section('title', 'In Transit')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>In Transit Inventory</h4>
    <div class="row mb-3">
      <div class="col">
        <div class="card pt-0 p-4">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>PO#</th>
                    <th>PO Date</th>
                    <th>PO ETA Date</th>
                    <th>Supplier SO#</th>
                    <th>SIPL#</th>
                    <th>Slabs</th>
                    <th>Quantity</th>
                    <th>Units</th>
                    <th>Location</th>
                    <th>Supplier</th>
                    <th>Freight Forwarder</th>
                    <th>Port ETA Date</th>
                    <th>ETA Date</th>
                    <th>Ship Date</th>
                    <th>Container#</th>
                    <th>Vessel</th>
                    <th>Customer/Loc/SO Ref.</th>
                    <th>Status</th>
                    <th>Sidemark</th>
                    <th>Supp./Pur. Note</th>
                    <th></th>
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
@include('inventory_intransit.__scripts')
@endsection
