<div class="modal fade" id="showSupplierInvoicePackingItemModal" tabindex="-1" aria-labelledby="show-supplier-invoice-packing-items-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-supplier-invoice-packing-items-modal-label">Show Supplier Invoice Packing Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSupplierInvoicePackingItemForm" name="showSupplierInvoicePackingItemForm" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <img src="{{ asset('public/images/intransit_large.png') }}" alt="Associate Icon" style="width: 100px; height: auto;margin-left:22px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field2" class="form-label pb-1">S.No : </label><br/>
                                <span class="bold" id="seq_no"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field3" class="form-label pb-1">Material : </label><br/>
                                <span class="bold" id="material"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field4" class="form-label pb-1">Location : </label><br/>
                                <span class="bold" id="location"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field3" class="form-label pb-1">Supplier : </label><br/>
                                <span class="bold" id="supplier"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field4" class="form-label pb-1">Type : </label><br/>
                                <span class="bold" id="type"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field3" class="form-label pb-1">Category - Sub Category : </label><br/>
                                <span class="bold" id="category"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field4" class="form-label pb-1">Group : </label><br/>
                                <span class="bold" id="group"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field3" class="form-label pb-1">SL Barcode Num : </label><br/>
                                <span class="bold" id="bar_code_no"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field3" class="form-label pb-1">Bundle : </label><br/>
                                <span class="bold" id="lot_block"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field3" class="form-label pb-1">Bundle : </label><br/>
                                <span class="bold" id="bundle"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field4" class="form-label pb-1">Supp. Ref : </label><br/>
                                <span class="bold" id="supplier_ref"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="notes" class="form-label pb-1">Notes : </label><br/>
                                <div class="flex" style="display: flex; align-items: center;">
                                    <input type="hidden" name="id" id="id">
                                    <textarea name="notes" id="notes" class="form-control" placeholder="Notes" style="flex: 1;" disabled>notes 123</textarea>
                                    <img src="http://localhost/sps-web/public/images/topbar_editbtn.png" alt="Edit Icon" id="editBtn" style="width: 30px; height: auto; margin-left: 10px;">
                                    <img src="http://localhost/sps-web/public/images/saveBtn.png" alt="Save Icon" id="saveBtn" style="width: 30px; height: auto; margin-left: 10px; display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Status</th>
                                <th>Dimensions</th>
                                <th>Area</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                              </tr>
                            </thead>
                            <tbody id="packingTableBody">
                            </tbody>
                          </table>
                    </div>
                    <div class="row mt-3">
                        <div class="table-container">
                            <h5>Price List </h5>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Price List</th>
                                    <th>Homeowner Price</th>
                                    <th>Bundle Price</th>
                                    <th>Special Price</th>
                                    <th>Loose Slab Price Per SQFT </th>
                                    <th>Bundle Price Per SQFT</th>
                                    <th>Special Price Per SQFT</th>
                                    <th>Owner Approval Price Per SQFT </th>
                                    <th>Loose Slab Price Per Slab</th>
                                    <th>Bundle Price Per Slab</th>
                                    <th>Special Price Per Slab</th>
                                    <th>Owner Approval Price Per Slab</th>
                                    <th>Price12</th>                              </tr>
                                </thead>
                                <tbody id="productsTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<style>
    .table-container {
    max-width: 100%;
    overflow-x: auto;
  }

  .table th, .table td {
    white-space: nowrap;
    padding: 8px;
    text-align: left;
  }

  /* Apply width for both th and td elements */
  .table th:nth-child(1),
  .table td:nth-child(1) { width: 150px; }

  .table th:nth-child(2),
  .table td:nth-child(2) { width: 150px; }

  .table th:nth-child(3),
  .table td:nth-child(3) { width: 150px; }

  .table th:nth-child(4),
  .table td:nth-child(4) { width: 200px; }

  .table th:nth-child(5),
  .table td:nth-child(5) { width: 200px; }

  /* .table th:nth-child(6),
  .table td:nth-child(6) { width: 200px; } */

  .table th:nth-child(7),
  .table td:nth-child(7) { width: 200px; }

  .table th:nth-child(8),
  .table td:nth-child(8) { width: 200px; }

  .table th:nth-child(9),
  .table td:nth-child(9) { width: 200px; }

  .table th:nth-child(10),
  .table td:nth-child(10) { width: 200px; }

  .table th:nth-child(11),
  .table td:nth-child(11) { width: 200px; }

  .table th:nth-child(12),
  .table td:nth-child(12) { width: 150px; }
</style>
