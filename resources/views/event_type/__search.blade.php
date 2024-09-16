<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Event Type : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="eventTypeNameFilter" placeholder="Event Type Name">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" id="eventTypeCodeFilter" placeholder="Event Type Code">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <select id="eventCategoryFilter" class="form-select select2" name="eventCategoryFilter[]" multiple >
                <option value="">--Select Event Category--</option>
                @foreach($eventCategories as $key => $eventCategory)
                <option value="{{ $key }}">{{ $eventCategory }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>&nbsp;
