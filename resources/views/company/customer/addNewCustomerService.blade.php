<div class="modal fade" id="addNewCustomerServiceModal" tabindex="200" role="dialog" aria-labelledby="addNewCustomerServiceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{url('customer/new/service/store')}}" id="addNewCustomerServiceForm" method="post">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewCustomerServiceModalLabel">Add Service</h5>
            </div>
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-12 ">
                  <div class="form-group">
                    <label for="email_date">Service</label>
                    <select name="service" id="_service" class="form-control" required>
                      <option></option>
                    </select>
                   </div>
                </div>
                <!-- <div class="col-md-12">
                  <div class="form-group">
                    <label for="email_date">Email Date</label>
                    <input id="email_date" type="date" class="form-control" name="email_date" min="{{ now()->toDateString('Y-m-d') }}">
                  </div>
                </div> -->
                {{--Hidden Field for Id--}}
                <input type="hidden" name="serviceCustomerId" id="serviceCustomerId" value="0" />
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Add">
              <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
      </form>
    </div>
</div>
