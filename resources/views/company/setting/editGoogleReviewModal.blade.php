<div class="modal fade" id="editGoogleReviewUrlModal" tabindex="200" role="dialog" aria-labelledby="editGoogleReviewUrlModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGoogleReviewUrlModalLabel">Update</h5>
            </div>
            <div class="modal-body">
                <form action="" id="deleGoogleReviewModalForm">
                    <div class="form-row">
                        <!-- Brand start here -->
                        <div class="col-md-12 ">
                          <div class="form-group mt-4">
                            <label for="service_name">Google Place ID</label>
                              <input id="edit_google_url" type="text" class="form-control" name="edit_google_url">
                          </div>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="editGoogleReviewUrlId" id="editGoogleReviewUrlId" value="0" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" onclick="updateGoogleReviewUrl();" type="button">Update</button>
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
