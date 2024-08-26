<div class="modal fade" id="unitMeasureModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="unitMeasureForm" name="unitMeasureForm" class="form-horizontal">
                    <input type="hidden" name="unit_measure_id" id="unit_measure_id">
                    <!-- Unit Measure Entity -->
                    <div class="form-group">
                        <label for="unit_measure_entity" class="pb-1 form-label">Unit Measure Entity <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select id="unit_measure_entity" class="form-select select2" name="unit_measure_entity" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($unitMeasureOptions as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text unit_measure_entity_error"></span>
                    </div>
                    <!-- Unit Measure -->
                    <div class="form-group mt-3">
                        <label class="pb-1 form-label">Unit Measure Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unit_measure_name" name="unit_measure_name"
                                placeholder="Enter Unit Measure Name" value="">
                        </div>
                        <span class="text-danger error-text unit_measure_name_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Unit Measure</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showUnitMeasureModal" tabindex="-1" aria-labelledby="show-unit-measure-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-unit-measure-modal-label">Show Unit of Measure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showUnitMeasureForm" name="showUnitMeasureForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="Unit Measure Entity" class="col-sm-4 form-label">Unit Measure Entity</label>
                        <div class="col-sm-12">
                            <select id="unit_measure_entity" class="form-select" name="unit_measure_entity" disabled>
                                <option value="">--Select--</option>
                                @foreach($unitMeasureOptions as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-4 form-label">Unit Measure Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unit_measure_name" name="unit_measure_name" disabled value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>