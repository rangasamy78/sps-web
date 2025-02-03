<!-- Bootstrap Modal -->
<div class="modal fade" id="assignSlabItems" data-bs-backdrop="static" tabindex="-1" aria-labelledby="assignSlabItemsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="slabForm" name="slabForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignSlabItemsLabel">Assign selected inventory to other item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="assignSlabItemsMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .modal-header {
        border-bottom: 1px solid #dee2e6;
    }

    .modal-body {
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
    }
</style>
