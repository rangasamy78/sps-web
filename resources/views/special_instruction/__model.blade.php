<div class="modal fade" id="specialInstructionModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="specialInstructionForm" name="specialInstructionForm" class="form-horizontal">
                    <input type="hidden" name="special_instruction_id" id="special_instruction_id">
                    <div class="form-group mb-2 p-1">
                        <label for="product_kind_name" class="form-label pb-1">Special Instruction Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="special_instruction_name" name="special_instruction_name" placeholder="Enter Special Instruction Name" value="">
                        </div>
                        <span class="text-danger error-text special_instruction_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSpecialInstructionModel" tabindex="-1" aria-labelledby="showSpecialInstructionModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Special Instruction Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSpecialInstructionForm" name="showSpecialInstructionForm" class="form-horizontal">
                    <div class="form-group mb-2 p-1">
                        <label for="special_instruction_name" class="form-label pb-1">Special Instruction Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="special_instruction_name" name="special_instruction_name">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
