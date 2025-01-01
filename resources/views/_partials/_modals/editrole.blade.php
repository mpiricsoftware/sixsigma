<!-- Role Cards -->
@if ($roles)
    @foreach ($roles as $role)
        <!-- Edit Role Modal -->
        <div class="modal fade" id="editRoleForm{{ $role->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body p-0">
                        <div class="text-center mb-6">
                            <h4 class="role-title mb-2 pb-0">Edit Role</h4>
                            <p>Update role details</p>
                        </div>
                        <!-- Edit role form -->
                        <form id="editRoleForm{{ $role->id }}" method="POST" action="{{ route('app-access-roles.update', ['id' => $role->id]) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="roleId" value="{{ $role->id }}">
                            <div class="col-12 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="modalRoleName{{ $role->id }}" name="modalRoleName" class="form-control" placeholder="Enter a role name" value="{{ $role->name }}" />
                                    <label for="modalRoleName{{ $role->id }}">Role Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 text-nowrap fw-medium">
                                    Administrator Access <i class="ri-information-line" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows full access to the system"></i>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 d-flex justify-content-end">
                                    <div class="form-check mb-0 mt-1">
                                        <input class="form-check-input" type="checkbox" id="selectAllEdit{{ $role->id }}" />
                                        <label class="form-check-label" for="selectAllEdit{{ $role->id }}">
                                            Select All
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 mt-2 ms-2">
                                @if ($permissions)
                                  @foreach ($permissions as $permission)
                                    <div class="col-xl-4 col-lg-4 col-md-4 form-check mb-0 mt-1">
                                      <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->name }}" id="edit-permission-{{ $permission->id }}"
                                        {{ in_array($permission->name, $rolePermissions[$role->id] ?? []) ? 'checked' : '' }} />
                                      <label class="form-check-label" for="edit-permission-{{ $permission->id }}">
                                        {{ $permission->name }}
                                      </label>
                                    </div>
                                  @endforeach
                                @endif
                            </div>
                            <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </form>
                        <!--/ Edit role form -->
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
<!--/ Edit Role Modal -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap tooltips
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => {
          new bootstrap.Tooltip(tooltip);
        });

        // Handle Select All checkboxes
        document.querySelectorAll('[id^="selectAllEdit"]').forEach(selectAllCheckbox => {
            const roleId = selectAllCheckbox.id.replace('selectAllEdit', '');
            const permissionCheckboxes = document.querySelectorAll(`#editRoleForm${roleId} input[name="permission[]"]`);

            selectAllCheckbox.addEventListener('change', function () {
                const isChecked = selectAllCheckbox.checked;
                permissionCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        });
    });
</script>
