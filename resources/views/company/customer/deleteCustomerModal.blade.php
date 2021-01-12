<div class="modal fade" id="deleteCustomerModal" tabindex="200" role="dialog" aria-labelledby="deleteCustomerModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCustomerModalLabel">Delete</h5>
            </div>
            <div class="modal-body">
                <form action="" id="deleteCustomerForm">
                    <div class="form-row">
                        <!-- Brand start here -->
                        <div class="col-md-12 ">
                            <p style="font-size: 1.5em;">Are you sure you want to delete this customer?</p>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="deleteCustomerId" id="deleteCustomerId" value="0" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="confirmDeleteCustomer();" type="button">Delete</button>
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
