<div class="modal fade" id="editGeneralSettingsLogoModal" tabindex="200" role="dialog" aria-labelledby="editGeneralSettingsLogoModalLabel"
     aria-hidden="true">
     <form method="POST" id="editGeneralSettingsLogoModalForm" action="{{url('admin/settings/logo/update')}}" enctype="multipart/form-data">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editGeneralSettingsLogoModalLabel">Update</h5>
              </div>
              <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 ">
                      <div class="form-group mt-4">
                        @csrf
                        <label for="service_name">Update Logo</label>
                          <input id="editLogoUrl" type="file" class="form-control" name="editLogoUrl" accept="image/x-png,image/gif,image/jpeg" required>
                      </div>
                    </div>
                    {{--Hidden Field for Id--}}
                    <input type="hidden" name="editGeneralSettingsLogoId" id="editGeneralSettingsLogoId" value="0" />
                </div>
              </div>
              <div class="modal-footer">
                  <input type="submit" value="Update" name="Update" class="btn btn-gradient-primary">
                  <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
    </form>
</div>
