<div class="card">
    <div class="row g-3 mb-3 p-3">
        <label><b>Search Filters : </b></label>
        <div class="col-12 col-sm-6 col-lg-3">
            <select class="form-select select2" name="transactionFilter" id="transactionFilter" data-allow-clear="true">
                <option value="">Select Transaction</option>
                @foreach($surveyQuestionOptions as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="shortLabelFilter" id="shortLabelFilter" placeholder="Search Short Label">
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <input type="text" class="form-control dt-input dt-full-name" name="questionFilter" id="questionFilter" placeholder="Search Question">
        </div>
    </div>
</div>&nbsp;