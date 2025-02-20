$(function () {
  var dataTableform = $('.datatables-details');
  var offModalForm = $('#addcommentModal');

  if (dataTableform.length) {
      var dt_form = dataTableform.DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url: baseUrl + 'details-list'
          },
          order: [[1, "desc"]],
          columns: [
              { data: '' }, // Responsive
              { data: 'id' }, // Form ID
              { data: 'user_name' }, // User name
              { data: 'user_email' }, // User email
              { data: 'form_name' }, // Form name
              { data: 'form_description' },
              { data: 'date' }, // Form description
              { data: 'action' } // Action buttons
          ],
          columnDefs: [
              {
                  className: 'control',
                  searchable: false,
                  orderable: false,
                  targets: 0,
                  render: function () { return ''; }
              },
              {
                  targets: 1,
                  render: function (data, type, full) {
                      return `<span>${full.fack_id}</span>`;
                  }
              },
              {
                  targets: 2,
                  render: function (data, type, full) {
                      return `<span>${full.user_name || 'N/A'}</span>`;
                  }
              },
              {
                  targets: 3,
                  render: function (data, type, full) {
                      return `<span>${full.user_email || 'N/A'}</span>`;
                  }
              },
              {
                  targets: 4,
                  render: function (data, type, full) {
                      return `<span>${full.form_name}</span>`;
                  }
              },
              {
                  targets: 5,
                  render: function (data, type, full) {
                      return `<span>${full.form_description}</span>`;
                  }
              },
              {
                target: 6,
                render: function (data, type, full) {
                    return `<span style="white-space: nowrap;">${full.date}</span>`;
                }
            },

              {
                  targets: -1,
                  title: 'Actions',
                  searchable: false,
                  orderable: false,
                  render: function (data, type, full) {
                      var urls = printRoute.replace(':id', full.id).replace(':user_id',full.user_id);
                      var chartsd = chart.replace(':id', full.form_id).replace(':user_id', full.user_id).replace(':details_id', full.id);
                      return (
                          '<div class="d-flex align-items-center gap-50">' +
                          `<a href="#" data-id="${full.id}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect btn-preview" title="Preview">
                              <i class="ri-eye-line ri-20px"></i>
                          </a>` +
                          `<a href="${urls}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Download">
                              <i class="ri-download-line ri-20px"></i>
                          </a>` +
                          `<a href="${chartsd}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Download Chart">
                              <i class="ri-bar-chart-box-line ri-20px"></i>
                          </a>` +
                          '</div>'
                      );
                  }
              }
          ]
      });
  }

  // ✅ Open modal when clicking "Preview" button
  $(document).on('click', '.btn-preview', function (e) {
    e.preventDefault();

    let detailsId = $(this).data('id'); // Get the details_id from the button

    $('#details_id').val(detailsId); // Set details_id in the form

    // Fetch the existing comment using AJAX
    $.ajax({
        url: `/comment/${detailsId}`, // Calls the Laravel route
        type: "GET",
        success: function (response) {
            $('#comment').val(response.comment); // Fill the textarea with the existing comment
        },
        error: function (xhr) {
            console.log("Error fetching comment:", xhr.responseText);
        }
    });

    $('#addcommentModal').modal('show'); // Show the modal
});

  // ✅ Handle form submission inside the modal
  $('#addformcomment').on('submit', function (e) {
      e.preventDefault(); // Prevent normal form submission

      $.ajax({
          data: $(this).serialize(),
          url: `${baseUrl}details-list`,
          type: 'POST',
          success: function (status) {
              dt_form.draw(); // Refresh DataTable
              offModalForm.modal('hide'); // Close modal

              // Show success message
              Swal.fire({
                  icon: 'success',
                  title: 'Successfully Added!',
                  text: 'Details Added Successfully.',
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });
          },
          error: function (err) {
              offModalForm.modal('hide');
              Swal.fire({
                  title: 'Oops!',
                  text: 'Something went wrong.',
                  icon: 'error',
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });
          }
      });
  });

});
