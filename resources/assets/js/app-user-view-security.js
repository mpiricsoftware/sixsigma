/**
 * App User View - Security
 */

'use strict';
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
(function () {
  const formChangePass = document.querySelector('#formChangePassword');

  // Form validation for Change password
  if (formChangePass) {
    const fv = FormValidation.formValidation(formChangePass, {
      fields: {
        newPassword: {
          validators: {
            notEmpty: {
              message: 'Please enter new password'
            },
            stringLength: {
              min: 8,
              message: 'Password must be more than 8 characters'
            }
          }
        },
        confirmPassword: {
          validators: {
            notEmpty: {
              message: 'Please confirm new password'
            },
            identical: {
              compare: function () {
                return formChangePass.querySelector('[name="newPassword"]').value;
              },
              message: 'The password and its confirm are not the same'
            },
            stringLength: {
              min: 8,
              message: 'Password must be more than 8 characters'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.form-password-toggle'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    });
  }
})();
// document.getElementById('submitBtn').addEventListener('click', function(event) {
//   var form = document.getElementById('formChangePassword');
//   event.preventDefault();
//   var newPassword = document.getElementById('newPassword').value;
//   var confirmPassword = document.getElementById('confirmPassword').value;
//   if (newPassword === '' || confirmPassword === '') {
//       alert('Password fields cannot be empty!');
//   } else if (newPassword === confirmPassword) {
//       Swal.fire({
//         icon: 'success',
//         title: 'Password Successfully Updated!',
//         text: 'Your password has been updated successfully.',
//         customClass: {
//           confirmButton: 'btn btn-success'
//         }
//       }).then(() => {

//       });
//   } else {

//       alert('Passwords do not match!');
//   }
// });

// document.getElementById('submitBtn').addEventListener('click', function(event) {
//   event.preventDefault();

//   // Get the password and confirm password values
//   const newPassword = document.getElementById('newPassword').value;
//   const confirmPassword = document.getElementById('confirmPassword').value;

//   // Check if passwords match
//   if (newPassword !== confirmPassword) {
//       alert('Passwords do not match');
//       return;
//   }

//   // Validate password strength (e.g., minimum length, uppercase & symbol)
//   const passwordStrengthRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
//   if (!passwordStrengthRegex.test(newPassword)) {
//       alert('Password must be at least 8 characters long, contain an uppercase letter and a special character.');
//       return;
//   }

//   // Create the form dynamically if you want to handle form submission via JavaScript
//   const form = document.createElement('form');

//   // Add CSRF token to the form
//   const csrfToken = document.createElement('input');
//   csrfToken.setAttribute('type', 'hidden');
//   csrfToken.setAttribute('name', '_token');
//   csrfToken.setAttribute('value', '{{ csrf_token() }}');
//   form.appendChild(csrfToken);

//   // Append the new password and confirm password values to the form
//   const newPasswordField = document.createElement('input');
//   newPasswordField.setAttribute('type', 'hidden');
//   newPasswordField.setAttribute('name', 'newPassword');
//   newPasswordField.setAttribute('value', newPassword);
//   form.appendChild(newPasswordField);

//   const confirmPasswordField = document.createElement('input');
//   confirmPasswordField.setAttribute('type', 'hidden');
//   confirmPasswordField.setAttribute('name', 'confirmPassword');
//   confirmPasswordField.setAttribute('value', confirmPassword);
//   form.appendChild(confirmPasswordField);

//   // Submit the form
//   document.body.appendChild(form);
//   form.submit();

//   // Show success message after form submission
//   Swal.fire({
//       icon: 'success',
//       title: 'Password Successfully Updated!',
//       text: 'Your password has been updated successfully.',
//       customClass: {
//           confirmButton: 'btn btn-success'
//       }
//   });
// });


