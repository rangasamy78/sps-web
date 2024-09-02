<div class="modal fade" id="surveyQuestionModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="surveyQuestionForm" name="surveyQuestionForm" class="form-horizontal">
                    <input type="hidden" name="survey_question_id" id="survey_question_id">
                    <!-- Short Label -->
                    <div class="form-group">
                        <label class="col-sm-3 form-label">#Question <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="transaction_question_id" name="transaction_question_id"
                                value="1" readonly style="cursor: not-allowed !important">
                        </div>
                    </div>
                    <!-- Transaction -->
                    <div class="form-group  mt-3">
                        <label for="transaction" class="col-sm-3 form-label">Transaction <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <select id="transaction" class="form-select select2" name="transaction" data-allow-clear="true" onchange="getTransactiop(this)">
                                <option value="">--Select--</option>
                                @foreach($surveyQuestionOptions as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text transaction_error"></span>
                    </div>
                    <!-- Short Label -->
                    <div class="form-group mt-3">
                        <label class="col-sm-3 form-label">Short Label <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="short_label" name="short_label"
                                placeholder="Enter Short Label" value="">
                        </div>
                        <span class="text-danger error-text short_label_error"></span>
                    </div>
                    <!-- Survey Question -->
                    <div class="form-group mt-3">
                        <label class="col-sm-3 form-label">Question <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="question" name="question"
                                placeholder="Enter Question" value="">
                        </div>
                        <span class="text-danger error-text question_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Survey Question</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showSurveyQuestionModal" tabindex="-1" aria-labelledby="show-survey-question-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-survey-question-modal-label">Show Survey Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showSurveyQuestionForm" name="showSurveyQuestionForm" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 form-label">#Question</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="transaction_question_id" name="transaction_question_id" disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="Transaction" class="col-sm-4 form-label">Transaction</label>
                        <div class="col-sm-12">
                            <select id="transaction" class="form-select" name="transaction" disabled>
                                <option value="">--Select--</option>
                                @foreach($surveyQuestionOptions as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-4 form-label">Short label</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="short_label" name="short_label" disabled value="">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-4 form-label">Question</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="question" name="question" disabled value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>