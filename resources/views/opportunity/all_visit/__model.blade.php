<!-- Modal -->
<div class="modal fade" id="searchListVisitModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">List of Visits for Opportunity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="opportunity_id" name="opportunity_id">
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="visitListDataTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Date</th>
                                <th>Visit #</th>
                                <th>Visit Label</th>
                                <th>Helped at</th>
                                <th>Helped Cust</th>
                                <th>Checked at</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer">
                <!-- Footer content -->
            </div>
        </div>
    </div>
</div>