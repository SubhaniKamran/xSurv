<div class="modal fade" id="editEmailScheduleModal" tabindex="200" role="dialog" aria-labelledby="editEmailScheduleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmailScheduleModalLabel">Update</h5>
            </div>
            <div class="modal-body">
                <form action="" id="editEmailScheduleModalForm">
                    <div class="form-row">
                        <div class="col-md-12 ">
                          <div class="form-group mt-4">
                            <label for="service_name">Email Date</label>
                              <input id="edit_email_date" type="date" class="form-control" name="edit_email_date" min="{{ now()->toDateString('Y-m-d') }}">
                          </div>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="editCustomerServiceId" id="editCustomerServiceId" value="0" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" onclick="updateCustomerServiceEmailDate();" type="button">Update</button>
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
