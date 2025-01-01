'use strict';

document.addEventListener('DOMContentLoaded', function () {
  (function () {
    // AJAX setup with CSRF token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const addRoleModal = $('#addRoleModal');
    const editRoleModal = $('#editRoleModal');

    // Add Role Form Validation
    const addRoleFormValidation = FormValidation.formValidation(document.getElementById('addRoleForm'), {
      fields: {
        modalRoleName: {
          validators: {
            notEmpty: {
              message: 'Please enter role name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      $.ajax({
        data: $('#addRoleForm').serialize(),
        url: `${baseUrl}role-list`,
        type: 'POST',
        success: function (status) {
          addRoleModal.modal('hide');
          Swal.fire({
            icon: 'success',
            title: `Successfully ${status}!`,
            text: `Role ${status} successfully.`,
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          addRoleModal.modal('hide');
          Swal.fire({
            title: 'Duplicate Entry!',
            text: 'The role name should be unique.',
            icon: 'error',
            customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    });

    // Edit Role Form Validation
    const editRoleFormValidation = FormValidation.formValidation(document.getElementById('editRoleForm'), {
      fields: {
        roleName: {
          validators: {
            notEmpty: {
              message: 'Please enter role name'
            },
            remote: {
              url: `${baseUrl}roles/check-unique`,
              message: 'Role name already exists',
              async: true
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.mb-3'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      $.ajax({
        data: $('#editRoleForm').serialize(),
        url: $('#editRoleForm').attr('action'),
        type: 'PUT',
        beforeSend: function () {
          editRoleModal.find('.modal-body').append('<div class="loading-indicator">Loading...</div>');
        },
        success: function () {
          editRoleModal.find('.loading-indicator').remove();
          Swal.fire({
            icon: 'success',
            title: 'Role updated successfully!',
            text: 'The role has been updated.',
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          editRoleModal.find('.loading-indicator').remove();
          Swal.fire({
            title: 'Update Failed!',
            text: 'There was an error updating the role.',
            icon: 'error',
            customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    });

    // Fetch Role Data
    function fetchRoleData(roleId) {
      $.ajax({
        url: `${baseUrl}roles/${roleId}/edit`,
        type: 'GET',
        beforeSend: function () {
          editRoleModal.find('.modal-body').append('<div class="loading-indicator">Loading...</div>');
        },
        success: function (role) {
          $('#roleName').val(role.name);
          $('#roleId').val(role.id);
          $('#editRoleForm').attr('action', `${baseUrl}roles/${role.id}`);
          editRoleModal.modal('show');
        },
        error: function (xhr) {
          Swal.fire({
            title: 'Error!',
            text: 'Failed to fetch role data.',
            icon: 'error',
            customClass: { confirmButton: 'btn btn-danger' }
          });
        },
        complete: function () {
          editRoleModal.find('.loading-indicator').remove();
        }
      });
    }

    // Event listener for edit role modal
    $(document).on('click', '.role-edit-modal', function () {
      const roleId = $(this).data('role-id');
      fetchRoleData(roleId);
    });

    // Clearing form data when modals are hidden
    addRoleModal.on('hide.bs.modal', function () {
      addRoleFormValidation.resetForm(true);
    });
    editRoleModal.on('hide.bs.modal', function () {
      editRoleFormValidation.resetForm(true);
    });

    // Select All checkbox functionality
    const selectAll = document.querySelector('#selectAll');
    const checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener('change', (event) => {
      checkboxList.forEach((checkbox) => {
        checkbox.checked = event.target.checked;
      });
    });
  })();
});
