<div class="tab-pane fade show active" id="container" role="tabpanel">
    <div class="d-flex justify-content-between">
        <!-- Table for Display -->
        <div class="table-container" style="flex: 1; margin-right: 20px;">
        <table class="datatables-basic table tables-basic border-top table-striped" id="containerTable">
    <thead class="table-header-bold">
        <tr>
            <th>Serial</th>
            <th>Container Number</th>
            <th>Received By</th>
            <th>Received On</th>
            <th>Notes</th>
            <th>PO ID</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

        </div>

        <!-- Add Form Section -->
        <div class="add-form-container" style="flex: 1; max-width: 400px;">
            <h4>Add New Container</h4>
            <form id="addContainerForm">
                <div class="form-group">
                    <label for="containerNumber">Container Number</label>
                    <input type="text" class="form-control" id="container_number" name="container_number" required>
                    <input type="hidden" name="po_id" value="{{ $supplier_invoice->po_id}}" id="po_id">
                </div>
                <div class="form-group">
                    <label for="receivedBy">Received By</label>
                    <input type="text" class="form-control" id="received_by" name="received_by" required>
                </div>
                <div class="form-group">
                    <label for="receivedOn">Received On</label>
                    <input type="date" class="form-control" id="received_on" name="received_on" required>
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" id="notes" name="notes"></textarea>
                </div><br>
                <button type="submit" class="btn btn-primary" id="savedata" >Add Container</button>
            </form>
        </div>
    </div>
</div>
