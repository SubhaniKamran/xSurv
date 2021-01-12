<div class="modal fade" id="deleteSurveyModal" tabindex="200" role="dialog" aria-labelledby="deletePolicyModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSurveyModalLabel">Delete</h5>
            </div>
            <div class="modal-body">
                <form action="" id="deleteSurveyForm">
                    <div class="form-row">
                        <!-- Brand start here -->
                        <div class="col-md-12 ">
                            <p style="font-size: 1.5em;">Are you sure you want to delete this survey?</p>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="deleteSurveyId" id="deleteSurveyId" value="0" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="confirmDeleteSurvey2();" type="button">Delete</button>
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>