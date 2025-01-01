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
//   event.preventDefault();  // Prevent form submission

//   // Get the password and confirm password values from the form
//   const form = document.getElementById('formChangePassword');
//   const newPassword = form.querySelector('#newPassword').value;
//   const confirmPassword = form.querySelector('#confirmPassword').value;

//   // Check if passwords match
//   if (newPassword !== confirmPassword) {
//       alert('Passwords do not match');
//       return;
//   }

//   // Validate password strength (e.g., minimum length, uppercase & symbol)
//   const passwordStrengthRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
//   if (!passwordStrengthRegex.test(newPassword)) {
//       alert('Password must be at least 8 characters long, contain an uppercase letter, and a special character.');
//       return;
//   }

//   // Prepare the form data
//   const formData = new FormData();
//   formData.append('_token', '{{ csrf_token() }}');  // Add CSRF token

//   // Get the user ID from the hidden input field within the form
//   const userId = form.querySelector('#user_id').value;

//   if (!userId) {
//       alert("User  ID is missing or invalid.");
//       return;  // Exit if user ID is not found or is empty
//   }

//   formData.append('id', userId);  // Append the user ID to the form data
//   formData.append('newPassword', newPassword);  // Add the new password to form data

//   // Send the form data to the backend via AJAX (PUT request for updating)
//   fetch(`/user-list/${userId}`, {
//       method: 'PUT',  // Use PUT request for updating
//       body: formData  // Include form data with the request
//   })
//   .then(response => {
//       // Check if the response is OK (status in the range 200-299)
//       if (!response.ok) {
//           throw new Error('Network response was not ok');
//       }
//       return response.json();  // Parse JSON response
//   })
//   .then(data => {
//       if (data === 'Updated') {
//           Swal.fire({
//               icon: 'success',
//               title: 'Password Successfully Updated!',
//               text: 'Your password has been updated successfully.',
//               customClass: {
//                   confirmButton: 'btn btn-success'
//               }
//           });
//       } else {
//           Swal.fire({
//               icon: 'error',
//               title: 'Error!',
//               text: 'Something went wrong. Please try again.',
//               customClass: {
//                   confirmButton: 'btn btn-danger'
//               }
//           });
//       }
//   })
//   .catch(error => {
//       Swal.fire({
//           icon: 'error',
//           title: 'Error!',
//           text: 'There was an error while submitting the form. Please try again.',
//           customClass: {
//               confirmButton: 'btn btn-danger'
//           }
//       });
//       console.error('Error:', error);  // Log the error for debugging
//   });
// });


document.getElementById('submitBtn').addEventListener('click', function(event) {
  event.preventDefault();

  const form = document.getElementById('formChangePassword');
  const userId = form.querySelector('input[name="id"]').value;
  const newPassword = document.getElementById('newPassword').value;
  const confirmPassword = document.getElementById('confirmPassword').value;
  if (newPassword !== confirmPassword) {
      alert('Passwords do not match.');
      return;
  }

  // const url = `/user-list/${userId}`;
  $.ajax({
      url: `/user-list/reserpass`,
      type: 'POST',
      data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id: userId,
          newPassword: newPassword,
          newPassword_confirmation: confirmPassword,
      },
      success: function(response) {

        $('#message-container').html(response.message || 'Password updated successfully!');
        $('.alert-success').css('display', 'block');
        setTimeout(function(){
          $('.alert-success').hide();
        },1000);

    },
      error: function(xhr, status, error) {

          const errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to update password.';
          alert(errorMessage);
      }
  });

});




