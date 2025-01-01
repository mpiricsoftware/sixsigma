<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 class="role-title mb-2 pb-0">Add New Role</h4>
          <p>Set role permissions</p>
        </div>
        <!-- Add role form -->
        <form id="addRoleForm" class="row g-3">
          <input type="hidden" name="RoleID" id="RoleID" value="">
          <div class="col-12 mb-3">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalRoleName" name="modalRoleName" class="form-control" placeholder="Enter a role name" tabindex="-1" />
              <label for="modalRoleName">Role Name</label>
            </div>
          </div>
          <div class="col-12">
            <h5 class="mb-6">Role Permissions</h5>
            <!-- Permission table -->
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 text-nowrap fw-medium">
                Administrator Access <i class="ri-information-line" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 d-flex justify-content-end">
                <div class="form-check mb-0 mt-1">
                  <input class="form-check-input" type="checkbox" id="selectAll" />
                  <label class="form-check-label" for="selectAll">
                    Select All
                  </label>
                </div>
              </div>
            </div>
            <div class="row mb-2 mt-2 ms-2">
            @if ($permissions)
              @foreach ($permissions as $permission)
                <div class="col-xl-4 col-lg-4 col-md-4 form-check mb-0 mt-1">
                  <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->name}}" id="permission-{{$permission->id}}" />
                  <label class="form-check-label" for="permission-{{$permission->id}}">
                    {{$permission->name}}
                  </label>
                </div>
              @endforeach
            @endif
            </div>
            <!-- Permission table -->
          </div>
          <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
        <!--/ Add role form -->
      </div>
    </div>
  </div>
</div>
<!--/ Add Role Modal -->
