
document.addEventListener("DOMContentLoaded", function () {
  // Get all the buttons and forms
  const buttons = document.querySelectorAll('.btn-group .btn');
  const forms = document.querySelectorAll('.form-section');

  // By default, show the first form (Form A)
  document.getElementById('form-a').classList.add('active');

  // Event listener for buttons
  buttons.forEach(button => {
    button.addEventListener('click', function () {
      const targetForm = document.getElementById(this.getAttribute('data-target'));

      // Hide all forms
      forms.forEach(form => form.classList.remove('active'));

      // Show the selected form
      targetForm.classList.add('active');
    });
  });
});

