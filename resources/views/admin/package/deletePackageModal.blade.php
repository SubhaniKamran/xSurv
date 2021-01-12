<div class="modal fade" id="deletePackageModal" tabindex="200" role="dialog" aria-labelledby="deletePackageModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePackageModalLabel">Delete</h5>
            </div>
            <div class="modal-body">
                <form action="" id="deletePackageForm">
                    <div class="form-row">
                        <div class="col-md-12 ">
                            <p style="font-size: 1.5em;">Are you sure you want to delete this package?</p>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="deletePackageId" id="deletePackageId" value="0" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="confirmAdminPackageDelete();" type="button">Delete</button>
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
